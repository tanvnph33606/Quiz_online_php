<?php
class TopicModel extends DB
{
    use CRUD;
    use SweetAlert;
    function getAllTopic()
    {
        return $this->find('topic');
    }

    function getOneTopic($id)
    {
        return json_encode($this->findById('topic', $id));
    }


    function addNewTopic()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $subject_id = $_POST['subject_id'] ?? '';
            $class_id = $_POST['class_id'] ?? '';


            if (empty($name) || empty($subject_id) || empty($class_id)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/topic');
            }

            $success = $this->create('topic', [
                'name' => $name,
                'subject_id' => $subject_id,
                'class_id' => $class_id
            ]);

            if ($success) {
                return $this->setToastMessage('Thêm thành công.', 'success', 'admin/topic');
            } else {
                return $this->setToastMessage('Cập nhập thất bại hãy thử lại.', 'error', 'admin/topic');
            }
        }
    }


    function updateTopic()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];
            $name = $_POST['name'];
            $subject_id = $_POST['subject_id'] ?? '';
            $class_id = $_POST['class_id'] ?? '';

            $dataUpdate = [
                'name' => $name,
                'class_id' => $class_id,
                'subject_id' => $subject_id,
                'update_at' => date('Y-m-d H:i:s'),
            ];

            if (empty($name) || empty($subject_id) || empty($class_id)) {
                return $this->setToastMessage('Vui lòng không để trống', 'error', 'admin/topic');
            }


            $success = $this->findByNameAndUpdate('topic', $dataUpdate, 'id = ' . $id);
            if ($success) {
                return $this->setToastMessage('Cập nhập thành công.', 'success', 'admin/topic');
            } else {
                return $this->setToastMessage('Cập nhập thất bại hãy thử lại.', 'error', 'admin/topic');
            }
        }
    }

    function deleteTopic()
    {
        $id = $_POST['id'];
        $success = $this->deleteById('topic', $id);

        if ($success) {
            return $this->setToastMessage('Xoá thành công.', 'success', 'admin/topic');
        }

        return $this->setToastMessage('Xoá thất bại.', 'error', 'admin/topic');
    }
}
