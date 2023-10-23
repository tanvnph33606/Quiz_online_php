<?php
class SubjectModel extends DB
{
    use CRUD;
    use SweetAlert;
    function getAllSubject()
    {
        return $this->find('subject');
    }

    function getAllSubjectApi()
    {
        return json_encode($this->find('subject'));
    }


    function getOneSubject($id)
    {
        return json_encode($this->findById('subject', $id));
    }


    function addNewSubject()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject_code = $_POST['subject_code'] ?? '';
            $description = $_POST['description'] ?? '';
            $class_id = $_POST['class_id'] ?? '';

            if (empty($subject_code) || empty($description) || empty($class_id)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/subject');
            }

            $checkSubjectCode = $this->findByName('subject', $subject_code, 'subject_code', 1);
            if (!empty($checkSubjectCode)) {
                return $this->setToastMessage('Mã môn học đã tồn tại.', 'error', 'admin/subject');
            }

            $success = $this->create('subject', [
                'subject_code' => $subject_code,
                'description' => $description,
                'class_id' => $class_id
            ]);
            if ($success) {
                return $this->setToastMessage('Thêm thành công.', 'success', 'admin/subject');
            } else {
                return $this->setToastMessage('Thêm thất bại.', 'error', 'admin/subject');
            }
        }
    }


    function updateSubject()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];
            $subject_code = $_POST['subject_code'] ?? '';
            $description = $_POST['description'] ?? '';
            $class_id = $_POST['class_id'] ?? '';

            $dataUpdate = [
                'description' => $description,
                'class_id' => $class_id,
                'update_at' => date('Y-m-d H:i:s'),
            ];

            if (empty($subject_code) || empty($description) || empty($class_id)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/subject');
            }

            $checkSubjectCode = $this->findByName('subject', $subject_code, 'subject_code', 1);

            if ($checkSubjectCode[0]['subject_code'] != $subject_code) {

                $dataUpdate['subject_code'] = $subject_code;
                return;
            }

            $success = $this->findByNameAndUpdate('subject', $dataUpdate, 'id = ' . $id);
            if ($success) {
                return $this->setToastMessage('Cập nhập thành công.', 'success', 'admin/subject');
            } else {
                return $this->setToastMessage('Mã môn học đã tồn tại.', 'error', 'admin/subject');
            }
        }
    }

    function deleteSubject()
    {
        $id = $_POST['id'];
        $success = $this->deleteById('subject', $id);

        if ($success) {
            return $this->setToastMessage('Xoá thành công.', 'success', 'admin/subject');
        }

        return $this->setToastMessage('Xoá thất bại.', 'error', 'admin/subject');
    }
}
