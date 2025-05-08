<?php

namespace Database\Factories;

use App\Models\Contatos;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Http;

class ContatosFactory extends Factory
{
    protected $model = Contatos::class;

    public function definition()
    {
        $faker = FakerFactory::create('pt_BR');

        $cep = $faker->postcode;

        $response = Http::withoutVerifying()->get("https://viacep.com.br/ws/{$cep}/json/");

        $enderecoCep = $response->successful() ? $response->json() : [];

        $logradouro = $enderecoCep['logradouro'] ?? $faker->streetAddress;
        $bairro = $enderecoCep['bairro'] ?? $faker->city;
        $cidade = $enderecoCep['localidade'] ?? $faker->city;
        $estado = $enderecoCep['estado'] ?? $faker->state;
        $numero = $enderecoCep['unidade'] ?? $faker->buildingNumber;
        $complemento = $enderecoCep['complemento'] ?? '';

        $coordenadas = $this->getCoordinates($logradouro, $bairro, $cidade, $estado);
        $latitude = $coordenadas['latitude'];
        $longitude = $coordenadas['longitude'];

        return [
            'nome' => $faker->name,
            'cpf' => $faker->unique()->numerify('###.###.###-##'),
            'telefone' => $faker->phoneNumber,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'complemento' => $complemento,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep,
            'posicao_geografica' => "{$latitude}, {$longitude}",
        ];
    }

    // Função para obter as coordenadas latitude e longitude de um endereço
    private function getCoordinates($logradouro, $bairro, $cidade, $estado)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $address = urlencode("{$logradouro}, {$bairro}, {$cidade}, {$estado}, Brasil");

        $response = Http::withoutVerifying()->get("https://maps.googleapis.com/maps/api/geocode/json", [
            'address' => $address,
            'key' => $apiKey,
        ]);

        if ($response->successful()) {

            $location = $response->json()['results'][0]['geometry']['location'] ?? null;
            if ($location) {
                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                ];
            }
        }else {
            echo "Erro na requisição. Status: " . $response->status() . "\n";
            echo "Mensagem de erro: " . $response->body() . "\n";
        }
        return [
            'latitude' => 0,
            'longitude' => 0,
        ];
    }

}
