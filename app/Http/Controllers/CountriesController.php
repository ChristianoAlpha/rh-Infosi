<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountriesController extends Controller
{
    public function index()
    {
        // Requisição GET para a API de países
        $response = Http::get('https://restcountries.com/v3.1/all');
        
        if ($response->successful()) {
            $countries = $response->json();
            
            // Formata os dados para retornar apenas o nome e o código
            $formatted = array_map(function ($country) {
                return [
                    'name' => $country['name']['common'] ?? null,
                    'code' => $country['cca2'] ?? null,
                ];
            }, $countries);
            
            // Ordena o array em ordem alfabética pelo nome
            usort($formatted, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            
            return response()->json($formatted);
        }
        
        return response()->json(['error' => 'Não foi possível buscar os países'], 500);
    }
}
