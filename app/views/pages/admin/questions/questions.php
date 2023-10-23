<?php
if ($delMessage && $delType) {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500, 
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: "' . $delType . '",
            title: "' . $delMessage . '",
        });
    })
    </script>';
    Session::unsetSession('deleteMessage');
    Session::unsetSession('deleteType');

    // echo '<pre>';
    // print_r($dataQuestions);
    // echo '</pre>';
}
?>

<section class="product-wrap">
    <div class="card">
        <div class="title-header">
            <h5 class="title">Danh sách câu hỏi</h5>
            <div class="right-options">
                <ul class="d-flex gap-3 ">
                    <li>
                        <a class="btn btn-custom" href="public/files/file_import_cau_hoi_trac_nghiem_mau.xlsx" download="true"><i class="fas fa-download"></i> Tải file mẫu</a>
                    </li>
                    <li>
                        <a class="btn btn-custom" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addModel"><i class="fas fa-upload"></i> Import</a>
                    </li>
                    <li>
                        <a class="btn btn-custom" href="admin/addQuestions"><i class="fas fa-plus"></i>Thêm câu hỏi</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-custom">
            <table class="theme-table" id="table_id">
                <thead class="rounded-3 overflow-hidden  ">
                    <tr>

                        <th>Câu hỏi</th>
                        <th>Loại</th>
                        <th>Chuyên đề</th>
                        <th>Lớp học</th>
                        <th>Môn học</th>
                        <th>Thực thi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($dataQuestions as $dataQuestionsItem) {
                        extract($dataQuestionsItem);
                    ?>
                        <tr>
                            <td>
                                <div class="questions">
                                    <p><?php echo $title ?></p>
                                </div>
                            </td>
                            <td><?php echo $type == 0 ? 'Một lựa chọn' : 'Nhiều lựa chọn' ?></td>
                            <td><?php echo $name ?></td>
                            <td><?php echo "$class_code - $class_description" ?></td>
                            <td><?php echo "$subject_code - $subject_description" ?></td>

                            <td>
                                <ul class="options">
                                    <li class="m-0 ">
                                        <a href="admin/updateUser/<?php echo $userItem['id'] ?>">
                                            <i class="edit fas fa-edit"></i>
                                        </a>
                                    </li>

                                    <li class="m-0 ">
                                        <a onclick="setDataIdToInput(<?php echo $userItem['id'] ?>)" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteConfirm">
                                            <i class="delete fas fa-trash-alt"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    function setDataIdToInput(id) {
        $("#idUser").val(id);
    }
</script>


<div class="modal fade theme-modal" id="deleteConfirm" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content py-3">
            <div class="modal-header border-0  d-block text-center">
                <h5 class="modal-title w-100" id="exampleModalLabel22">Bạn đã chắc chắn chưa?</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-center">The permission for the use/group, preview is inherited from the object, object will create a
                    new permission for this object</p>
            </div>
            <div class="modal-footer border-0 ">
                <form method="POST" action="admin/deleteUser">
                    <input type="hidden" id="idUser" name="id">
                    <button type="submit" class="btn btn-custom btn-yes fw-bold">Yes</button>
                </form>
                <div class="ms-3 ">
                    <button type="button" class="btn btn-custom btn-no fw-bold" data-bs-dismiss="modal">No</button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade theme-modal" id="addModel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content py-3">
            <div class="modal-header border-0  d-block text-center">
                <h5 class="modal-title w-100 mb-5 fs-1 ">Thêm câu hỏi trắc nghiệm mới</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="admin/importQuestions" enctype="multipart/form-data">
                <div class="modal-body add-wrap-admin">
                    <div class="form-input">
                        <div class="mb-5 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Chuyên đề <span class="text-danger ">*</span></label>
                            <div class="col-sm-9">
                                <select class="select-custom" name="topic_id" id="select-custom2">
                                    <option value="">-- Chọn chuyên đề --</option>
                                    <?php
                                    foreach ($dataTopic as $dataTopicItem) {
                                    ?>
                                        <option value="<?php echo $dataTopicItem['id'] ?>"><?php echo $dataTopicItem['name'] ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <div class="mb-5 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Chọn file excel cần import (.xlsx) <span class="text-danger ">*</span></label>
                            <div class="col-sm-9">
                                <input name="dataImport" class="form-control input-file" type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 ">
                    <div class="ms-3 ">
                        <button type="button" class="btn btn-custom btn-no fw-bold" data-bs-dismiss="modal">Huỷ bỏ</button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-custom btn-yes fw-bold">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>