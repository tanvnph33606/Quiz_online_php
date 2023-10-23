<?php
class UserModel extends DB
{
    use CRUD;
    use SweetAlert;
    function checkEmailExisted()
    {
        $email = $_POST['email'];
        $isHasEmail = $this->findByName('user', $email, 'email');
        if (!empty($isHasEmail)) {
            return json_decode('0');
        }
        return json_decode('1');
    }

    function checkStrongPassword()
    {
        $password = $_POST['password'];
        $isStrongPass = Format::isStrongPassword($password);
        if (!$isStrongPass) {
            return json_decode('0');
        }
        return json_decode('1');
    }

    function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->Toast('error', 'Vui lòng không để trống.');
                return false;
            }

            $checkEmail = $this->findByName('user', $email, 'email');

            if ($checkEmail && password_verify($password, $checkEmail[0]['password'])) {
                $data = $checkEmail[0];

                if ($data['isBlock'] == 1) {
                    $this->Alert('Tài khoản của bạn đang bị khoá.', 'error');
                    return false;
                }
                $userData = [
                    'user_id' => $data['id'],
                    'role' => $data['role'],
                    'fullname' => $data['fullname'],
                    'isBlock' => $data['isBlock'],
                ];


                $accessToken = JWT::createJWT($userData);

                $condition = 'id = ' . $data['id'];

                $updateAccessToken = $this->findByNameAndUpdate('user', ['accessToken' => $accessToken], $condition);

                if (!$updateAccessToken) {
                    $this->Alert('Đăng nhập thất bại', 'error');
                }

                Session::set('userLogin', $accessToken);

                $redirectUrl = ($data['role'] == 1) ? 'admin' : 'home';
                $this->Alert('Đăng nhập thành công.', 'success', $redirectUrl, 1200);

                return true;
            }

            $this->Alert('Email hoặc mật khẩu không chính xác.', 'error');
            return false;
        }
    }


    function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password) || empty($fullname)) {
                return json_encode(['error' => 'Vui lòng không để trống.']);
            }

            $checkEmail = $this->findByName('user', $email, 'email');

            if (!empty($checkEmail)) {
                return json_encode(['error' => 'Email đã được đăng ký vui lòng đăng nhập.']);
            };

            $isStrongPass = Format::isStrongPassword($password);

            if (!$isStrongPass) {
                return json_encode(['error' => 'Mật khẩu chưa đạt yêu cầu.']);
            }
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $token = Format::generateRandomString(64);
            $subject = 'Xác nhận đăng ký.';
            $body = 'Click vào đây để hoàn thành đăng ký của bạn: <a href="http://localhost/Quiz_online/account/finalRegisterUser/' . $token . '">Xác nhận</a> Đường dẫn sẽ hết hạn trong 15 phút.';

            $tempUser = array(
                'email' => $email,
                'fullname' => $fullname,
                'password' => $hashedPassword,
                'token' => password_hash($token, PASSWORD_BCRYPT)
            );
            $sendMail = Services::sendCode($email, $subject,  $body);

            if ($sendMail) {
                Cookie::set('tempUser', json_encode($tempUser));
                return json_encode(['success' => 'Vui lòng xác nhận email để hoàn tất đăng ký.']);
            }

            return json_encode(['error' => 'Đã có lỗi sảy ra vui lòng đăng ký lại.']);
        }
    }

    function finalRegisterUser($token)
    {
        $dataSuccess = [
            'icon' => 'check',
            'h1' => 'Xác nhận đăng ký thành công.',
            'h5' => 'Xác nhận đăng ký thành công vui lòng đăng nhập.'

        ];
        $dataError = [
            'icon' => 'times',
            'h1' => 'Xác nhận đăng ký thất bại.',
            'h5' => 'Đường link xác nhận đã hết hạn vui lòng đăng ký lại.'
        ];
        $tempUser = json_decode(Cookie::get('tempUser'), true);


        if (empty($tempUser) || !password_verify($token, $tempUser['token'])) {
            return $dataError;
        }


        $dataInsert = ['email' => $tempUser['email'], 'fullname' => $tempUser['fullname'], 'password' => $tempUser['password']];

        $success = $this->create('user', $dataInsert);
        if ($success) {
            Cookie::unsetCookie('tempUser');
            return $dataSuccess;
        } else {
            Cookie::unsetCookie('tempUser');
            return $dataError;
        }
    }
}
