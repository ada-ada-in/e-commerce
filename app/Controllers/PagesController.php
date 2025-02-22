<?php

namespace App\Controllers;

class PagesController extends BaseController
{
    public function admin(): string
    {
        return view('layouth/admin_layout');
    }
    public function suratMasuk(): string
    {
        return view('pages/surat-masuk');
    }
    public function suratKeluar(): string
    {
        return view('pages/surat-keluar');
    }
}
