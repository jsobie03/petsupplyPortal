<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<link rel="stylesheet" href="../../assets/fpdf.css">
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<?php
    $sql = '
    SELECT `taker_id`, `firstname`, `middlename`, `lastname`, take_finish.correct , `take_date` FROM `taker`
    RIGHT JOIN take_finish ON taker.exam_id = take_finish.exam_id ORDER BY taker_id ASC
    ';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_NUM);
 ob_clean();
        header('Content-Type: application/pdf');
        header('Accept-Ranges: bytes');
        header('Content-Transfer-Encoding: binary');
        header("Content-Disposition: inline; filename=exam.pdf");

         $htmlTable="<table>
            <tr>
            <td>Taker ID</td>
            <td>Firstname</td>
            <td>Middlename</td>
            <td>Lastname</td>
            <td>Status</td>
            <td>Taked Date</td>
            </tr>";
           foreach ($r as $key => $value) {
                $htmlTable .="<tr>";
                foreach ($value as $keys => $values) {
                    if($keys == 5){
                     $htmlTable .="<td>".date('M d Y',$value[$keys])."</td>";
                    }else if($keys == 4){
                     $htmlTable .="<td>".((passingScore() > $value[$keys] ? 'Failed' : 'Passed'))."</td>";
                    }
                    else{
                     $htmlTable .="<td>".$value[$keys]."</td>";
                    }
                }
                $htmlTable .="</tr>";
            }
           $htmlTable .="</table>";

        $pdf=new PDF_HTML_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);
        $pdf->WriteHTML("<br>List of all examiners.<br>$htmlTable");
        $pdf->Output();
        ob_end_flush();

?>