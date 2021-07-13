<?php
require 'conn.php';
$id=$_POST['id'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$mname=$_POST['mname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$dob=$_POST['dob'];
$address=$_POST['address'];
$nok=$_POST['nok'];
$nok_phone=$_POST['nok_phone'];
$created_by=$_POST['user_id']; 

$query=mysqli_query($conn,"UPDATE  patient_details SET fname='$fname',mname='$mname',lname='$lname',phone='$phone',email='$email',dob='$dob',address='$address',nok='$nok',nok_phone='$nok_phone' WHERE id='$id'");

if ($query) {
	header("Location:patients.php?msg=Patient Record Has been Updated");

}else{
	header("Location:patients.php?err=Sorry System Encounter An Error ".mysqli_error($conn));
}



