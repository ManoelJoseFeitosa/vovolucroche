<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShippingService
{
    public function calculate($zipcode, $cart)
    {
        // Limpa o CEP (deixa só números)
        $zipcode = preg_replace('/[^0-9]/', '', $zipcode);
        $fromZip = env('MELHORENVIO_FROM_POSTAL_CODE', '64000000'); // Seu CEP de origem

        $options = [];

        // ---------------------------------------------------------
        // REGRA 1: TERESINA (Motoboy)
        // Faixa de CEP de Teresina: 64000-000 até 64099-999
        // ---------------------------------------------------------
        if (str_starts_with($zipcode, '640')) {
            return [
                [
                    'name' => 'Motoboy (Teresina)',
                    'price' => 15.00, // Preço fixo do motoboy
                    'days' => 1,      // Entrega no mesmo dia ou dia seguinte (após confecção)
                    'company' => 'Local'
                ],
                [
                    'name' => 'Retirar no Local',
                    'price' => 0.00,
                    'days' => 0,
                    'company' => 'Local'
                ]
            ];
        }

        // ---------------------------------------------------------
        // REGRA 2: MELHOR ENVIO (API) - Para fora de Teresina
        // ---------------------------------------------------------
        try {
            // Prepara os produtos para o formato que a API exige
            $productsPayload = [];
            foreach ($cart as $item) {
                $productsPayload[] = [
                    "id" => (string) ($item['id'] ?? '1'),
                    "width" => 15,  // Largura padrão (cm) se não tiver no banco
                    "height" => 15, // Altura padrão (cm)
                    "length" => 20, // Comprimento padrão (cm)
                    "weight" => isset($item['weight']) ? ($item['weight'] / 1000) : 0.5, // Peso em KG (ex: 300g vira 0.3)
                    "insurance_value" => (float) $item['price'], // Valor para seguro
                    "quantity" => (int) $item['quantity']
                ];
            }

            // Faz a chamada para o Melhor Envio
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env('MELHORENVIO_TOKEN'),
                'User-Agent' => 'Vovo Lu Croche (seuemail@gmail.com)' // Identificação obrigatória
            ])->post(env('MELHORENVIO_URL'), [
                "from" => [
                    "postal_code" => $fromZip
                ],
                "to" => [
                    "postal_code" => $zipcode
                ],
                "products" => $productsPayload,
                "options" => [
                    "receipt" => false, // Aviso de recebimento (AR) encarece, deixei false
                    "own_hand" => false // Mão própria encarece, deixei false
                ]
            ]);

            if ($response->successful()) {
                $freights = $response->json();
                
                // Filtra apenas as transportadoras que queremos (Correios e Jadlog)
                // e que não tenham erro
                foreach ($freights as $freight) {
                    if (isset($freight['price']) && !isset($freight['error'])) {
                        
                        // Opcional: Filtro para mostrar apenas SEDEX, PAC e Jadlog
                        // IDs comuns: 1 (PAC), 2 (SEDEX), 3 (Jadlog Package), 4 (Jadlog.com)
                        // Se quiser mostrar todos, remova o IF abaixo.
                        if (in_array($freight['company']['id'], [1, 2, 3, 4])) { 
                            $options[] = [
                                'name' => $freight['company']['name'] . ' - ' . $freight['name'],
                                'price' => (float) $freight['price'],
                                'days' => (int) $freight['delivery_time'],
                                'company' => $freight['company']['name']
                            ];
                        }
                    }
                }
            } else {
                // Se der erro na API, retorna vazio ou loga o erro
                // \Log::error('Erro Melhor Envio: ' . $response->body());
            }

        } catch (\Exception $e) {
            // Em caso de falha de conexão, não quebra o site
            return [];
        }

        return $options;
    }
}
