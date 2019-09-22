<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
if(isset($_SESSION['id'])){
redirect('admin.php');
}
?>
<div id="particles-js" style="z-index :2; position: absolute; left :0%; right :0%; bottom :15%; top :0%;">
</div>
<header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h1 class="mb-5 display-1 font-weight-light">Sometimes you <span class="font-weight-bold text-warning">Win</span> , Sometimes you <del>Lose</del> <span class="font-weight-bold text-warning">Learn</span></h1>
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <form>
                    <div class="form-row text-center">
                        <div class="col-12 col-md-12">
                            <a href="choose.php" style="position:relative; z-index :999;" class="font-weight-light btn btn-outline-primary rounded-0">Take Exam</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
<!-- Icons Grid -->
<section class="features-icons bg-light text-center text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex">
                        <i class="icon-screen-desktop m-auto text-primary"></i>
                    </div>
                    <h3>Input</h3>
                    <p class="lead mb-0">Lorem ipsum dolor sit amet, consectetur.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex">
                        <i class="icon-note m-auto text-primary"></i>
                    </div>
                    <h3>Answer</h3>
                    <p class="lead mb-0">Lorem ipsum dolor sit amet, consectetur.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                    <div class="features-icons-icon d-flex">
                        <i class="icon-printer m-auto text-primary"></i>
                    </div>
                    <h3>Print</h3>
                    <p class="lead mb-0">Lorem ipsum dolor sit amet, consectetur.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="footer bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                <ul class="list-inline mb-2">
                    <li class="list-inline-item mb-3">
                        <a href="#">Surigao Del Sur State University-Main Campus © 2016
                        Formerly: Surigao Del Sur Polytechnic State College</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">086-214-4421</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">Rosario, Tandag City, 8300
                        Surigao del Sur, Philippines</a>
                    </li>
                    
                </ul>
                <p class="text-muted small mb-4 mb-lg-0">&copy; <?php echo date('Y'); ?> All Rights Reserved.</p>
            </div>
            <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                        <a href="https://www.facebook.com/SDSSUmaintandag/">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item mr-3">
                        <a href="http://www.sdssu.edu.ph/">
                            <i class="fas fa-globe"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</div> <!-- /container -->
<?php include_once '../includes/footer.php'; ?>