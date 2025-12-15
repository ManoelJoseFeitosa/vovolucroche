<?php

namespace App\Services;

class ShippingService
{
    public function calculate($zipcode, $cartItems)
    {
        // Limpa o CEP (remove traço)
        $cep = preg_replace('/[^0-9]/', '', $zipcode);
        
        // Calcula o peso total do carrinho
        $totalWeight = 0;
        foreach($cartItems as $item) {
            // Se o produto não tiver peso cadastrado, assumimos 500g (0.5kg)
            $weight = $item['weight'] ?? 0.500; 
            $totalWeight += $weight * $item['quantity'];
        }

        $options = [];

        // Lógica para Teresina - PI (Faixa de CEP 64000-000 até 64099-999)
        if ($cep >= 64000000 && $cep <= 64099999) {
            
            $options[] = [
                'code' => 'pickup',
                'name' => 'Retirada no Local (Bairro X)',
                'price' => 0.00,
                'days' => 0
            ];

            $options[] = [
                'code' => 'motoboy',
                'name' => 'Entrega via Motoboy',
                'price' => 15.00, // Preço fixo local
                'days' => 1
            ];

        } else {
            // Lógica para Outras Cidades (Simulação Correios)
            // Custo Base R$ 25,00 + R$ 10,00 por Kg
            $pacPrice = 25.00 + ($totalWeight * 10.00);
            $sedexPrice = 40.00 + ($totalWeight * 18.00);

            $options[] = [
                'code' => 'pac',
                'name' => 'Correios - PAC',
                'price' => $pacPrice,
                'days' => 7 // Estimativa
            ];

            $options[] = [
                'code' => 'sedex',
                'name' => 'Correios - SEDEX',
                'price' => $sedexPrice,
                'days' => 3 // Estimativa
            ];
        }

        return $options;
    }
}
