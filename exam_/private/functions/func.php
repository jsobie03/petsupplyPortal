<?php

function connection(){
  if (!isset($db)) {
          try {
            $db = new PDO("mysql:host=www.jonsobier.com;dbname=jsobieze_exam;",'jsobieze_psPort','psAdmin');
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
        return $db;
    }
}

function redirect($page){
    header("Location:" . $page);
}

function e($data){
     return htmlentities(htmlspecialchars(stripslashes(strip_tags(trim($data)))),ENT_QUOTES,'UTF-8');
}

function deleteRepeat($string){
    $string = $string . ' ';
    echo $string;
}

function id($string,$add){
    if(strlen($string) == 60){
        $random =  rand(1,60);
        $string = (array) $string;
        foreach ($string as $value) {
            return substr_replace($value,$add,$random) . $value;
        }
    }else if(strlen($string) == 59){
        $random =  rand(1,59);
        $string = (array) $string;
        foreach ($string as $value) {
            return substr_replace($value,$add,$random) . $value;
        }
    }
}

function create unique($items = []){
   $list = $items;
    if(!empty($list) and isset($list)){
          do {
            $rand = rand(1,21);
        } while (in_array($rand,$list));
         return $rand;
    }

}

function isPost(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function login($username,$password){
    global $db;
    if(isPost()){
        $username = e($username);
        $password = e($password);
        $sql =
        '
        SELECT id , username , password
        FROM login_admin
        WHERE username = :username AND password = :password
        ';
        $stmt = $db->prepare($sql);
        $stmt->execute([':username'=>$username,':password'=>$password]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        if($count <= 1){
            echo '<div class="alert rounded-0 alert-danger container-fluid text-center">Please check your username or password</div>';
        }else{
            $_SESSION['id'] = $count['id'];
            redirect('admin.php');
        }

    }
}

/**
 * [checkTaker description]
    check if the examiner is already take the exam
 */
function checkTaker(){
    global $db;
    if(isPost()){
        $student = explode(' ',strtolower(e($_POST['fullname'])));
        $sql =
        'SELECT firstname,middlename,lastname,is_finish
        FROM taker
        WHERE firstname = :firstname
        AND middlename = :middlename AND lastname = :lastname ';

        $stmt = $db->prepare($sql);
        $stmt->execute([':firstname'=>@$student[0],':middlename'=>@$student[1],':lastname'=>@$student[2]]);

        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        if($count['is_finish'] == 'yes'){
                echo '<div class="rounded-0 alert alert-danger container-fluid text-center"><small class="text-muted text-danger">You already take the exam<small></div>';
                return true;
        }
    }
}

/**
 * count number of questions
 */
function countQuestions(){
    global $db;
    $sql  = 'SELECT COUNT(*) as no_of_questions FROM questions';
    $stmt = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);
    return $stmt['no_of_questions'];
}

function countItems($id){
    global $db;
    $sql  = 'SELECT COUNT(*) as no_of_questions FROM questions WHERE subject_id = ' . $id;
    $stmt = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);
    return $stmt['no_of_questions'];
}

/**
 * passing score
 */
function passingScore(){
    global $db;
    $sql  = 'SELECT ROUND(COUNT(*) / 2,0) as passing_score FROM `questions`';
    $stmt = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);
    return $stmt['passing_score'];
}

/**
 * fail
 */
function fail(){
    global $db;
    $sql  = 'SELECT COUNT(*) as fail_taker , ROUND(COUNT(*) / 2,0) as passing_score FROM `take_finish` WHERE correct < ' . passingScore();
    $stmt = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);
    return $stmt['fail_taker'];
}

/**
 * passed
 */
function passed(){
    global $db;
     $sql  = 'SELECT COUNT(*) as pass_taker , ROUND(COUNT(*) / 2,0) as passing_score FROM `take_finish` WHERE correct >= ' . passingScore();
    $stmt = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);
    return $stmt['pass_taker'];
}


/**
 * [checkTaker description]
    stored the information of the examiner
 */
function insertTaker(){
    if(isPost()){
        global $db;
        $count_questions  =  countQuestions();
        $string           = uniqid(md5('testing') . rand(),true);
        $random_questions = rand(1,$count_questions);
        $generate         = id($string,'ATESTING');
        $student          = explode(' ',strtolower(e($_POST['fullname'])));
        $time             = time();
        $exam_id = session_id();
        $sql =
        '
        INSERT INTO taker(firstname,middlename,lastname,take_date,exam_id)
        VALUES(:firstname,:middlename,:lastname,:take_date,:exam_id)
        ';

        $stmt  = $db->prepare($sql);
        $check = $stmt->execute([':firstname'=>@$student[0],':middlename'=>@$student[1],':lastname'=>@$student[2],':take_date'=>$time,':exam_id'=>$exam_id]);

        if($check){
            $_SESSION['taker_name'] = $_POST['fullname'];
            redirect('step2exam.php?id='.$_GET['id']);
        }else{
           echo '<div class="rounded-0 alert alert-danger container-fluid text-center"><small class="text-muted text-danger">Please check the information you fill in the textfield<small></div>';
        }
    }
}

