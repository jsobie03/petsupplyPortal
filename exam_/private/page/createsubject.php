<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1 class="text-muted">Create Subject</h1>
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Subject Information
                </a>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <form  method="POST" id="createSubjects" class="form-signin" autocomplete="off">
                    <div class="card" id="dynamic_field_subject">
                        <div class="card-block">
                            <label for="#subject_name">Subject name : </label>
                            <input  type="text" id="subject_name" required name="subject_name[]" class="rounded-0 form-control" placeholder="Subject name">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <input type="hidden" name="action" value="insertSucbjects">
            <div class="container">
                <button style="cursor:pointer;" class="ml-4 btn col-lg-2 btn-outline-secondary float-right btn-default text-muted rounded-0 rounded-0">Submit subject</button>
                <button style="cursor:pointer;" id="addSubject" class="btn col-lg-2 btn-outline-secondary float-right btn-default text-muted rounded-0 rounded-0">Add subject</button>
            </div>
        </form>
    </div>
</main>
<button style="cursor:pointer;" onclick="topFunction()" id="myBtn" class="btn btn-outline-info rounded-0" title="Go to top">Top</button>
</div>
</div>
<?php include_once '../includes/footer.php'; ?>