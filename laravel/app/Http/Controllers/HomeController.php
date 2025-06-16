<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'internetServices' => Service::where('type_services', 'Домашний интернет')->get(),
            'tvServices' => Service::where('type_services', 'Спутниковое ТВ')->get(),
            'mobileServices' => Service::where('type_services', 'Мобильные услуги')->get()
        ]);
    }
}
