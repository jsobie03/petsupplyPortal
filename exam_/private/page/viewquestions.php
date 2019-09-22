<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1 class="text-muted">Subject questions</h1>
    <hr>
    <?php
    $id = $_GET['id'];
    if((int)$id){
    $sql = '
    SELECT `question_desc`, `q_answer1`, `q_answer2`, `q_answer3`, `q_answer4`, `exact_answer` FROM `questions` WHERE subject_id = ' . $id . '
    ';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    ?>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">Question Desc</th>
                <th class="text-center">Answer A</th>
                <th class="text-center">Answer B</th>
                <th class="text-center">Answer C</th>
                <th class="text-center">Answer D</th>
                <th class="text-center">Exact Answer</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($r as $key => $value): ?>
            <tr>
                <td><span class="d-inline-block text-truncate" style="max-width: 100px;"><?php echo $value['question_desc']; ?></span></td>
                <td><?php echo $value['q_answer1']; ?></td>
                <td><?php echo $value['q_answer2']; ?></td>
                <td><?php echo $value['q_answer3']; ?></td>
                <td><?php echo $value['q_answer4']; ?></td>
                <td><?php echo $value['exact_answer']; ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>
</div>
<div class="zoom">
 <a href="printquestion.php?id=<?php echo $_GET['id']; ?>" style="text-decoration: none;" class="zoom-fab zoom-btn-large text-white font-weight-bold" id="zoomBtn">Print</a>
</div>

</div>
<div class="modal" id="modal-1">
<div class="modal-dialog" role="document">
<div class="modal-content  rounded-0">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title">Edit subject</h4>
    </div>
    <div class="modal-body">
        <form id="editSubject" method="POST">
            <input type="hidden" name="subject_id" id="subject_id">
            <fieldset class="form-group">
                <label for="exampleTextarea">Change subject name : </label>
                <textarea class="form-control rounded-0" required id="subject_name"  name="subject_name" rows="3"></textarea>
            </fieldset>

            <input type="hidden" name="action" value="changeSubjectInfo">

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
                         <form action="" method="POST" id="deleteSelectSubject">
                            <p class="text-danger">Are you sure want to delete this question?</p>
                            <input type="hidden" id="action" name="action" value="deleteSubject-2">
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