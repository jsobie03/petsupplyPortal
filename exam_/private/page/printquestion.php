<?php $pageTitle = 'Online Examination | Home'; ?>
<?php include_once '../includes/header.php'; ?>
<link rel="stylesheet" href="../../assets/fpdf.css">
<?php
    if(!isset($_SESSION['id'])){
        redirect('login.php');
    }
?>
<?php
    $sql = 'SELECT `question_desc`, `q_answer1`, `q_answer2`, `q_answer3`, `q_answer4`, `exact_answer` FROM `questions` WHERE subject_id = ' . (int)e($_GET['id']) . '  ORDER BY question_desc ASC';
    $stmt = $db->query($sql);
    $r = $stmt->fetchAll(PDO::FETCH_NUM);
 ob_clean();
        header('Content-Type: application/pdf');
        header('Accept-Ranges: bytes');
        header('Content-Transfer-Encoding: binary');
        header("Content-Disposition: inline; filename=exam.pdf");
         $htmlTable="<table>
            <tr>
            <td>Question Desc</td>
            <td>Answer A</td>
            <td>Answer B</td>
            <td>Answer C</td>
            <td>Answer D</td>
            <td>Exact Answer</td>
            </tr>";
           foreach ($r as $key => $value) {
                $htmlTable .="<tr>";
                foreach ($value as $keys => $values) {
                     $htmlTable .="<td>".$value[$keys]."</td>";
                }
                $htmlTable .="</tr>";
            }
           $htmlTable .="</table>";

        $pdf=new PDF_HTML_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);
        $pdf->WriteHTML("<br>List of all questions.<br>$htmlTable");
        $pdf->Output();
        ob_end_flush();

?>