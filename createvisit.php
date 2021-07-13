<?php
require 'conn.php';

$patient_id=$_POST['patient_id'];
$visit_notes=$_POST['visit_notes'];
$visit_status=$_POST['visit_status'];
$visit_date=$_POST['visit_date'];
$created_by=$_POST['user_id']; 
$scheduled_date=$_POST['visit_date'];

$query=mysqli_query($conn,"INSERT INTO visits(patient_id,schedule_date,date_visited,visit_status,pay_status,visit_note,created_by) VALUES('$patient_id','$scheduled_date','$visit_date','$visit_status','Pending','$visit_notes','$created_by')");

if ($query) {
	header("Location:visits.php?msg=New Visit Record Has been Created");

}else{
	header("Location:visits.php?err=Sorry System Encounter An Error ".mysqli_error($conn));
}



