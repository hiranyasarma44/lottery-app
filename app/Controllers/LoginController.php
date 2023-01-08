<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function index()
    {
        // echo password_hash('1234', PASSWORD_DEFAULT);
        helper(['form']);
        echo view('login');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = $userModel->where('email', $email)->first();
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => true
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/login');
        }
    }

    public function dashboard()
    {
        echo view('admin/dashboard/index');
    }

    public function logout()
    {
        $session = session();
        $session->set([
            'id' => '',
            'name' => '',
            'email' => '',
            'isLoggedIn' => false
        ]);
        $session->destroy();
    }
    
    public function is_logged_in()
    {
        $session = session();
        return $session->has('isLoggedIn');
    }
}
