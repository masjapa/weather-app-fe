<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function getDataWeather(Request $request) {
    $response = Http::get('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml');
    $parse = simplexml_load_string($response);
    $encode = json_encode($parse);
    $decode = json_decode($encode, TRUE);
    $areas = $decode['forecast']['area'] ?? [];
    return Inertia::render('Welcome', [
      'data' => $areas
    ]);
  }
}
