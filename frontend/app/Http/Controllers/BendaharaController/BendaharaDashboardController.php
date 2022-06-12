<?php

namespace App\Http\Controllers\BendaharaController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BendaharaDashboardController extends Controller
{
    public function index()
    {
        return redirect(route('bendahara.alokasi_dana.index'));
    }
}
