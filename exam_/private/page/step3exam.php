<?php include_once '../includes/header.php'; ?>
<link rel="stylesheet" href="../../assets/fpdf.css">
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<?php
    // if(isset($_SESSION['id'])){
    //     redirect('admin.php');
    // }
 ob_clean();
        header('Content-Type: application/pdf');
        header('Accept-Ranges: bytes');
        header('Content-Transfer-Encoding: binary');
        header("Content-Disposition: inline; filename='step3exam.php.pdf'");
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,10,'Correct : ' . $_SESSION['correct'],0,1);
        $pdf->Cell(0,10,'Wrong : ' . $_SESSION['wrong'],0,1);
        $pdf->Output();
        $session_id = session_id();
        $sql = 'UPDATE `taker` SET `is_finish`= :finish WHERE exam_id = :taker_id ';
        $stmt = $db->prepare($sql);
        $stmt->execute([':finish'=>'yes',':taker_id'=>$session_id]);
        session_regenerate_id(true);
        session_destroy();
        ob_end_flush();
?>

<?php include_once '../includes/footer.php'; ?>