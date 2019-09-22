<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
if(isset($_SESSION['id'])){
redirect('admin.php');
}
?>
<div class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="col-lg-5 m-auto">
                        <img src="../../assets/img/logo.png" class="mt-4 img-fluid">
                    </div>
                    <div class="card fat mt-4">
                        <div class="card-body p-3">
                            <h4 class="card-title">Login</h4>
                            <form method="POST" action="">
                                <?php login(@$_POST['username'],@$_POST['password']); ?>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" name="username" class="form-control" name="email" value="" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required data-eye>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                                <div class="form-group no-margin">
                                    <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        &copy; <?php echo date('Y'); ?> All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
        <?php include_once '../includes/footer.php'; ?>