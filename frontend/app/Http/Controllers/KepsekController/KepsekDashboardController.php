<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KepsekDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}
