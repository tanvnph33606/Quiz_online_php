<section class="sidebar-wrapper">
    <div class="top-fixed-sidebar">
        <div class="logo-wrapper">
            <a href="#">
                <img class="img-fluid for-white" src="public/images/logo/logo.png" alt="logo">
            </a>
        </div>
    </div>
    <nav class="sidebar-main">
        <div class="sidebar-menu">
            <ul class="sidebar-links">
                <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'dashboard' ? 'active' : '' ?>" href="admin">
                        <i class="fas fa-home"></i>
                        <span>Bảng điều khiển</span>
                    </a>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'subject' ? 'active' : '' ?>" href="admin/subject">
                        <i class="fas fa-book-open"></i>
                        <span>Môn học</span>

                    </a>
                </li>



                <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'class' ? 'active' : '' ?>" href="admin/myClass">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Lớp học</span>
                    </a>
                </li>




                <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'topic' ? 'active' : '' ?>" href="admin/topic">
                        <i class="fas fa-bookmark"></i>
                        <span>Chuyên đề</span>

                    </a>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'questions' ? 'active' : '' ?>" href="javascript:void(0)">
                        <i class="fas fa-question-circle"></i>
                        <span>Câu hỏi trắc nghiệm</span>
                        <div class="according-menu">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </a>
                    <!--  -->
                    <ul class="sidebar-submenu">
                        <li>
                            <i class="fas fa-minus"></i>
                            <a href="admin/questions">Danh sách câu hỏi</a>
                        </li>

                        <li>
                            <i class="fas fa-minus"></i>
                            <a href="admin/addQuestions">Thêm mới</a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="sidebar-list">
                    <a class="sidebar-list-link <?php echo $active == 'user' ? 'active' : '' ?>" href="javascript:void(0)">
                        <i class="fas fa-users"></i>
                        <span>Người dùng</span>
                        <div class="according-menu">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </a> -->

                <!--  -->

                <!-- <ul class="sidebar-submenu">
                        <li>
                            <i class="fas fa-minus"></i>
                            <a href="admin/user">Danh sách người dùng</a>
                        </li>

                        <li>
                            <i class="fas fa-minus"></i>
                            <a href="admin/addUser">Thêm mới</a>
                        </li>
                    </ul>
                </li> -->





            </ul>
        </div>
    </nav>
</section>