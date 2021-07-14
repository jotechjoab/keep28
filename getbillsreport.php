   <div class="card-header">
                <?php
                require 'conn.php';
                $from_date=$_POST['from_date']." 00:00:00";
                 $to_date=$_POST['to_date']." 23:59:59";
                 ?>
                <h3 class="card-title">Bills Report From <?php echo $from_date;?> to <?php echo $to_date; ?></h3>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Visit Date</th>
                    <th>Visit Status</th>
                    <th>Pay Status</th>
                    <th>Bill Amount</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                   
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                 
                  $get_resulst=mysqli_query($conn,"SELECT b.id as bid,p.fname,p.lname,p.mname,v.date_visited,v.visit_status,v.pay_status,v.id,v.visit_note,b.bill_amount,b.amount_paid,b.balance FROM patient_details p,visits v, bills b WHERE (v.patient_id=p.id AND v.id=b.visit_id) AND (b.created_at BETWEEN '$from_date' AND '$to_date') ORDER BY b.created_at DESC");


                  $total_biils=0;
                  $total_amount_paid=0;
                  $balance=0;
                  if (mysqli_num_rows($get_resulst)>0) {
                    $i=1;
                    while ($row=mysqli_fetch_array($get_resulst)) {

                   $total_biils+=$row['bill_amount'];
                   $total_amount_paid+=$row['amount_paid'];
                   $balance+=$row['balance'];
                      echo '
                        <tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['fname'].' '.$row['mname'].' '.$row['lname'].'</td>
                    <td>'.$row['date_visited'].'</td>
                    <td>'.$row['visit_status'].'</td>
                    <td>'.$row['pay_status'].'</td>
                    <td>UGX '.number_format($row['bill_amount']).'</td>
                    <td>UGX '.number_format($row['amount_paid']).'</td>
                    <td>UGX '.number_format($row['balance']).'</td>
                 
                      </tr>

                      ';
                    }
                  }

                 ?>   
                 
                  </tbody>
                  <tfoot>
                  <tr>
                 
                    <th colspan="5"></th>
                    
                    <td>Total Billed Amount <br>
                    <b> UGX <?php echo number_format($total_biils); ?></b>
                    </td>
                    <td>Total Amount Paid<br>
                    <b> UGX <?php echo number_format($total_amount_paid); ?></b></td>
                    <td>Total Amount to be Paid <br>
                     <b> UGX <?php echo number_format($balance); ?></b></td>
                    
                
                  </tr>
                  </tfoot>
                </table>


              </div>