<?php
class LoggingMiddleware
{
    public function handle()
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
}
