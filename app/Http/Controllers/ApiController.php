<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    //
    public function fetchAdmin()
    {
        //ganti sama geosermu ndra
        $wfsUrl = "http://localhost:8443/geoserver/pgwebl_resp2/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=pgwebl_resp2%3AAdminKec&outputFormat=application%2Fjson";

        try {
            $response = Http::withoutVerifying()->get($wfsUrl);

            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Failed to fetch data from NASA FIRMS'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
    public function fetchPL()
    {
        //ganti sama geosermu ndra
        $wfsUrl = "http://localhost:8443/geoserver/pgwebl_resp2/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=pgwebl_resp2%3Apenggunaan_lahan&outputFormat=application%2Fjson";

        try {
            $response = Http::withoutVerifying()->get($wfsUrl);

            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Failed to fetch data from NASA FIRMS'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
    public function fetchPend()
    {
        //ganti sama geosermu ndra
        $wfsUrl = "http://localhost:8443/geoserver/pgwebl_resp2/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=pgwebl_resp2%3Apenggunaan_lahan&outputFormat=application%2Fjson";

        try {
            $response = Http::withoutVerifying()->get($wfsUrl);

            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Failed to fetch data from NASA FIRMS'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
