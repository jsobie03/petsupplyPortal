<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1 class="text-muted">List of all questions</h1>
    <hr>
    <?php
    $sql = '
    SELECT 
    questions.question_id, questions.question_desc, questions.q_answer1, questions.q_answer2, questions.q_answer3, questions.q_answer4, questions.exact_answer , subjects.subject_name 
    FROM questions 
    LEFT JOIN subjects 
    ON questions.subject_id = subjects.subject_id ORDER BY subjects.subject_name
    ';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">Subject Name</th>
                <th class="text-center">Question Desc.</th>
                <th class="text-center">Answer A</th>
                <th class="text-center">Answer B</th>
                <th class="text-center">Answer C</th>
                <th class="text-center">Answer D</th>
                <th class="text-center">Exact Answer</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($r as $key => $value): ?>
            <tr>
                <td><?php echo $value['subject_name']; ?></td>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['question_desc']; ?></span></td>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['q_answer1']; ?></span></td>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['q_answer2']; ?></span></td>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['q_answer3']; ?></span></td>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['q_answer4']; ?></span></td>
                <td class="font-weight-bold"><?php echo $value['exact_answer']; ?></td>
                <td><a dir="<?php echo $value['question_id']; ?>" id="getQuestionInfo" class="rounded-0 btn btn-primary btn-sm text-white mr-3" data-toggle="modal"  data-target="#modal-1"><i class="far fa-edit"></i></a><a dir="<?php echo $value['question_id']; ?>"  class="rounded-0 btn btn-danger text-white btn-sm" data-toggle="modal" id="showModalDelete" data-target="#modal-2"><i class="far fa-trash-alt"></i></a></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>
</div>

<!-- <div class="zoom">
  <a href="printquestion.php" style="text-decoration: none;" class="zoom-fab zoom-btn-large text-white font-weight-bold" id="zoomBtn">Print</a>
</div> -->

</div>
<div class="modal" id="modal-1">
<div class="modal-dialog" role="document">
<div class="modal-content  rounded-0">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title">Edit question</h4>
    </div>
    <div class="modal-body">
        <form id="editQuestion" method="POST">
            <input type="hidden" name="question_id" id="question_id">
            <?php 
                $sql = 'SELECT subject_id , subject_name FROM subjects';
                $stmt = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div  role="alert">
            <label for="">Select subject : </label>
            <select name="sub_name" required class="form-control container" id="subjects">
                <option selected disabled hidden></option>
                <?php foreach ($stmt as $key => $value): ?>
                    <option value="<?php echo $value["subject_id"]; ?>"><?php echo $value['subject_name']; ?></option>
                <?php endforeach ?>
            </select>
            </div>
            <br>
            <fieldset class="form-group">
                <label for="exampleTextarea">Change question description : </label>
                <textarea class="form-control rounded-0" required id="question_desc"  name="question_desc" rows="3"></textarea>
            </fieldset>

            <div class="form-group">
                <label for="">Edit choice A :</label>
                <input type="text" name="answer_a"  required  id="answer_a" class="form-control">
            </div>

            <div class="form-group">
                <label for="">Edit choice B :</label>
                <input type="text" name="answer_b" required  id="answer_b" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Edit choice C :</label>
                <input type="text" name="answer_c" required id="answer_c" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Edit choice D :</label>
                <input type="text" name="answer_d" required id="answer_d" class="form-control">
            </div>
            <input type="hidden" name="action" value="changeQuestionInfo">
            <fieldset class="form-group">
                <label for="exampleSelect1">Edit exact answer :</label>
                <select class="form-control" name="exact_answer" id="exact_answer">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </fieldset>
    </div>
    <div class="modal-footer">
        <button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="rounded-0 btn btn-primary">Save changes</button>
    </form>
    </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

            <div class="modal" id="modal-2">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Delete question</h4>
                        </div>
                        <div class="modal-body text-center">
                         <form action="" method="POST" id="deleteSelectQuestion">
                            <p class="text-danger">Are you sure want to delete this question?</p>
                            <input type="hidden" id="action" name="action" value="deleteQuestion-2">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="deleteQuestion" class="rounded-0 btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
    <?php include_once '../includes/footer.php'; ?>