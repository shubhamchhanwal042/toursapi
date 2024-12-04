<nav id="sidebarMenu" class="col-md-3 col-lg-2  sidebar position-fixed d-none d-lg-block" style="top: 0; bottom: 0; left: 0; z-index: 100;background-color: rgb(255, 238, 238);">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link menu-item" href="<?php echo base_url('view_data')?>" data-page="main_dashboard">
                    <i class="fas fa-house me-2"></i>
                    Professor Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-item" href="<?php echo base_url('submit_form')?>" data-page="main_dashboard">
                    <i class="fas fa-pen me-2"></i>
                    Submit Data Form
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#teacherSubmenu" role="button" aria-expanded="false" aria-controls="teacherSubmenu">
                    <i class="fas fa-chalkboard-user me-2"></i>
                    Teacher
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="teacherSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="<?php echo base_url('Sandip1/wizard_step_1')?>" data-page="wizard_step_1">Add Other Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="#" data-page="teacher">Sachin Kumar</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#studentSubmenu" role="button" aria-expanded="false" aria-controls="studentSubmenu">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Student
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="studentSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="<?php echo base_url('student')?>" data-page="student">Sachin Page</a>
                        </li>
                    </ul>
                </div>
            </li> -->
        </ul>
    </div>
</nav>

<!-- Off-canvas sidebar for smaller screens -->
<nav id="sidebarMenuMobile" class="sidebar bg-white position-fixed d-lg-none" style="top: 0; bottom: 0; left: -250px; width: 250px; transition: left 0.3s ease; z-index: 100;">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <!-- Same content as desktop sidebar -->
            <li class="nav-item">
                <a class="nav-link menu-item" href="<?php echo base_url('view_data')?>" data-page="main_dashboard">
                    <i class="fas fa-house me-2"></i>
                    Professor Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-item" href="<?php echo base_url('submit_form')?>" data-page="main_dashboard">
                    <i class="fas fa-pen me-2"></i>
                    Submit Data Form
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#teacherSubmenuMobile" role="button" aria-expanded="false" aria-controls="teacherSubmenuMobile">
                    <i class="fas fa-chalkboard-user me-2"></i>
                    Teacher
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="teacherSubmenuMobile">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="<?php echo base_url('teacher')?>" data-page="teacher">Add Other Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="#" data-page="teacher">Sachin Kumar</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#studentSubmenuMobile" role="button" aria-expanded="false" aria-controls="studentSubmenuMobile">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Student
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="studentSubmenuMobile">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link menu-item" href="<?php echo base_url('student')?>" data-page="student">Sachin Page</a>
                        </li>
                    </ul>
                </div>
            </li> -->
        </ul>
    </div>
</nav>

<style>
    .nav-link{
        text-decoration: none;
        color: red !important;
    }
    .nav-link:hover{
        color: white !important;
    }
    .nav-link:active{
        color: white !important;
    }
  
</style>