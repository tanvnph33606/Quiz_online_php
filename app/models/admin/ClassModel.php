<?php
class ClassModel extends DB
{
    use CRUD;
    use SweetAlert;
    function getAllClass()
    {
        return $this->find('class');
    }

    function getAllClassApi()
    {
        return json_encode($this->find('class'));
    }

    function getOneClass($id)
    {
        return json_encode($this->findById('class', $id));
    }


    function addNewClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $class_code = $_POST['class_code'] ?? '';
            $description = $_POST['description'] ?? '';


            if (empty($class_code) || empty($description)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/myClass');
            }

            $checkClassCode = $this->findByName('class', $class_code, 'class_code', 1);
            if (!empty($checkClassCode)) {
                return $this->setToastMessage('Mã lớp đã tồn tại.', 'error', 'admin/myClass');
            }

            $success = $this->create('class', [
                'class_code' => $class_code,
                'description' => $description,
            ]);
            if ($success) {
                return $this->setToastMessage('Thêm thành công.', 'success', 'admin/myClass');
            } else {
                return $this->setToastMessage('Thêm thất bại.', 'error', 'admin/myClass');
            }
        }
    }


    function updateClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $class_code = $_POST['class_code'] ?? '';
            $description = $_POST['description'] ?? '';
            $dataUpdate = [
                'description' => $description,
                'update_at' => date('Y-m-d H:i:s')
            ];

            if (empty($class_code) || empty($description)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/myClass');
            }

            $checkClassCode = $this->findByName('class', $class_code, 'class_code', 1);
            if ($checkClassCode['class_code'] != $class_code) {
                $dataUpdate['class_code'] = $class_code;
            }

            $success = $this->findByNameAndUpdate('class', $dataUpdate, 'id = ' . $id);
            if ($success) {
                return $this->setToastMessage('Cập nhập thành công.', 'success', 'admin/myClass');
            } else {
                return $this->setToastMessage('Mã lớp đã tồn tại.', 'error', 'admin/myClass');
            }
        }
    }

    function deleteClass()
    {
        $id = $_POST['id'];
        $success = $this->deleteById('class', $id);

        if ($success) {
            return $this->setToastMessage('Xoá thành công.', 'success', 'admin/myClass');
        }

        return $this->setToastMessage('Xoá thất bại.', 'error', 'admin/myClass');
    }
}