/**
 * add questions
 */
function addQuestion(){
    if(isPost()){
        $db  = connection();
        $sql =
        '
        INSERT INTO `questions`
        (`subject_id` , `question_desc`, `q_answer1`, `q_answer2`, `q_answer3`, `q_answer4`, `exact_answer`)
        VALUES
        (:subject_id,:ques_desc,:ques_ans1,:ques_ans2,:ques_ans3,:ques_ans4,:exact_answer)
        ';

        $stmt            = $db->prepare($sql);
        $question_length = count($_POST['question']);

        for($i = 0; $i<$question_length; $i++){
            $stmt->execute([
                ':subject_id'   => $_POST['subject'],
                ':ques_desc'    => $_POST['question'][$i],
                ':ques_ans1'    => $_POST['a'][$i],
                ':ques_ans2'    => $_POST['b'][$i],
                ':ques_ans3'    => $_POST['c'][$i],
                ':ques_ans4'    => $_POST['d'][$i],
                ':exact_answer' => $_POST['correct_answer'][$i],
            ]);
        }
        return ($stmt) ? true : false;
    }
}

function addSubject(){
    if(isPost()){
        $db  = connection();
        $sql =
        '
         INSERT INTO `subjects`(`subject_name`, `date_create`)
         VALUES
         (:subject_name,:date_create)
        ';

        $stmt = $db->prepare($sql);
        $subject_length = count($_POST['subject_name']);

        for($i = 0; $i<$subject_length; $i++){
            $stmt->execute([
               ':subject_name'=>e($_POST['subject_name'][$i]),
               ':date_create'=>time(),
            ]);
        }
        return ($stmt) ? true : false;
    }
}


