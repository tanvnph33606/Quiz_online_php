<?php
class CategoryModel extends DB
{
    use CRUD;
    use SweetAlert;
    function getAllCategory()
    {
        return $this->find('category');
    }

    function getOneCategory($id)
    {
        return $this->findById('category', $id);
    }


    function addNewCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $image = $_FILES['image'] ?? '';

            if (empty($name) || empty($image['name'])) {
                $this->Toast('error', 'Vui lòng không để trống.');
                return;
            }

            // image thumb
            $imageName = $this->uploadSingleImage($image, 'category');
            if ($imageName) {
                try {
                    $sql = 'INSERT INTO category (name, image) VALUES (?, ?)';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        $name, $imageName
                    ]);
                    $this->Toast('success', 'Add new category success.', 'admin/category', 1000);
                } catch (PDOException $e) {
                    $this->Toast('error', 'Add new category failed.');
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    }

    function updateCategory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $image = $_FILES['image'] ?? '';
            $isSuccess = false;


            if (empty($name)) {
                $this->Toast('error', 'Vui lòng không để trống.');
                return;
            }

            try {
                if (!empty($image['name'])) {
                    $imageName = $this->uploadSingleImage($image, 'category');
                    if ($imageName) {
                        $sql = 'UPDATE category SET name=?, image=? WHERE id=?';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([$name, $imageName, $id]);
                        $isSuccess = true;
                    }
                } else {
                    $sql = 'UPDATE category SET name=? WHERE id=?';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([$name, $id]);
                    $isSuccess = true;
                }

                if ($isSuccess) {
                    $this->Toast('success', 'Cập nhập thành công.', 'admin/category', 1000);
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    function deleteCategory($id)
    {
        $dataCate = $this->findById('category', $id);

        if (!empty($dataCate['image'])) {
            $imagePath = "public/images/category/" . $dataCate['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $success = $this->deleteById('category', $id);

        if ($success) {
            Session::set('deleteMessage', 'Xoá thành công.');
            Session::set('deleteType', 'success');
            header('Location: /Quiz_online/admin/category');
            return true;
        }

        Session::set('deleteMessage', 'Xoá thất bại.');
        Session::set('deleteType', 'error');

        return false;
    }
}
