<?php

class Account extends Controller
{

    private $userModel;
    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    function Default()
    {
        header('location: /Quiz_online/account/login');
    }

    function login()
    {
        Authenticate::checkLogged();
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->userModel->loginUser();
        }

        $this->view('layoutLogin', [
            'title' => 'Đăng nhập',
            'pages' => 'account/login'
        ]);
    }
    function register()
    {
        Authenticate::checkLogged();
        $this->view('layoutLogin', [
            'title' => 'Đăng ký',
            'pages' => 'account/register'
        ]);
    }
    function registerApi()
    {
        echo $this->userModel->registerUser();
    }

    function forgotPassword()
    {
        $this->view('layoutLogin', [
            'title' => 'Quên mật khẩu',
            'pages' => 'account/forgotPassword'
        ]);
    }

    function logout()
    {
        Session::destroy();
        header('location: /Quiz_online/home');
    }
    function finalRegisterUser($token)
    {
        $dataRegister = $this->userModel->finalRegisterUser($token);
        $this->view('layoutLogin', [
            'title' => 'Xác nhận đăng ký',
            'pages' => 'account/activeAccount',
            'dataRegister' => $dataRegister
        ]);
    }
}
