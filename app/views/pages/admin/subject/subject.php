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
}
?>

<section class="product-wrap">
    <div class="card">
        <div class="title-header">
            <h5 class="title">Danh sách môn học</h5>
            <div class="right-options">
                <ul>
                    <li>
                        <button data-bs-toggle="modal" data-bs-target="#addModel" class="btn btn-custom"><i class="fas fa-plus"></i> Thêm môn học</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-custom">

            <table class="theme-table" id="table_id">
                <thead class="rounded-3 overflow-hidden  ">
                    <tr>
                        <th>Mã môn học</th>
                        <th>Tên môn học</th>
                        <th>Lớp học</th>
                        <th>Thực thi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($dataSubject as $dataSubjectItem) {
                        extract($dataSubjectItem)
                    ?>
                        <tr>
                            <td><?php echo $subject_code ?></td>
                            <td><?php echo $description ?></td>
                            <?php foreach ($dataClass as $classItem) {
                                if ($class_id == $classItem['id']) {
                            ?>
                                    <td><?php echo $classItem['class_code'] . ' - ' . $classItem['description'] ?></td>
                            <?php
                                };
                            };
                            ?>
                            <td>
                                <ul class="options">
                                    <li class="m-0 ">
                                        <a onclick="update(<?php echo $id ?>)" href="javascript:void(0)">
                                            <i class="edit fas fa-edit"></i>
                                        </a>
                                    </li>

                                    <li class="m-0 ">
                                        <a onclick="setDataIdToInput(<?php echo $id ?>)" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteConfirm">
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
    function modalUpdate(data, dataClass) {
        const classOptions = dataClass.map(dataClassItem => `
        <option ${dataClassItem.id == data.class_id ? 'selected' : ''} value="${dataClassItem.id}">
            ${dataClassItem.class_code} - ${dataClassItem.description}
        </option>
      `);

        return `
        <div class="modal fade theme-modal" id="modalUpdate" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content py-3">
                    <div class="modal-header border-0 d-block text-center">
                        <h5 class="modal-title w-100 mb-5 fs-1">Cập nhật lớp học</h5>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form action="admin/updateSubject" method="POST">
                        <div class="modal-body add-wrap-admin">
                            <div class="form-input">
                            <input type="hidden" name="id" value="${data.id}" />
                                <div class="mb-5 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Mã môn học</label>
                                    <div class="col-sm-9">
                                        <input value="${data.subject_code}" name="subject_code" class="form-control input-text" type="text" placeholder="Mã lớp học">
                                    </div>
                                </div>

                                <div class="mb-5 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Tên môn học</label>
                                    <div class="col-sm-9">
                                        <input value="${data.description}" name="description" class="form-control input-text" type="text" placeholder="Tên lớp học">
                                    </div>
                                </div>

                                <div class="mb-5 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Lớp học</label>
                                    <div class="col-sm-9">
                                        <select style="padding: 0 20px" class="select-custom" name="class_id" id="select-custom2">
                                        <option class="">--  Chọn lớp học --</option>
                                            ${classOptions}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <div class="ms-3">
                                <button type="button" class="btn btn-custom btn-no fw-bold" data-bs-dismiss="modal">Huỷ bỏ</button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-custom btn-yes fw-bold">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    }


    function setDataIdToInput(id) {
        $("#idData").val(id);
    }

    async function update(id) {
        try {


            const [response1, response2] = await Promise.all([
                fetch(`admin/getOneSubject/${id}`),
                fetch(`admin/getAllClass`),
            ]);
            if (!response1.ok || !response2.ok) {
                throw new Error('Network response was not ok');
            }

            const [dataSubject, dataClass] = await Promise.all([
                await response1.json(),
                await response2.json(),
            ]);

            $('#modalUpdate').remove();
            $('body').append(modalUpdate(dataSubject, dataClass));
            $('#modalUpdate').modal('show');
        } catch (error) {
            console.error(error);
        }
    }
</script>


<div class="modal fade theme-modal" id="deleteConfirm" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content py-3">
            <div class="modal-header border-0  d-block text-center">
                <h5 class="modal-title w-100 ">Bạn đã chắc chắn chưa?</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-center">Nếu thực hiện 'đồng ý' xoá bạn sẽ bị xoá vĩnh viễn không thể khôi phục lại hãy suy nghĩ thật kĩ trước khi xoá.</p>
            </div>
            <div class="modal-footer border-0 ">
                <form method="POST" action="admin/deleteSubject">
                    <input type="hidden" id="idData" name="id">
                    <button type="submit" class="btn btn-custom btn-yes fw-bold">Đồng ý</button>
                </form>
                <div class="ms-3 ">
                    <button type="button" class="btn btn-custom btn-no fw-bold" data-bs-dismiss="modal">Huỷ bỏ</button>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="modal fade theme-modal" id="addModel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content py-3">
            <div class="modal-header border-0  d-block text-center">
                <h5 class="modal-title w-100 mb-5 fs-1 ">Thêm môn học mới</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="admin/addSubject" method="POST">
                <div class="modal-body add-wrap-admin">
                    <div class="form-input">
                        <div class="mb-5 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Mã môn học</label>
                            <div class="col-sm-9">
                                <input name="subject_code" class="form-control input-text" type="text" placeholder="Mã lớp học">
                            </div>
                        </div>

                        <div class="mb-5 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Tên môn học</label>
                            <div class="col-sm-9">
                                <input name="description" class="form-control input-text" type="text" placeholder="Tên lớp học">
                            </div>
                        </div>

                        <div class="mb-5 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Lớp học</label>
                            <div class="col-sm-9">
                                <select class="select-custom" name="class_id" id="select-custom">
                                    <option class="">-- Chọn lớp học --</option>

                                    <?php
                                    foreach ($dataClass as $dataClassItem) {
                                    ?>
                                        <option value="<?php echo $dataClassItem['id'] ?>"><?php echo $dataClassItem['class_code'] . ' - ' . $dataClassItem['description'] ?></option>
                                    <?php } ?>
                                </select>
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