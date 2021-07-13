<?php
require 'conn.php';

$bill_id=$_POST['bill_id'];
$user_id=$_POST['user_id'];
$amount_to_pay=$_POST['amount_to_pay'];
$cash_tendered=$_POST['cash_tendered'];
$change=$_POST['change'];
$balance=$_POST['balance'];

$today_pay=0;

$get_bill=mysqli_query($conn,"SELECT * FROM bills WHERE id='$bill_id'");
$bill=mysqli_fetch_array($get_bill);
$visit_id=$bill['visit_id'];

if ($balance==0) {
	$today_pay=$amount_to_pay;
	mysqli_query($conn,"UPDATE visits SET pay_status='Paid',updated_by='$user_id' WHERE id='$visit_id'");

}else{
	$today_pay=$cash_tendered;
	mysqli_query($conn,"UPDATE visits SET pay_status='Partial',updated_by='$user_id' WHERE id='$visit_id'");	
}

$amount_paid=$bill['amount_paid']+$today_pay;


$update_bill=mysqli_query($conn,"UPDATE bills SET amount_paid='$amount_paid',balance='$balance', updated_by='$user_id' WHERE id='$bill_id'");

if ($update_bill) {
	
	$add_pay=mysqli_query($conn,"INSERT INTO payments(bill_id,amount_paid,created_by) VALUES ('$bill_id','$today_pay','$user_id')");

	if ($add_pay) {
		header("location:bill_details.php?msg=Success! Payment has been received for this bill&bill_id=".$bill_id);
	}else{
	header("location:bill_details.php?err=Sorry System could't Recieve This payment ".mysqli_error($conn)."&bill_id=".$bill_id);	
	}
}else{
	header("location:bill_details.php?err=Sorry System could't Update this Bill Record ".mysqli_error($conn)."&bill_id=".$bill_id);
}

