<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CountriesController extends Controller
{
    public function index()
    {
        try {
            // guardar as informações da api no Cache por 60 minutos
            $formatted = Cache::remember('countries.all', 60, function () {
                $response = Http::timeout(30)->retry(3, 100)->get('https://restcountries.com/v3.1/all');
                
                if ($response->successful()) {
                    $countries = $response->json();
                    
                    // Formata os dados: nome, código ISO e código de telefone
                    $formatted = array_map(function ($country) {
                        $phone = null;
                        if (isset($country['idd']['root'])) {
                            $phone = $country['idd']['root'];
                            // Se houver um sufixo não vazio, adiciona-o
                            if (isset($country['idd']['suffixes'][0]) && !empty($country['idd']['suffixes'][0])) {
                                $phone .= $country['idd']['suffixes'][0];
                            }
                        }
                        return [
                            'name'  => $country['name']['common'] ?? null,
                            'code'  => $country['cca2'] ?? null,
                            'phone' => $phone,
                        ];
                    }, $countries);
                    
                    // Ordena os países em ordem alfabética pelo nome
                    usort($formatted, function ($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    });
                    
                    return $formatted;
                }
                
                // Em caso de falha, retorna um array vazio
                return [];
            });

            return response()->json($formatted);
        } catch (\Exception $e) {
            \Log::error('Erro na chamada da API de países: ' . $e->getMessage());
            return response()->json(['error' => 'Erro na chamada da API: ' . $e->getMessage()], 500);
        }
    }
}
