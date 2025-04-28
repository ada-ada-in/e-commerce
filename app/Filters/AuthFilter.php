<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // tidak login redirect ke /
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // user login redirect ke /user
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/user'); 
        }

        // admin login redirect ke /admin/dashboard
        
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu ada proses setelah request di filter ini
    }
}
