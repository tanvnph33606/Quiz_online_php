<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class QuestionsModel extends DB
{
    use CRUD;
    use SweetAlert;
    function getAllQuestions()
    {
        try {
            $sql = 'SELECT q.title, q.type, t.name , c.class_code, c.description AS class_description, s.subject_code, s.description AS subject_description
            FROM questions q
            INNER JOIN topic t ON q.topic_id = t.id
            INNER JOIN class c ON t.class_id = c.id
            INNER JOIN subject s ON t.subject_id = s.id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    function getOneQuestions($id)
    {
        return $this->findById('user', $id);
    }


    function addNewQuestions()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $topic_id = $_POST['topic_id'] ?? '';
            $title = $_POST['title'] ?? '';
            $guide = $_POST['guide'] ?? '';
            $content = $_POST['content'] ?? [];
            //Loại bỏ các phần tử rỗng
            $contentNew = array_filter($content);

            $is_right = $_POST['is_right'] ?? [];

            if (empty($topic_id) || empty($title) || empty($contentNew) || empty($is_right)) {
                return $this->Toast('error', 'Vui lòng không để trống.');
            }

            $insertQuestions = [
                'topic_id' => $topic_id,
                'title' => $title,
                'guide' => $guide ?? '',
                'type' => (count($is_right) >= 2) ? 1 : 0,
            ];

            try {
                $this->conn->beginTransaction(); // Bắt đầu thêm dữ liệu

                $sql = "INSERT INTO questions (title, topic_id, type, guide) VALUES (:title, :topic_id, :type, :guide)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($insertQuestions);

                $question_id = $this->conn->lastInsertId();

                // gán câu hỏi lần lượt bằng A => F
                $answerMapping = [];
                $currentChar = 'A';
                for ($i = 0; $i < count($contentNew); $i++) {
                    $answerMapping[$currentChar] = $contentNew[$i];
                    $currentChar++;
                }


                $sql = "INSERT INTO answer (content, is_right, question_id) VALUES (:content, :is_right, :question_id)";
                $stmt = $this->conn->prepare($sql);

                foreach ($answerMapping as $keyAnswer => $answerMappingItem) {
                    $isRight = in_array($keyAnswer, $is_right) ? 1 : 0;


                    $stmt->execute([
                        'content' => $answerMappingItem,
                        'is_right' => $isRight,
                        'question_id' => $question_id,
                    ]);
                }

                $this->conn->commit(); // Hoàn thành thêm
                return $this->setToastMessage('Thêm thành công.', 'success', 'admin/questions');
            } catch (Exception $e) {
                $this->conn->rollBack(); // Quay lại trạng thái trước thêm nếu có lỗi
                return $this->Toast('error', 'Thêm thất bại.');
            }
        }
    }


    function importNewQuestions()
    {
        $topic_id = $_POST['topic_id'];
        $excelFile = $_FILES["dataImport"]["tmp_name"];


        $fileType = pathinfo($_FILES["dataImport"]["name"], PATHINFO_EXTENSION);
        if ($fileType != "xlsx") {
            return $this->setToastMessage('Vui lòng chọn đúng định dạng file', 'error', 'admin/questions');
        }
        
        // Xử lý tệp Excel
        $spreadsheet = IOFactory::load($excelFile);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Thực hiện xử lý dữ liệu từ tệp Excel tại đây
        // Ví dụ: lặp qua $data và thực hiện thao tác với từng dòng

        echo "Dữ liệu đã được import từ tệp Excel.";
    }

    function updateQuestions($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? '';
            $re_password = $_POST['re_password'] ?? '';
            $role = $_POST['role'] ?? '';
            $isBlock = $_POST['isBlock'] ?? '';
            $avatar = $_FILES['avatar'] ?? '';


            $isSuccess = false;


            if (empty($fullname) || empty($email) || empty($password) || empty($phone)) {
                $this->Toast('error', 'Vui lòng không để trống.');
                return;
            }

            $checkIdentifiExisted = $this->findById('user', $id);

            if ($checkIdentifiExisted['email'] != $email &&  $checkIdentifiExisted['email'] == $email) {
                $this->Toast('error', 'Email đã tồn tại.');
                return;
            }

            if ($checkIdentifiExisted['phone'] != $phone && $checkIdentifiExisted['phone'] == $phone) {
                $this->Toast('error', 'Số điện thoại đã tồn tại.');
                return;
            }

            $pattern = '/^(0[1-9]\d{8,9})$/';
            if (!preg_match($pattern, $phone)) {
                $this->Toast('error', 'Số điện thoại không hợp lệ.');
                return;
            }


            if ($checkIdentifiExisted['password'] == $password) {
                $hashedPassword = $password;
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            }


            if ($password !== $re_password) {
                $this->Toast('error', 'Mật khẩu không khớp.');
                return;
            }




            try {
                if (!empty($avatar['name'])) {
                    $imageName = $this->uploadSingleImage($avatar, 'users');
                    if ($imageName) {
                        $sql = 'UPDATE user SET fullname=?, email=?, phone=?, address=?, password=?, role=?, isBlock=?, avatar=?, update_At=NOW() WHERE id=?';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([$fullname, $email, $phone, $address, $hashedPassword, $role, $isBlock, $imageName, $id]);
                        $isSuccess = true;
                    }
                } else {
                    $sql = 'UPDATE user SET fullname=?, email=?, phone=?, address=?, password=?, role=?, isBlock=?, update_At=NOW() WHERE id=?';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([$fullname, $email, $phone, $address, $hashedPassword, $role, $isBlock, $id]);
                    $isSuccess = true;
                }

                if ($isSuccess) {
                    $this->Toast('success', 'Cập nhập thành công.', 'admin/user', 1000);
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }



    function deleteQuestions($id)
    {
        $dataUser = $this->findById('user', $id);

        if ($dataUser['role' == 1]) {
            Session::set('deleteMessage', 'Không thể xoá tài khoản admin.');
            Session::set('deleteType', 'error');
            return false;
        }

        if (!empty($dataUser['image'])) {
            $imagePath = "public/images/users/" . $dataUser['avatar'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $success = $this->deleteById('user', $id);

        if ($success) {
            Session::set('deleteMessage', 'Xoá thành công.');
            Session::set('deleteType', 'success');
            header('Location: /Quiz_online/admin/user');
            return true;
        }

        Session::set('deleteMessage', 'Xoá thất bại.');
        Session::set('deleteType', 'error');

        return false;
    }
}
