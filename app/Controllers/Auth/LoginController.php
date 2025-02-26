<?php
namespace App\Controllers\Auth;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class LoginController extends ResourceController {
    public function login() {
        try {
            helper(['form']);

            if ($this->request->getMethod() !== 'post') {
                return $this->fail('Invalid request method: ' . $this->request->getMethod(), 405);
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'id'   => $user['id'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ]);

                return $this->respondCreated([
                    'status'  => 'success',
                    'message' => 'Login berhasil',
                    'data'    => [
                        'id'       => $user['id'],
                        'role'     => $user['role'],
                        'username' => $user['username']
                    ]
                ]);
            } else {
                return $this->failUnauthorized('Invalid username or password');
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function logout() {
        session()->destroy();
        return $this->respond([
            'status'  => 'success',
            'message' => 'Logout berhasil'
        ]);
    }
}
?>
