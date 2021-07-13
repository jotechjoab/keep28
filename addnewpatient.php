<?php
require 'conn.php';

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

$query=mysqli_query($conn,"INSERT INTO patient_details(fname,mname,lname,phone,email,dob,address,nok,nok_phone,created_by) VALUES('$fname','$mname','$lname','$phone','$email','$dob','$address','$nok','$nok_phone','$created_by')");

if ($query) {
	header("Location:patients.php?msg=Patient Record Has been Created");

}else{
	header("Location:patients.php?err=Sorry System Encounter An Error ".mysqli_error($conn));
}



