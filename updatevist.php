<?php
require 'conn.php';
$clinical_notes=$_POST['clinical_notes'];
$next_visit_date=$_POST['next_visit_date'];
$visit_status=$_POST['visit_status'];
$visit_id=$_POST['visit_id'];
$user_id=$_POST['user_id'];
$patient_id=$_POST['patient_id'];
$last_visit_date=$_POST['last_visit_date'];


$update_visit=mysqli_query($conn,"UPDATE visits SET clinical_notes='$clinical_notes',visit_status='$visit_status',updated_by='$user_id' WHERE id='$visit_id'");


if ($update_visit) {

	$set_next_visit=mysqli_query($conn,"INSERT INTO booked_visits(patient_id,next_visit_date,last_visit_date,last_visit_id,created_by) VALUES('$patient_id','$next_visit_date','$last_visit_date','$visit_id','user_id')");


if ($set_next_visit) {
	createdbill($visit_id,$user_id);
}else{
	header("Location:seepatient.php?err=An Error Happened ".mysqli_error($conn)."&visit_id=".$visit_id);
}


	
}else{
	//to do 
	header("Location:seepatient.php?err=An Error Happened ".mysqli_error($conn)."&visit_id=".$visit_id);
}




function createdbill($visit_id,$user_id){
	require 'conn.php';
$items = array() ;
$items=$_POST['services'];
$bill_amount=0;
$bill_id=0;

foreach ($items as $key => $value) {
	$get_serv=mysqli_query($conn,"SELECT * FROM services WHERE id='$value'");
	$serv=mysqli_fetch_array($get_serv);
	$bill_amount+=$serv['cost'];
}
 

$query="INSERT INTO bills(visit_id,bill_amount,created_by) VALUES('$visit_id','$bill_amount','$user_id')";

if ($conn->query($query)===TRUE) {
	$bill_id=$conn->insert_id;

foreach ($items as $key => $value) {
	$get_serv=mysqli_query($conn,"SELECT * FROM services WHERE id='$value'");
	$serv=mysqli_fetch_array($get_serv);
	$price=$serv['cost'];

	$insert_billdetails=mysqli_query($conn,"INSERT INTO bill_details(bill_id,item_id,cost,created_by) VALUES('$bill_id','$value','$price','$user_id')");

}
header("Location:bill_details.php?msg=Patient Bill has been created &bill_id=".$bill_id);

}else{
	header("Location:seepatient.php?err=An Error Happened ".mysqli_error($conn)."&visit_id=".$visit_id);
}


}