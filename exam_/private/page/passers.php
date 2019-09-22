<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h3 class="display-4">List of Passers</h3>
    <hr>
  <?php
    $sql = "SELECT take_finish.takef_id , taker.firstname , taker.middlename , taker.lastname , taker.take_date  , take_finish.correct , take_finish.wrong FROM taker INNER JOIN
       take_finish ON taker.exam_id = take_finish.exam_id WHERE take_finish.correct >= " . passingScore();
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table id="example2" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Fullname</th>
                <th class="text-center">Correct</th>
                <th class="text-center">Wrong</th>
                <th class="text-center">No. of items</th>
                <th class="text-center">Date take</th>
            </tr>
        </thead>
        <tbody class="">
            <?php foreach ($r as $key => $value): ?>
            <tr>
                <td class="text-center"><?php echo $value['takef_id']; ?></td>
                <td class="text-capitalize text-justify"><?php echo $value['lastname'] . ', '. $value['firstname'] . ' ' . $value['middlename']; ?></td>
                <td class="text-center"><?php echo $value['correct']; ?></td>
                <td class="text-center"><?php echo $value['wrong']; ?></td>
                <td class="text-center"><?php echo countQuestions(); ?></td>
                <td class="text-center"><?php echo date('M d Y h:m A',$value['take_date']); ?></td>
               <!--  <td><a dir="<?php echo $value['question_id']; ?>" id="getQuestionInfo" class="rounded-0 btn btn-primary btn-sm text-white mr-3" data-toggle="modal"  data-target="#modal-1">EDIT</a><a dir="<?php echo $value['question_id']; ?>"  class="rounded-0 btn btn-danger text-white btn-sm" data-toggle="modal" id="showModalDelete" data-target="#modal-2">DELETE</a></td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
</main>
</div>
</div>
<?php include_once '../includes/footer.php'; ?>