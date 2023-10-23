<?php


$checkboxAnswer = array(
    ['answer' => 'A', 'value' => '1'],
    ['answer' => 'B', 'value' => '1'],
    ['answer' => 'C', 'value' => '1'],
    ['answer' => 'D', 'value' => '1'],
    ['answer' => 'E', 'value' => '1'],
    ['answer' => 'F', 'value' => '1'],
);
?>
<section class="add-wrap-admin">
    <div class="container-fluid ">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-8 m-auto ">
                    <div class="card">
                        <div class="card-title-top">
                            <h5>Thông tin câu hỏi</h5>
                        </div>
                        <div class="form-input">
                            <div class="mb-5 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Chuyên đề<span class="text-danger ">*</span></label>
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
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu hỏi <span class="text-danger ">*</span></label>
                                <textarea name="title" class="ckEditor"></textarea>
                            </div>

                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Hướng dẫn trả lời </label>
                                <textarea name="guide" class="ckEditor"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="col-sm-8 m-auto ">
                    <div class="card">
                        <div class="card-title-top">
                            <h5>Thông tin câu trả lời</h5>
                        </div>
                        <div class="form-input">
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời A <span class="text-danger ">*</span></label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời B <span class="text-danger ">*</span></label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời C </label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời D </label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời E </label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="mb-5 row align-items-start">
                                <label class="form-label-title col-sm-3 mt-3 mb-0">Câu trả lời F </label>
                                <textarea name="content[]" class="ckEditor"></textarea>
                            </div>
                            <!--  -->

                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="col-sm-8 m-auto ">
                    <div class="card">
                        <div class="card-title-top">
                            <h5>Đáp án câu hỏi</h5>
                        </div>
                        <div class="form-input">
                            <div class="mb-5 row">
                                <label class="form-label-title col-sm-2 mb-0">Đáp án <span class="text-danger ">*</span></label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <?php
                                        foreach ($checkboxAnswer as $itemCheckbox) {
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" name="is_right[]" type="checkbox" value="<?php echo $itemCheckbox['answer'] ?>" id="<?php echo $itemCheckbox['answer']  ?>">

                                                <label class="form-check-label text-uppercase " for="<?php echo $itemCheckbox['answer'] ?>">
                                                    <?php echo $itemCheckbox['answer'] ?>
                                                </label>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <button class="btn btn-custom col-sm-8 m-auto ">Thêm người dùng mới</button>
        </form>
    </div>

</section>