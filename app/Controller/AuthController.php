<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class AuthController extends Controller
{
    public function __construct(private Auth $auth){}

    public function showLogin(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($this->auth->attempt($email, $password)) {
            $this->redirect('/');
        }
        $this->view('auth/login', ['error' => 'Invalid credentials']);
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/');
    }
}
