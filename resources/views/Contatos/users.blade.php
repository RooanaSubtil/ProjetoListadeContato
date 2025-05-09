<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gestão de Usuários</h1>

    <!-- Formulário para Criar/Atualizar Usuário -->
    <form id="userForm" method="POST">
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
        <!-- Aqui você vai inserir a lista de usuários -->
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

    // Função para editar um usuário
    function editUser(userId) {
        // Aqui você poderia preencher o formulário com os dados do usuário selecionado
        // Exemplo de preenchimento (supondo que você tenha as variáveis do usuário em um JavaScript, isso pode ser feito por uma requisição Ajax)
        fetch(`/users/${userId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("name").value = data.user.name;
                document.getElementById("email").value = data.user.email;
                document.getElementById("cpf").value = data.user.cpf;
                form.action = `/users/atualizar/${userId}`; // Atualiza a URL de ação do formulário para a atualização
                form.method = "POST"; // O método do formulário será POST
            });
    }

    // Função para excluir um usuário
    function deleteUser(userId) {
        if (confirm("Tem certeza que deseja excluir este usuário?")) {
            fetch(`/users/${userId}`, {
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

    // Submissão do formulário para criar ou atualizar um usuário
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        // Faz a requisição para criar ou atualizar o usuário
        fetch(form.action, {
            method: form.method,
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.mensagem) {
                    alert(data.mensagem);
                    // Adicionar o novo usuário na lista ou atualizar a lista
                    // Para simplificar, o formulário apenas reinicializa para criar um novo usuário
                    form.reset();
                }
            })
            .catch(error => console.error('Erro:', error));
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
