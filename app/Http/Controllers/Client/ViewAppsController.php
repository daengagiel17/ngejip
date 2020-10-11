<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewAppsController extends Controller
{
    public function term()
    {
        return view('client/apps/term');
    }

    public function privacy()
    {
        return view('client/apps/privacy');
    }
}