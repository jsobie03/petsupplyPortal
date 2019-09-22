<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<link rel="stylesheet" href="../../assets/fpdf.css">
<?php
if(isset($_SESSION['id'])){
    redirect('admin.php');
}

if(empty($_SESSION['taker_name'])){
    redirect('index.php');
}

//query for getting all the questions
$sql = 'SELECT * FROM questions WHERE subject_id ='.$_GET['id'];
$stmt = $db->query($sql);
while($r = $stmt->fetchAll(PDO::FETCH_ASSOC)){
   $question_number_list = $r;
}


if(!empty($question_number_list)){
    $i = 0;
    if(isset($_SESSION['answered_question'])){
        $arr  = [];
        $arr2 = [];
        global $answered;
        /**
         * pass the value of session into array
         * @var [type]
         */
        foreach ($_SESSION['answered_question'] as $key => $value) {
            foreach ($value as $keys => $items) {
                $item[] = $items;
            }
        }

        /**
         * get all the question_id from the array
         * @var [type]
         */
        foreach ($question_number_list as $key => $value) {
                $item2[] = $value['question_id'];
        }

        /**
         * is equal ?then store it into array if not iterate again
         * @var [type]
         */
        foreach ($item as $key => $value) {
            foreach ($item2 as $keys => $values) {
                if($value == $values){
                    array_push($arr,$value);
                }
            }
        }

        //store the list of questions into array
        foreach ($question_number_list as $key => $val){
            array_push($arr2,$val['question_id']);
        }

        //compare and get the remainting question
        $result = array_diff($arr2,$arr);
        $random_question = array_rand($result);
        if(empty($result)){
            ob_clean();
            header('Content-Type: application/pdf');
            header('Accept-Ranges: bytes');
            header('Content-Transfer-Encoding: binary');
            header("Content-Disposition: inline; filename=exam.pdf");
             $htmlTable="<table>
                <tr>
                <td>Name</td>
                <td>Correct</td>
                <td>Wrong</td>
                <td>No of items</td>
                <td>Status</td>
                <td>Date</td>
                </tr>

                <tr>
                <td>" . $_SESSION['taker_name'] . "</td>
                <td>" . (isset($_SESSION['correct']) ? $_SESSION['correct'] : 0) ."</td>
                <td>" . (isset($_SESSION['wrong']) ? $_SESSION['wrong'] : 0) ."</td>
                <td>" . countItems($_GET['id'])."</td>
                <td>" . ((passingScore() > @$_SESSION['correct']) ? 'Failed' : 'Passed') ."</td>
                <td>" . date('M d Y',time())."</td>
                </tr>
                </table>";

            $pdf=new PDF_HTML_Table();
            $pdf->AddPage();
            $pdf->SetFont('Arial','',10);
            $pdf->WriteHTML("<br>Result of the exam.<br>$htmlTable");
            $pdf->Output();
            $session_id = session_id();
            $sql = 'UPDATE `taker` SET `is_finish`= :finish WHERE exam_id = :taker_id ';
            $stmt = $db->prepare($sql);
            $stmt->execute([':finish'=>'yes',':taker_id'=>$session_id]);
            $sql1 = 'INSERT INTO take_finish(exam_id,correct,wrong) VALUES (:exam_id,:correct,:wrong)';
            $stmt1 = $db->prepare($sql1);
            $stmt1->execute([':exam_id'=>$session_id,':correct'=>(isset($_SESSION['correct']) ? $_SESSION['correct'] : 0) , ':wrong'=>(isset($_SESSION['wrong']) ? $_SESSION['wrong'] : 0)]);
                session_regenerate_id(true);
                session_destroy();
                session_unset();
            ob_end_flush();
        }

    }else{
        $random_question = array_rand((array)$question_number_list);
    }
}else{
    session_regenerate_id(true);
    session_destroy();
    session_unset();
    sleep(5);
    redirect('index.php');
}


?>
<div class="container-fluid jumbotron">
    <small class="text-muted text-danger">* Choose </small>
    <div class="card">
        <div class="card-header">
            Question
        </div>
        <div class="card-body p-4">
            <?php
                $a = 'a';
                if(isset($question_number_list[$random_question])){

                foreach ($question_number_list[$random_question] as $key => $value){

                    if($key == 'exact_answer'){
                        $value = null;
                    }
                    if($key == 'question_id'){
                        $id = $value;
                        $value = null;
                    }
                    if($key == 'subject_id'){
                        $value = null;
                    }

                    if(strpos($key,'q_answer') !== false){
                       echo '<input type="radio" dir="' . $a . '" name="choices" value='  . $value . '>';
                       echo strtoupper($a++) . '. ';
                       echo '<b>' . $value . '</b><br>';
                    }else{
                       echo  '<p>' . $value . '</p>';
                    }
             }
             ?>

             <button href="#" onclick="location.reload();" class="btn btn-primary rounded-0">Skip</button>
             <button id="nextQuestion" data-id-type="<?php echo $id; ?>" dir="<?php echo $question_number_list[$random_question]['question_id']; ?>" type="submit" class="btn btn-primary rounded-0 popover-test" data-content="hello world">Next</button>
            <?php  } ?>
        </div>
    </div>
</div>
<?php include_once '../includes/footer.php'; ?>