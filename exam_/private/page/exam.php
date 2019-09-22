<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
if(isset($_SESSION['id'])){
redirect('admin.php');
}
$session_id = session_id();
$sql = 'SELECT exam_id FROM taker WHERE exam_id = :exam_id';
$stmt = $db->prepare($sql);
$stmt->execute([':exam_id'=>$session_id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
if($r['exam_id'] == $session_id){
    $_SESSION['subject_id'] = $_GET['id'];
    redirect('step2exam.php?id='.$_GET['id']);
}
?>
<div class="container-fluid jumbotron">
    <div class="container">
        <?php
         $sql = 'SELECT subject_name FROM subjects WHERE subject_id = '.$_GET['id']; 
         $stmt = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="alert alert-warning" role="alert">
            <strong>Subject : <?=$stmt['subject_name'];?></strong>
        </div>
        <div class="alert alert-warning" role="alert">
            <strong> * This field will require your Fullname!</strong> 
        </div>
        <?php
            $check_taker = checkTaker();
            if(!$check_taker){
                insertTaker();
            }
        ?>
        <form class="form-signin p-5" autocomplete="off" method="POST" action="" id="fullName">
            <label for="inputEmail" class="sr-only">Fullname</label>
            <input type="text" name="fullname" id="fullname" class="form-control rounded-0" placeholder="Enter your fullname" required autofocus>
            <div class="errorTxt1"></div>
            <br>
            <button class="btn rounded-0 btn-primary float-right" type="submit">Start</button>
        </form>
    </div>

    </div> <!-- /container -->
    </div> <!-- /container -->
    <?php include_once '../includes/footer.php'; ?>