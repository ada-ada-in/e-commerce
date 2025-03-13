<?php

namespace App\Controllers;

class PagesController extends BaseController
{
    public function admin(): string
    {
        return view('layouth/main_layout');
    }
    public function dashboard(): string
    {
        return view('pages/dashboard');
    }
    public function product(): string
    {
        return view('pages/product');
    }
}
