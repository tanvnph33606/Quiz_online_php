<?php
class Ajax extends Controller
{

    function Default()
    {
        header('location: /Quiz_online/account/login');
    }


    function checkIdentificateExisted()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $userController = $this->model('UserModel');
            echo $userController->checkEmailExisted();
        }
    }

    function checkStrongPassword()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $userController = $this->model('UserModel');
            echo $userController->checkStrongPassword();
        }
    }
}
