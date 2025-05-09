<!DOCTYPE html>
<html>
    <head>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>
        <title>Lista de Contatos</title>

        <style>
            /* Estilo para garantir que a lista e o mapa fiquem lado a lado */
            .container {
                display: flex;
                gap: 20px;
            }

            .contatos-list {
                width: 30%;
                max-height: 500px;
                overflow-y: auto;
            }

            #map {
                height: 500px;
                width: 70%;
            }

            .contato-card {
                cursor: pointer;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 10px;
                margin-bottom: 10px;
                background-color: #f9f9f9;
            }

            .detalhes {
                display: none;
                margin-top: 10px;
                padding-left: 10px;
                background-color: #f0f0f0;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                border-radius: 5px;
            }
        </style>
    </head>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: { lat: -14.2350, lng: -51.9253 } // Centro do Brasil como padrão
            });

            @foreach ($contatos as $contato)
            @php
                $coords = explode(',', $contato->posicao_geografica);
                $lat = floatval(trim($coords[0]));
                $lng = floatval(trim($coords[1]));
            @endphp

            new google.maps.Marker({
                position: { lat: {{ $lat }}, lng: {{ $lng }} },
                map: map,
                title: "{{ $contato->nome }}"
            });
            @endforeach
        }

        window.onload = initMap;

        function toggleDetalhes(element) {
            const detalhes = element.querySelector('.detalhes');

            if (detalhes.style.display === 'none') {
                detalhes.style.display = 'block';
            } else {
                detalhes.style.display = 'none';
            }
        }
    </script>
    <body>
        <h1>Contatos</h1>

        <div class="container">
            <div class="contatos-list">
                @foreach ($contatos as $contato)
                    <div class="contato-card" onclick="toggleDetalhes(this)">
                        <strong>{{ $contato->nome }}</strong>
                        <div class="detalhes">
                            <div><strong>CPF:</strong> {{ $contato->cpf }}</div>
                            <div><strong>Telefone:</strong> {{ $contato->telefone }}</div>
                            <div><strong>Logradouro:</strong> {{ $contato->logradouro }}</div>
                            <div><strong>Número:</strong> {{ $contato->numero }}</div>
                            <div><strong>Complemento:</strong> {{ $contato->complemento }}</div>
                            <div><strong>Bairro:</strong> {{ $contato->bairro }}</div>
                            <div><strong>Cidade:</strong> {{ $contato->cidade }}</div>
                            <div><strong>Estado:</strong> {{ $contato->estado }}</div>
                            <div><strong>CEP:</strong> {{ $contato->cep }}</div>
                            <div><strong>Posição Geográfica:</strong> {{ $contato->posicao_geografica }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="map"></div>
        </div>
    </body>
</html>
