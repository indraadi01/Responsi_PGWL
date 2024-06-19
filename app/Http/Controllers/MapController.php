<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $data = [
            "title" => "Indra's Map",
        ];

        //Check if user is login
        if (auth()->check() ) {
            return view('index', $data);
        } else{
            return view('index-public', $data);
        }
    }
    public function landingpage()
    {
        $data = [
            "title" => "Indra's Map",
        ];

            return view('landing', $data);

    }
    public function table()
    {
        $data = [
            "title" => "Table",
        ];
        return view('table', $data);
    }
}
