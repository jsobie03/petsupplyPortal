<?php ob_start(); ?>
<?php require_once '../config.php'; ?>
<?php include '../../assets/html_table.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo @$pageTitle; ?></title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js">
        <link rel="icon" type="image/png" href="../../assets/img/icon.png">
        <link rel="stylesheet" href="../../assets/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../../assets/css/my-login.css">
        <link rel="stylesheet" href="../../assets/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" href="../../assets/css/landing-page.min.css">
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/css/dataTables.min.css">
        <link rel="stylesheet" href="../../assets/js/AmaranJS-master/dist/css/amaran.min.css">
        <link rel="stylesheet" href="../../assets/js/AmaranJS-master/dist/css/animate.min.css">
        <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
        <link href="../../assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
        <style>
        #myBtn {
        display: none; /* Hidden by default */
        position: fixed; /* Fixed/sticky position */
        bottom: 20px; /* Place the button at the bottom of the page */
        right: 30px; /* Place the button 30px from the right */
        z-index: 99; /* Make sure it does not overlap */
        font-size: 18px; /* Increase font size */
        }
        .zoom {
        position: fixed;
        bottom: 45px;
        right: 24px;
        height: 70px;
        }
        .zoom-fab {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        background-color: #009688;
        vertical-align: middle;
        text-decoration: none;
        text-align: center;
        transition: 0.2s ease-out;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        color: #FFF;
        }
        .zoom-fab:hover {
        background-color: #4db6ac;
        box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.14), 0 1px 7px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -1px rgba(0, 0, 0, 0.2);
        }
        .zoom-btn-large {
        width: 60px;
        height: 60px;
        line-height: 60px;
        }
        .zoom-menu {
        position: absolute;
        right: 70px;
        left: auto;
        top: 50%;
        transform: translateY(-50%);
        height: 100%;
        width: 500px;
        list-style: none;
        text-align: right;
        }
        </style>
    </head>
    <body style="overflow-x: hidden;" id="body">
        <?php if (isset($_SESSION['id'])): ?>
        <?php
        if(!isset($_SESSION['id'])){
        redirect('login.php');
        }else{
        $sql = 'SELECT * FROM login_admin WHERE id = :id';
        $stmt = $db->prepare($sql);
        $stmt->execute([':id'=>$_SESSION['id']]);
        $sth = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-3 col-md-2 d-none d-sm-block sidebar navbar-light" id="sidebarr">
                    <br>
                    <img src="../../assets/img/people.png" class="img-fluid" alt="">
                    <hr>
                    <small class="text-sm-center text-uppercase"><?php echo $sth['account_type']; ?> : </small>
                    <p class="text-capitalize text-center text-muted font-weight-bold"><?php echo $sth['lastname'] . ' , ' . $sth['firstname']; ?></p>
                    <div class="row">
                        <div class="col-2 collapse d-md-flex bg-dark pt-2 h-100" id="sidebar">
                            <ul class="nav flex-column flex-nowrap">
                                <li class="nav-item"><a href="admin.php" class="nav-link"><small>Dashboard</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="profile.php"><small>Profile</small></a></li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#submenu1" data-toggle="collapse" data-target="#submenu1"><small>Subjects</small></a>
                                    <div class="collapse" id="submenu1" aria-expanded="false">
                                        <ul class="flex-column pl-2 nav">
                                            <li class="nav-item"><a class="nav-link py-0" href="createsubject.php"><small>Create</small></a></li>
                                            <li class="nav-item"><a class="nav-link py-0" href="editsubjects.php"><small>List</small></a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#submenu2" data-toggle="collapse" data-target="#submenu2"><small>Questions</small></a>
                                    <div class="collapse" id="submenu2" aria-expanded="false">
                                        <ul class="flex-column pl-2 nav">
                                            <li class="nav-item"><a class="nav-link py-0" href="createexam.php"><small>Create</small></a></li>
                                            <li class="nav-item"><a class="nav-link py-0" href="editexam.php"><small>List</small></a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="list.php"><small>Takers</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="passers.php"><small>Passers</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="faileds.php"><small>Faileds</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="logout.php"><small>Logout</small></a></li>
                            </ul>
                        </div>
                    </nav>
                    <?php else: ?>
                    <?php if (substr_count($_SERVER['PHP_SELF'],'login') != 1): ?>
                    <a href="login.php" style="background :transparent; text-decoration :none; letter-spacing: 2px;" class="float-right mr-3 text-white p-2  text-uppercase font-weight-bold rounded-0"><h5><small>Login</small></h5></a>
                    <div class="clearfix" style="background :#272829;"></div>
                    <?php else: ?>
                    <a href="index.php" style="background :transparent; text-decoration :none; letter-spacing: 2px;" class="float-right mr-3 text-white p-2  text-capitalize font-weight-bold rounded-0"><h5><small>Home</small></h5></a>
                    <a href="choose.php" style="background :transparent; text-decoration :none; letter-spacing: 2px;" class="float-right mr-3 text-white p-2  text-capitalize font-weight-bold rounded-0"><h5><small>Take exam</small></h5></a>
                    <div class="clearfix" style="background :#272829;"></div>
                    <?php endif ?>
                    <?php endif ?>