<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gestão de Usuários</h1>
    <form id="userForm" method="POST" action="/user/salvar">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <hr>

    <h3>Usuários Cadastrados</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody id="userList">
        @foreach($users as $user)
            <tr id="user_{{ $user->id }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->cpf }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editUser({{ $user->id }})">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">Excluir</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    const form = document.getElementById("userForm");
    const csrfToken = document.querySelector('meta[name="csrf-token"]');

    function editUser(userId) {
        fetch(`/user/${userId}`)
            .then(response => {
                if (!response.ok) throw new Error('Erro ao buscar usuário.');
                return response.json();
            })
            .then(data => {
                const user = data.user;
                if (!user) {
                    alert('Usuário não encontrado.');
                    return;
                }

                document.getElementById("name").value = user.name;
                document.getElementById("email").value = user.email;
                document.getElementById("cpf").value = user.cpf;
                document.getElementById("password").value = ""; // Senha não é preenchida

                const actionUrl = `/user/atualizar/${userId}`;
                form.setAttribute('action', actionUrl);

                const oldMethod = form.querySelector('input[name="_method"]');
                if (oldMethod) oldMethod.remove();

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                form.setAttribute('method', 'POST');
            })
            .catch(error => {
                console.error(error);
                alert('Erro ao carregar dados do usuário.');
            });
    }

    function deleteUser(userId) {
        if (confirm("Tem certeza que deseja excluir este usuário?")) {
            fetch(`/user/excluir/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`user_${userId}`).remove(); // Remove o usuário da lista
                    } else {
                        alert("Erro ao excluir o usuário.");
                    }
                });
        }
    }

    function carregarUsuarios() {
        fetch('/user/listar', {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Erro ao carregar usuários');
                    });
                }
                return response.json();
            })
            .then(data => {
                const userList = document.getElementById("userList");
                userList.innerHTML = ''; // Limpa a lista antes de preencher

                data.users.forEach(user => {
                    const row = document.createElement("tr");
                    row.id = `user_${user.id}`;
                    row.innerHTML = `
                                        <td>${user.name}</td>
                                        <td>${user.email}</td>
                                        <td>${user.cpf}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Editar</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Excluir</button>
                                        </td>
                                    `;
                    userList.appendChild(row);
                });
            })
            .catch(error => {
                alert('Erro ao carregar usuários');
            });
    }

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                alert(data.mensagem);
                form.reset();

                const oldMethod = form.querySelector('input[name="_method"]');
                if (oldMethod) oldMethod.remove();
                form.action = '/user/salvar';
            })
            .catch(error => {
                if (error.errors) {
                    let mensagens = Object.values(error.errors).flat().join('\n');
                    alert('Erros de validação:\n' + mensagens);
                } else if (error.error) {
                    alert('Erro do servidor: ' + error.error);
                } else {
                    alert('Erro inesperado. Veja o console.');
                }
            });

        carregarUsuarios();
    });

    window.addEventListener('DOMContentLoaded', carregarUsuarios);

</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
