<?php

namespace App\Controllers;

class PagesController extends BaseController
{
    public function admin(): string
    {
        return view('pages/dashboard');
    }
    public function suratMasuk(): string
    {
        return view('pages/surat-masuk');
    }
    public function suratKeluar(): string
    {
        return view('pages/surat-keluar');
    }
    public function pengguna(): string
    {
        return view('pages/pengguna');
    }
    public function disposisi(): string
    {
        return view('pages/disposisi');
    }
    public function arsip(): string
    {
        return view('pages/arsip');
    }
    public function profile(): string 
    {
        return view('pages/profile');
    }


    // auth
    public function login(): string
    {
        return view('auth/login');
    }
    public function register(): string {
        return view('auth/register');
    }
}
