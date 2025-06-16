<?php

namespace App\Controllers;

class PagesController extends BaseController
{

    // admin

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
    public function category(): string {
        return view('pages/category');
    }
    public function paid(): string {
        return view('pages/paid');
    }   
    public function pending(): string {
        return view('pages/pending');
    }
    public function cancel(): string {
        return view('pages/cancel');
    }
    public function data(): string {
        return view('pages/data');
    }
    public function order(): string {
        return view('pages/order');
    }
    public function send(): string {
        return view('pages/send');
    }
    public function pickup(): string {
        return view('pages/pickup');
    }   
    public function report(): string {
        return view('pages/report');
    }
    public function users(): string {
        return view('pages/users');
    }
    public function profile(): string {
        return view('pages/profile');
    }
    public function complete(): string {
        return view('pages/complete-delivery');
    }

    // auth

    public function login(): string {
        return view('auth/login');
    }
    public function register(): string {
        return view('auth/register');
    }


    // user

    public function user(): string {
        return view('pages/user/main');
    }
    public function userProfile(): string {
        return view('pages/user/profile');
    }
    public function payment(): string {
        return view('pages/user/payment');
    }
    public function delivery(): string {
        return view('pages/user/delivery');
    }
    public function inventory(): string {
        return view('pages/user/inventory');
    }
    public function checkout(): string {
        return view('pages/user/checkout');
    }
    public function about(): string {
        return view('pages/user/about');
    }
    public function productCategory(): string {
        return view('pages/user/porductCategory');
    }
    public function allcategory(): string {
        return view('pages/user/allcategory');
    }
    public function allproduct(): string {
        return view('pages/user/allproduct');
    }
    
}
