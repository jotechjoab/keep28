   <div class="card-header">
                <?php
                require 'conn.php';
                $from_date=$_POST['from_date']." 00:00:00";
                 $to_date=$_POST['to_date']." 23:59:59";
                 ?>
                <h3 class="card-title">Payments Report From <?php echo $from_date;?> to <?php echo $to_date; ?></h3>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Bill No</th>
                    <th>Payment Date</th>
                    <th>Amount Paid</th>
                   
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                 

                  $get_resulst=mysqli_query($conn,"SELECT b.id as bid,p.fname,p.lname,p.mname,s.amount_paid,s.bill_id,s.created_at FROM patient_details p,payments s, bills b,visits v WHERE (v.patient_id=p.id AND v.id=b.visit_id) AND s.bill_id=b.id AND (s.created_at BETWEEN '$from_date' AND '$to_date' ORDER BY s.created_at DESC)");

                  $total_amount=0;


                  if (mysqli_num_rows($get_resulst)>0) {
                    $i=1;
                    while ($row=mysqli_fetch_array($get_resulst)) {

                       $total_amount+=$row['amount_paid'];

                     
                      echo '
                        <tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['fname'].' '.$row['mname'].' '.$row['lname'].'</td>
                    <td>'.$row['bill_id'].'</td>
                    <td>'.$row['created_at'].'</td>
                    <td> UGX '.number_format($row['amount_paid']).'</td>
                   
                      </tr>

                      ';
                    }
                  }else{
                    echo '<tr><td colspan="5" style="text-align:center;"> Sorry No Data Found </td></tr>';
                  }

                 ?>   
                 
                  </tbody>
                  <tfoot>
                  <tr>
                   <th colspan="3"></th>
                   
                    <th>Total Amount</th>
                    <th>UGX <?php echo number_format($total_amount); ?></th>
                    
                  </tr>
                  </tfoot>
                </table>


              </div>