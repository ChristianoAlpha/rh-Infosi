<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountriesController extends Controller
{
    public function index()
    {
        $response = Http::get('https://restcountries.com/v3.1/all');

        if ($response->successful()) {
            $countries = $response->json();
            
            // Formata os dados, incluindo nome, código ISO e código de telefone
            $formatted = array_map(function ($country) {
                $phone = null;
                if(isset($country['idd']['root'])) {
                    $phone = $country['idd']['root'];
                    // Se existir um sufixo QUE é não vazio, vai adicionar
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
            
            // vai Ordenar os países em ordem alfabética pelo nome
            usort($formatted, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            
            return response()->json($formatted);
        }
        
        return response()->json(['error' => 'Não foi possível buscar os países'], 500);
    }
}
