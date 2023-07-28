<?php 
session_id("userLoginSession");
if(isset($_SESSION['emp_Id'])){
    $profile =  '<li class="nav-item">
    <a class="nav-link collapsed f-flex gap-1" href="./userDetail.php">
        <span class="material-symbols-outlined">
            person
        </span>
        <span>Profile</span>
    </a>
</li>';
}
?>

<div class="row">
    <div class="col-1">
        <aside id="sidebar" class="position-fixed py-5 my-3" >
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="index.php">
                        <span class="material-symbols-outlined">
                            grid_view
                        </span>
                        <span>Home</span>
                    </a>
                </li>
                <?php echo $profile;?>
                <li class="nav-item">
                    <a class="nav-link collapsed f-flex gap-1" href="#">
                    <i class="bi bi-layout-text-sidebar-reverse"></i>
                        <span>Activity</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed f-flex gap-1" href="#">
                    <i class="bi bi-list-task"></i>
                        <span>task</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed f-flex gap-1" href="#">
                    <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed f-flex gap-1" href="#">
                    <i class="bi bi-flag"></i>
                        <span>Report</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed f-flex gap-1" href="#">
                    <i class="bi bi-hand-thumbs-up"></i>
                        <span>Support</span>
                    </a>
                </li>
            </ul>

        </aside>
    </div>