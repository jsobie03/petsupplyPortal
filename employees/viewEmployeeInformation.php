<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

 


$action= filter_input(INPUT_GET, 'select');

$queryAllEmployees = 'SELECT * FROM employees
					  ORDER BY id';
$statement75 = $db1->prepare($queryAllEmployees);
$statement75->execute();
$employees = $statement75->fetchAll();
$statement75->closeCursor();


$employeeFName="";
$employeeLName="";
foreach($employees as $employee){
if($employee['id'] == $id){
$employeeFName = $employee["first_name"];
$employeeLName = $employee["last_name"];
}
}		

$searchQuery22 = "SELECT * FROM employees WHERE id = '$search'";
$statement92=$db1->prepare($searchQuery22);
$statement92->execute();
$searchEmployees = $statement92->fetchAll();
$statement92->closeCursor();

include ('employeeInformation.php');
?>