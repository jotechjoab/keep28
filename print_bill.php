<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keep28 Dental | Bill Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
  <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-tooth"></i> Keep28 Dental.
                    <small class="float-right">Date: <?php echo date("d/M/Y")?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Keep28 Dental</strong><br>
                    Galaxy House ,Ntinda Bukoto<br>
                    Kampala - Uganda<br>
                    Phone: +256  753592577 / +256 772 592 677<br>
                    Email: abalungi@gmail.com
                  </address>
                </div>
                <?php 

                $bill_id=$_GET['bill_id'];
                $get_pat=mysqli_query($conn,"SELECT p.id,p.fname,p.lname,p.mname,p.address,p.phone,p.email,v.id as visit_id,b.amount_paid,b.balance FROM bills b,patient_details p,visits v WHERE (v.patient_id=p.id AND v.id=b.visit_id) AND b.id='$bill_id'; ");
                $pat=mysqli_fetch_array($get_pat);
                 ?>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $pat['fname'].' '.$pat['mname'].' '.$pat['lname'];?></strong><br>
                    <?php echo $pat['address']; ?><br>
                    Phone: <?php echo $pat['phone']; ?><br>
                    Email: <?php echo $pat['email']; ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Bill No. # <?php echo $bill_id; ?></b><br>
                  <br>
                  <b>Visit ID:</b> <?php echo $pat['visit_id']; ?><br>
                  <b>Patient No.:</b> <?php echo $pat['id']; ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr> <th> #</th>
                      <th>Service</th>
                      <th>Description</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php
                   
                   $get_bill=mysqli_query($conn,"SELECT s.name,s.description,d.cost FROM services s,bill_details d WHERE s.id=d.item_id AND d.bill_id='$bill_id'");
                   $i=1;
                   $bill_amount=0;
                   while($bill=mysqli_fetch_array($get_bill)){
                    $bill_amount+=$bill['cost'];

                    echo '

                    <tr>
                      <td>'.$i++.'</td>
                      <td>'.$bill['name'].'</td>
                      <td>'.$bill['description'].'</td>
                      <td>UGX '.number_format($bill['cost']).'</td>
                    </tr>
                    ';
                   }


                    ?>   
                    
               
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="dist/img/credit/visa.png" alt="Visa">
                  <img src="dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="dist/img/credit/american-express.png" alt="American Express">
                  <img src="dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    <b>Keep28 Dental</b> Pleasant & Comfortable
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>UGX <?php echo number_format($bill_amount); ?></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>UGX <?php echo number_format($bill_amount); ?></td>
                      </tr>
                      <tr>
                        <th>Amount Paid :</th>
                        <td>UGX <?php echo number_format($pat['amount_paid']); ?></td>
                      </tr>
                      <tr>
                        <th>Balance:</th>
                        <td>UGX <?php echo number_format($pat['balance']); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
