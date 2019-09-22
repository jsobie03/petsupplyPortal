<?php $pageTitle = 'Online Examination | Home'; ?>
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

if(isset($_SESSION['subject_id'])){
    if($r['exam_id'] == $session_id){
    redirect('step2exam.php?id='.$_SESSION['subject_id']);
    }
}

?>
<div class="container-fluid jumbotron">
    <div class="container">
        <small class="text-muted text-danger">
        <?php
            $sql = 'SELECT subjects.subject_id , subjects.subject_name , COUNT(question_id) as No_of_questions
            FROM subjects
            LEFT JOIN questions
            ON subjects.subject_id = questions.subject_id
            GROUP BY subjects.subject_name ORDER BY subjects.subject_id ASC';
            $stmt = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $i = 1;
        ?>
        <div class="alert alert-warning" role="alert">
            <strong>Select subject : </strong>&nbsp;
        </div>
        <?php foreach ($stmt as $key => $value): ?>
            <?php if ($value['No_of_questions'] == 0): ?>
                <h5><del><?= $i . '.) ' . $value['subject_name']; ?></del></h5>
            <?php else: ?>
                <h5><a href="exam.php?id=<?php echo $value['subject_id']; ?>"><?= $i . '.) ' . $value['subject_name']; ?></a><small class="font-weight-bold">&emsp;No. of items : <?=$value['No_of_questions']?></small></h5>
            <?php endif ?>
            <br>
            <?php $i++; ?>
        <?php endforeach ?>
        </small>
    </div>

    </div> <!-- /container -->
    </div> <!-- /container -->
    <?php include_once '../includes/footer.php'; ?>