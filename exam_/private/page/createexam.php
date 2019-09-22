<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1 class="text-muted">Create Exam</h1>
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                </a>
                
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <form  method="POST" id="addQuestions" class="form-signin" autocomplete="off">
                    <?php $r =  $db->query('SELECT subject_id , subject_name FROM subjects')->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="container p-2">
                        <label>Choose Subject : </label>
                        <select name="subject" class="form-control-sm">
                            <?php foreach ($r as $key => $value): ?>
                            <option value="<?=$value['subject_id']?>"><?=$value['subject_name']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="card" id="dynamic_field">
                        <div class="card-block">
                            <textarea type="text" required class="form-control" name="question[]" placeholder="Your question here"></textarea>
                            <br>
                            <input  type="text" required name="a[]" class="form-control" placeholder="Answer A :">
                            <br>
                            <input  type="text" required name="b[]" class="form-control" placeholder="Answer B :">
                            <br>
                            <input  type="text" required name="c[]" class="form-control" placeholder="Answer C :">
                            <br>
                            <input  type="text" required name="d[]" class="form-control" placeholder="Answer D :">
                            <br>
                            <label for="">&nbsp;Set Answer : </label>
                            <select  id="setAnswer" class="form-control" required name="correct_answer[]">
                                <option value ="A">A</option>
                                <option value ="B">B</option>
                                <option value ="C">C</option>
                                <option value ="D">D</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <input type="hidden" name="action" value="insertQuestion">
            <div class="container">
                <button style="cursor:pointer;" class="ml-4 btn col-lg-2 btn-outline-secondary float-right btn-default text-muted rounded-0 rounded-0">Submit questions</button>
                <button style="cursor:pointer;" id="addQuestion" class="btn col-lg-2 btn-outline-secondary float-right btn-default text-muted rounded-0 rounded-0">Add questions</button>
            </div>
        </form>
    </div>
</main>
<button style="cursor:pointer;" onclick="topFunction()" id="myBtn" class="btn btn-outline-info rounded-0" title="Go to top">Top</button>
</div>
</div>
<?php include_once '../includes/footer.php'; ?>