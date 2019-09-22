<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1>Dashboard</h1>
<hr>
    <div class="row d-flex justify-content-around">
        <div class="p-2 text-center text-muted rounded-0 col-2 bg-faded">
        <p class="font-weight-bold text-center">No. of takers</p>
        <h5 class="display-4"><?php echo passed() + fail(); ?></h5>
        </div>

        <div class="p-2  text-center text-muted rounded-0 col-2 bg-faded">
        <p class="font-weight-bold text-center">No. of Pass</p>
        <h5 class="display-4"><?php echo passed(); ?></h5>
        </div>

        <div class="p-2 text-center text-muted rounded-0 col-2 bg-faded">
        <p class="font-weight-bold text-center">No. of Fail</p>
        <h5 class="display-4"><?php echo fail(); ?></h5>
        </div>

    </div>
</main>
</div>
</div>
<?php include_once '../includes/footer.php'; ?>