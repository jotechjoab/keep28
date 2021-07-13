<?php include 'session.php'; ?>
<?php 
$visit_id= $_GET['visit_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keep28 Dental | See Patient</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
    <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
 <?php include 'nav.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<?php 
include 'aside.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>See Patient</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">See Patient</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           <?php 
            if (isset($_GET['msg'])) {
              echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$_GET['msg'].'</div>';
            }

             if (isset($_GET['err'])) {
              echo '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$_GET['err'].'</div>';
            }


           ?>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patient Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                    <?php 
                 
                  $get_resulst=mysqli_query($conn,"SELECT p.id as pid,p.fname,p.lname,p.mname,v.date_visited,v.visit_status,v.pay_status,v.id,v.visit_note,p.address,p.dob FROM patient_details p,visits v WHERE v.patient_id=p.id AND v.id='$visit_id'");

                 $row=mysqli_fetch_array($get_resulst);
                 $birthDate = explode("-", $row['dob']);
                    //  print_r($birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
 
?>
                  
                  <tr>
                    <td>Name
                      <br><strong>
                      <?php echo ''.$row['fname'].' '.$row['mname'].' '.$row['lname'].''; ?></strong>
                    </td>
                    <td>Address
                      <br><strong>
                      <?php echo ''.$row['address'].'';?></strong>
                    </td>
                    <td>Age
                      <br><strong>
                      <?php echo $age; ?></strong>
                    </td>
                  </tr>
                  <tr>                    
                    <td>Visit Notes
                      <br><strong>
                      <?php echo ''.$row['visit_note'].'';?></strong></td>
                    <td>Visit date
                      <br><strong>
                      <?php echo ''.$row['date_visited'].'';?></strong></td>
                    <td>Visit Status
                      <br><strong>
                      <?php echo ''.$row['visit_status'].'';?></strong></td>
                  </tr>
                  </thead>
               
                
                </table>



  
              </div>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->

      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Treatment Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST" action="updatevist.php">
                <div class="form-group col-md-12">
                  <label>Select Billed Services For The Patient </label>
                  <select class="select2" multiple="multiple" data-placeholder="Select Billed Services For The Patient " style="width: 100%;" name="services[]">
                    <?php
                    $get_services=mysqli_query($conn,"SELECT * FROM services");
                    while($serv=mysqli_fetch_array($get_services)){
                      echo '<option value="'.$serv['id'].'">'.$serv['name'].'</option>';
                    }

                     ?>
                    
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label>Clinical Notes </label>
                  <textarea class="form-control" placeholder="Clinical Notes " name="clinical_notes"></textarea>
                </div>

                <div class="row">
                 <div class="form-group col-md-6">
                  <label>Next Visit date </label>
                  <input type="date" name="next_visit_date" class="form-control">
                </div>
                 <div class="form-group col-md-6">
                  <label>Visit Status </label>
                   <select class="form-control" name="visit_status">
                     <option selected="" disabled="">Select Status</option>
                     <option>Scheduled</option>
                     <option>Confirmed</option>
                     <option>Completed</option>
                     <option>Cancled</option>
                   </select>
                </div>
              </div>
                <input type="hidden" name="visit_id" value="<?php echo $visit_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $userdetails['id']; ?>">
                <input type="hidden" name="patient_id" value="<?php echo $row['pid']; ?>">
                <input type="hidden" name="last_visit_date" value="<?php echo $row['date_visited']; ?>">
              <button class="btn btn-success">Save Details</button>

          


          </form>
  
              </div>
              <!-- /.card-body -->
            </div>






          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });


   //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  function newvisit(id,name){
      $("#modal-visits").modal("show");
      $("#pname").val(name);
      $("#patient_id").val(id);
  }
</script>
</body>
</html>
