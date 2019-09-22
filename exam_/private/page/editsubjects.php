<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
if(!isset($_SESSION['id'])){
redirect('login.php');
}
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1 class="text-muted">List of all subject</h1>
    <hr>
    <?php
    $sql =
    '
    SELECT subjects.subject_id , subjects.subject_name , subjects.date_create , COUNT(question_id) as No_of_questions
    FROM subjects
    LEFT JOIN questions
    ON subjects.subject_id = questions.subject_id
    GROUP BY subjects.subject_name ORDER BY subjects.subject_id ASC
    ';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">Subject name</th>
                <th class="text-center">No. of questions</th>
                <th class="text-center">Subject Added</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($r as $key => $value): ?>
            <tr>
                <td><?php echo $value['subject_name']; ?></td>
                <td><?php echo $value['No_of_questions']; ?></td>
                <td><?php echo date('F j, Y g:i a',$value['date_create']);?></td>
                <td><a dir="<?php echo $value['subject_id']; ?>" id="getSubjectInfo" class="rounded-0 btn btn-primary btn-sm text-white mr-3" data-toggle="modal"  data-target="#modal-1"><i class="far fa-edit"></i></a><a class="rounded-0 btn btn-info text-white btn-sm" title='View all question'  href="viewquestions.php?id=<?php echo $value['subject_id']; ?>"><i class="fas fa-eye"></i></a><a dir="<?php echo $value['subject_id']; ?>"  class="ml-3 rounded-0 btn btn-danger text-white btn-sm" data-toggle="modal" id="showModalDelete" data-target="#modal-2"><i class="far fa-trash-alt"></i></a></td>
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