function getQuestionInfo($id){
    $db = connection();
    $sql = 'SELECT * FROM questions WHERE question_id = :question_id';
    $stmt = $db->prepare($sql);
    $stmt->execute([':question_id'=>$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    return $r;
}

function updateQuestion($id,$subject_id,$question_desc,$answer_a,$answer_b,$answer_c,$answer_d,$exact_answer){
    $db = connection();
    $sql = '
    UPDATE `questions`
    SET `subject_id`=:subject_id,`question_desc`=:question_desc,`q_answer1`=:q_answer1,`q_answer2`=:q_answer2,`q_answer3`=:q_answer3
    ,`q_answer4`=:q_answer4,`exact_answer`=:exact_answer
    WHERE question_id = :id
    ';
    $stmt = $db->prepare($sql);
    $stmt->execute(
        [
            ':subject_id'=>$subject_id,
            ':question_desc' =>$question_desc,
            ':q_answer1'     =>$answer_a,
            ':q_answer2'     =>$answer_b,
            ':q_answer3'     =>$answer_c,
            ':q_answer4'     =>$answer_d,
            ':exact_answer'  =>$exact_answer,
            ':id'            => $id,
        ]
    );
    return ($stmt) ? true : false;
}

function getSubjectInfo($id){
    $db = connection();
    $sql = 'SELECT * FROM subjects WHERE subject_id = :subject_id';
    $stmt = $db->prepare($sql);
    $stmt->execute([':subject_id'=>$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    return $r;
}

function updateSubject($id,$subject_name){
    $db = connection();
    $sql = '
    UPDATE `subjects` SET `subject_name`=:subject_name
    WHERE subject_id = :subject_id
    ';
    $stmt = $db->prepare($sql);
    $stmt->execute(
        [
            ':subject_name' =>$subject_name,
            ':subject_id'   => $id,
        ]
    );
    return ($stmt) ? true : false;
}


function getAll(){
    $db = connection();
    $sql = 'SELECT
    questions.question_id, questions.question_desc, questions.q_answer1, questions.q_answer2, questions.q_answer3, questions.q_answer4, questions.exact_answer , subjects.subject_name
    FROM questions
    LEFT JOIN subjects
    ON questions.subject_id = subjects.subject_id ORDER BY subjects.subject_name';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '
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
    ';
    foreach ($r as $key => $value){
    echo "
    <tr class='text-center'>
        <td>" . $value['subject_name'] . "</td>
        <td><span class='d-inline-block text-truncate' style='max-width: 100px;'>" . $value['question_desc'] . "</span></td>
        <td>  " . $value['q_answer1'] . " </td>
        <td>  " . $value['q_answer2'] . " </td>
        <td>  " . $value['q_answer3'] . " </td>
        <td>  " . $value['q_answer4'] . " </td>
        <td class='font-weight-bold'> " . $value['exact_answer'] ." </td>
        <td><a dir=" . $value['question_id'] ." id='getQuestionInfo' class='btn-sm rounded-0 btn btn-primary text-white mr-3' data-toggle='modal' data-target='#modal-1'><i class='far fa-edit'></i></a><a dir=" . $value['question_id'] . "  class='btn-sm rounded-0 btn btn-danger text-white' data-toggle='modal' id='showModalDelete' data-target='#modal-2'><i class='far fa-trash-alt'></i></a></td>
    </tr>
    ";
    }
}

function getAllSubjects(){
    $db = connection();
    $sql = '
    SELECT subjects.subject_id , subjects.subject_name , subjects.date_create , COUNT(question_id) as No_of_questions
    FROM subjects
    LEFT JOIN questions
    ON subjects.subject_id = questions.subject_id
    GROUP BY subjects.subject_name ORDER BY subjects.subject_id ASC';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '
    <thead>
        <tr>
                <th class="text-center">Subject name</th>
                <th class="text-center">No. of questions</th>
                <th class="text-center">Subject Added</th>
                <th class="text-center">Action</th>
        </tr>
    </thead>
    ';
    foreach ($r as $key => $value){
    echo "
    <tr class='text-center'>
        <td><span class='d-inline-block text-truncate' style='max-width: 100px;'> $value[subject_name] </span></td>
        <td>$value[No_of_questions] </td>
        <td>" . date('F j, Y g:i a',$value['date_create']) . "</td>
        <td><a dir ='$value[subject_id] ' id='getSubjectInfo' class='rounded-0 btn btn-primary btn-sm text-white mr-3' data-toggle='modal'  data-target='#modal-1'><i class='far fa-edit'></i></a><a href='viewquestions.php?id=$value[subject_id] ' title='View all question' class='rounded-0 btn btn-info text-white btn-sm'><i class='fas fa-eye'></i></a><a dir='$value[subject_id] '  class='ml-3 rounded-0 btn btn-danger text-white btn-sm' data-toggle='modal' id='showModalDelete' data-target='#modal-2'><i class='far fa-trash-alt'></i></a>
        </td>
    </tr>
    ";
    }
}

function deleteQuestion($id){
    $db = connection();
    $sql = 'DELETE FROM `questions` WHERE question_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->execute([':id'=>$id]);
    return ($stmt) ? true : false;
}

function deleteSubject($id){
    $db = connection();
    $sql = 'DELETE FROM `subjects` WHERE subject_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->execute([':id'=>$id]);
    $sql2 = 'DELETE FROM `questions` WHERE subject_id = :id';
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute([':id'=>$id]);
    return ($stmt) ? true : false;
}

function selectAnswerId($id){
    $db = connection();
    $sql = 'SELECT exact_answer FROM questions WHERE question_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->execute([':id'=>$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($stmt) ? $r : null;
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insertQuestion':
            addQuestion();
        break;

        case 'getQuestionInfo':
            $id = e($_POST['question_id']);
            $r = getQuestionInfo($id);
            echo json_encode([
                'question_id'   => $r['question_id'],
                'question_desc' => $r['question_desc'],
                'answer_a'      => $r['q_answer1'],
                'answer_b'      => $r['q_answer2'],
                'answer_c'      => $r['q_answer3'],
                'answer_d'      => $r['q_answer4'],
                'exact_answer'  => $r['exact_answer'],
            ]);
        break;

        case 'changeQuestionInfo':
            $subject_id = e($_POST['sub_name']);
            $question_id   = e($_POST['question_id']);
            $question_desc = e($_POST['question_desc']);
            $answer_a      = e($_POST['answer_a']);
            $answer_b      = e($_POST['answer_b']);
            $answer_c      = e($_POST['answer_c']);
            $answer_d      = e($_POST['answer_d']);
            $exact_answer  = e($_POST['exact_answer']);
            if(updateQuestion($question_id,$subject_id,$question_desc,$answer_a,$answer_b,$answer_c,$answer_d,$exact_answer)){
              getAll();
            }
        break;

        case 'deleteQuestion-2':
        $id = e($_GET['id']);
        (deleteQuestion($id)) ? getAll() : null ;
        break;

        case 'deleteSubject-2':
        $id = e($_GET['id']);
         (deleteSubject($id)) ? getAllSubjects() : null ;
        break;

        case 'checkAnswer':
        session_start();
        $id = explode(' ',$_POST['data']);
        $select_answer = explode(' ',$_POST['answer']);
        $letter_select = explode(' ',$_POST['letter']);
        $question_id = $_POST['question'];
        if(count($_SESSION['answered_question']) == 0){
            $_SESSION['answered_question'][] = array_merge($id,$select_answer,$letter_select);
        }else{
            array_push($_SESSION['answered_question'],array_merge($id,$select_answer,$letter_select));
        }

        if($r = selectAnswerId($question_id)){
            $letter_select = implode(' ',$letter_select);
            if($r['exact_answer'] == strtoupper($letter_select)){
                $_SESSION['correct']++;
            }else{
                $_SESSION['wrong']++;
            }

        }

        break;

        case 'printQuestions':
        questions();
        break;

        case 'insertSucbjects':
        addSubject();
        break;

        case 'getSubjectInfo':
        $id = e($_POST['subject_id']);
        $r = getSubjectInfo($id);
        echo json_encode(['subject_id' =>$r['subject_id'],'subject_name'=>$r['subject_name']]);
        break;


        case 'changeSubjectInfo':
        $id = $_POST['subject_id'];
        $subject_name = $_POST['subject_name'];
        if(updateSubject($id,$subject_name)){
            getAllSubjects();
        }
        break;
    }
}


?>