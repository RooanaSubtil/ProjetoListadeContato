<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContatoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->withoutMiddleware(); // opcional, para evitar problemas com autenticação

        $response = $this->get('/contatos/listar');

        $response->assertStatus(200);
    }
}
