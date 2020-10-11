<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewWebController extends Controller
{
    public function about()
    {
        return view('client/web/about');
    }

    public function contact()
    {
        return view('client/web/contact');
    }

    public function faq()
    {
        return view('client/web/faq');
    }

    public function karir()
    {
        return view('client/web/karir');
    }

    public function privacy()
    {
        return view('client/web/privacy');
    }

    public function term()
    {
        return view('client/web/term');
    }
        
}