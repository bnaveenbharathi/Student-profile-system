<?php
session_start();

function logout() {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logging out
    header("Location: ../staff_login.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    logout(); // Call the logout function if the logout parameter is set
}

?>




<nav>
        <div class="logo-name">
            <div class="logo-image">
                <!-- <img src="images/logo.png" alt=""> -->
            </div>
            <!-- <span class="logo_name">B.Naveen Bharathi</span> -->
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="./index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Home</span>
                </a></li>
                <li><a href="./student_list.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Students</span>
                </a></li>
                <!-- <li><a href="./projects.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Projects</span>
                </a></li>
                <li><a href="./certification.php">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Certifications</span>
                </a></li> -->
               
            </ul>
            
            <ul class="logout-mode">
                <li><a href="sidebar.php?logout=true">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <!-- <img src="images/profile.jpg" alt=""> -->
            <!-- <a href="../profilesystem.php" target="_blank"><button style="background:transparent;border:none;font-size:38px;" class="viewbtn"><i class="uil uil-eye" ></i></button> -->
            </a>
        </div>
<style>
    body.dark .viewbtn{
    color: white;
}
.viewbtn{
    color: black;
}
</style>
        