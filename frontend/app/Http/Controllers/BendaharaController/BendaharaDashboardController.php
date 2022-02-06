<?php

namespace App\Http\Controllers\BendaharaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BendaharaDashboardController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
