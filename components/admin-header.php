<?php
//to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

//database connection
include("../connection.php");

include ('../components/alerts.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ADMIN DASHBOARD | PTCMS</title>

    <!-- FONTAWESOME CSS-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- DASHBOARD CSS-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DATATABLE CDN -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="conference.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-school"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PTCMS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- analytics page -->
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- my profile page -->
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- parent accounts page -->
            <li class="nav-item">
                <a class="nav-link" href="parent-accounts.php">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Parent Accounts</span>
                </a>
            </li>

            <!-- teacher accounts page -->
            <li class="nav-item">
                <a class="nav-link" href="teacher-accounts.php">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Teacher Accounts</span>
                </a>
            </li>

            <!-- meetings page -->
            <li class="nav-item">
                <a class="nav-link" href="conference.php">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Conference</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Logs
            </div>


            <!-- admin logs page -->
            <li class="nav-item">
                <a class="nav-link" href="admin-logs.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>My Logs</span></a>
            </li>

            <!-- parent logs page -->
            <li class="nav-item">
                <a class="nav-link" href="parent-logs.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Parent Logs</span></a>
            </li>

            <!-- teacher logs page -->
            <li class="nav-item">
                <a class="nav-link" href="teacher-logs.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Teacher Logs</span></a>
            </li>

            <!-- logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" id="logout">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">