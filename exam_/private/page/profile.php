<?php $pageTitle = 'Online Examination | Admin'; ?>
<?php include_once '../includes/header.php'; ?>
<?php
if(!isset($_SESSION['id'])){
redirect('login.php');
}
?>
<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
    <h1>Profile</h1>
    <hr>

    <div class="container">
        <div class="row my-2">
            <div class="col-lg-8 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">User Profile</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Full name</h6>
                                <p class="text-capitalize">
                                   <?php echo $sth['firstname'] . ' '  . $sth['middlename'] . ' ' . $sth['lastname']; ?>
                                </p>
                                <hr>
                                <h6>Gender &amp; Birthday</h6>
                                <p class="text-capitalize">
                                    <?php echo $sth['gender'] . ' , '; ?>
                                    <?php echo $sth['birthday']; ?>
                                </p>
                                <hr>

                            </div>
                            <div class="col-md-6">
                                <h6>Account type</h6>
                            <p class="text-capitalize"><?php echo $sth['account_type']; ?></p>
                            <hr>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="tab-pane" id="edit">
                        <div class="row d-flex  flex-column">
                            <div class="col-lg-12">
                                <form id="changeProfile" action="">
                                    <fieldset class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="rounded-0 form-control" value="<?php echo $sth['username']; ?>" name="username"  id="username" placeholder="Enter username">
                                        <span class="errorTxt1 "></span>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="firstname">Firstname</label>
                                        <input type="text" name="firstname" value="<?php echo $sth['firstname']; ?>"  class="rounded-0 form-control" id="firstname" placeholder="Enter firstname">
                                        <span class="errorTxt3"></span>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="middlename">Middlename</label>
                                        <input type="text" name="middlename" value="<?php echo $sth['middlename']; ?>" class="rounded-0 form-control" id="middlename" placeholder="Enter middlename">
                                        <span class="errorTxt5"></span>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" name="lastname" value="<?php echo $sth['lastname']; ?>"  class="rounded-0 form-control" id="lastname" placeholder="Enter lastname">
                                        <span class="errorTxt6"></span>
                                    </fieldset>
                                    <label class="custom-control custom-radio">
                                        Female
                                        <input id="radio1" name="radio" type="radio"  class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"></span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        Male
                                        <input id="radio2" name="radio" checked type="radio" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"></span>
                                    </label>
                                    <br>
                                    <fieldset>
                                        <label for="birthday">Birthday</label>
                                        <input type="text" class="rounded-0 form-control" value="<?php echo $sth['birthday']; ?>" id="birthday" name="birthday">
                                        <span class="errorTxt6"></span>
                                    </fieldset>
                                    <br>
                                    <fieldset class="">
                                        <label class="custom-file col-lg-12">
                                            <input type="file" id="file" class="rounded-0 custom-file-input">
                                            <span  class="rounded-0 custom-file-control">Click to browse image</span>
                                        </label>
                                    </fieldset>
                                    <br>

                                    <fieldset class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="rounded-0 form-control" id="password" placeholder="Enter password">
                                        <span class="errorTxt2"></span>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="password">Re-type password</label>
                                        <input type="password" name="password2" class="rounded-0 form-control" id="passwod2" placeholder="Password again">
                                        <span class="errorTxt7"></span>
                                    </fieldset>
                                    <br>
                                    <button type="submit" class="rounded-0 btn btn-outline-secondary">Submit</button>
                                    <br>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-lg-1 text-center">
                <img src="../../assets/img/people.png" class="mx-auto img-fluid img-thumbnail d-block" alt="avatar">
            </div>
        </div>
    </div>
</main>
</div>
</div>
<?php include_once '../includes/footer.php'; ?>