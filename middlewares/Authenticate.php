<?php
class Authenticate
{

    static function checkLogin()
    {
        $token = Session::get('userLogin');
        if (empty($token)) {
            header('location: /Quiz_online/account/login');
            return;
        }
        $dataUser = JWT::verifyJWT($token);
        if (empty($dataUser) || !$dataUser['valid']) {
            Session::destroy();
            header('location: /Quiz_online/account/login');
        } else {
            header('location: /Quiz_online/');
        }
    }

    static function checkLogged()
    {
        $token = Session::get('userLogin');

        if (!empty($token)) {
            $dataUser = JWT::verifyJWT($token);
            if (!empty($dataUser) && !$dataUser['valid']) {
                Session::destroy();
                header('location: /Quiz_online/account/login');
                return;
            } else {
                header('location: /Quiz_online/');
                return;
            }
        }
    }


    static function checkBlock()
    {
        $token = Session::get('userLogin');
        if (!empty($token)) {
            $dataUser = JWT::verifyJWT($token);
            if (!empty($dataUser) && $dataUser['payload']['isBlock'] == 1) {
                Session::destroy();
                header('location: /Quiz_online/account/login');
                return;
            }
        } else {
            header('location: /Quiz_online/account/login');
        }
    }

    static function checkRoleAdmin()
    {
        $token = Session::get('userLogin');

        if (empty($token)) {
            header('location: /Quiz_online/account/login');
            return;
        }

        $dataUser = JWT::verifyJWT($token);

        if (!empty($dataUser) && $dataUser['payload']['role'] == 2) {
            header('location: /Quiz_online/');
        }
    }
}
