<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSalvarComDadosValidos()
    {
        // Dados válidos para o teste
        $data = [
            'name' => 'Teste Usuario',
            'email' => 'teste@example.com',
            'cpf' => '111.444.777-35',
            'password' => 'senha123',
        ];

        $response = $this->post('/user/salvar', $data);

        // Verifica se a resposta é a esperada
        $response->assertStatus(201);
        $response->assertJsonFragment(['mensagem' => 'Usuário salvo com sucesso']);

        // Verifica se o usuário foi realmente salvo no banco de dados
        $this->assertDatabaseHas('users', [
            'email' => 'teste@example.com',
            'cpf' => '111.444.777-35',
        ]);
    }

    public function testSalvarComDadosInvalidos()
    {
        $data = [
            'email' => 'invalido', // inválido
            'cpf' => '',           // inválido
        ];

        $response = $this->post('/user/salvar', $data);

        // Verifica se a resposta é de erro
        $response->assertStatus(422); // Código HTTP de erro de validação
        $response->assertJsonValidationErrors(['email', 'cpf']);
    }
}

