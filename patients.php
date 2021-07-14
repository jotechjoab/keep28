<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keep28 Dental | Patients Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
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
            <h1>Patient Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Patient Details</li>
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
                <h3 class="card-title">Patients Details</h3>
                <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modal-default">create New Patient </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Next Of Kin</th>
                    <th>Date Created</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                 
                  $get_resulst=mysqli_query($conn,"SELECT * FROM patient_details ORDER BY created_at DESC");

                  if (mysqli_num_rows($get_resulst)>0) {
                    $i=1;
                    while ($row=mysqli_fetch_array($get_resulst)) {

                      $birthDate = explode("-", $row['dob']);
                    //  print_r($birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
 
                      echo '
                        <tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['fname'].' '.$row['mname'].' '.$row['lname'].'</td>
                    <td>'.$age.'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['nok'].'</td>
                    <td>'.$row['created_at'].'</td>
                    <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-success btn-flat">Action</button>
                    <button type="button" class="btn btn-success btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#" onclick="updatedetails('.$row['id'].')">Edit Record</a>
                      <a class="dropdown-item" href="#" onclick="newvisit('.$row['id'].',\''.$row['fname'].' '.$row['mname'].' '.$row['lname'].'\')">New Visit</a>
                      <a class="dropdown-item" href="#">Schedule Visit</a>
                      <a class="dropdown-item" href="#">Patient History</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Delete Record</a>
                    </div>
                   </div>
                  </td>
                      </tr>

                      ';
                    }
                  }

                 ?>   
                 
                  </tbody>
                  <tfoot>
                  <tr>
                   <th>#</th>
                    <th>Name</th>
                     <th>Age</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Next Of Kin</th>
                    <th>Date Created</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>



   <div class="modal fade" id="modal-visits" >
        <div class="modal-dialog modal-xl" >
          <div class="modal-content" >
            <div class="modal-header">
              <h4 class="modal-title">Create New Visit</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" >
               <form method="POST" action="createvisit.php">
              <div class="row">
               
                  <div class="form-group col-md-12" >
                    Patient Name
                    <input type="text" name="name" class="form-control" placeholder="Patient Name " readonly="" id="pname">
                  </div>
                  <div class="form-group col-md-12" >
                    Visit Notes 
                    <textarea type="text" name="visit_notes" class="form-control" placeholder="Visit Notes"></textarea>
                  
                  </div>
                  <div class="form-group col-md-12" >
                    Visit Date
                    <input type="date" name="visit_date" class="form-control" placeholder="Visit Date" required="">
                  </div>
                  <div class="form-group col-md-12" >
                   Visit Status
                   <select class="form-control" name="visit_status">
                     <option selected="" disabled="">Select Status</option>
                     <option>Scheduled</option>
                     <option>Confirmed</option>
                   </select>
                  </div>
                 
                    <input type="hidden" name="user_id" value="<?php echo $userdetails['id'];?>">
                    <input type="hidden" name="patient_id" id="patient_id">
                 
                <div class="form-group col-md-6" >
                  <br>
                    <button type="submit" class="btn btn-primary">Create Visit</button>
                  </div>
                </div>
            </form>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



        <div class="modal fade" id="modal-default" >
        <div class="modal-dialog modal-xl" >
          <div class="modal-content" >
            <div class="modal-header">
              <h4 class="modal-title">Create New Patient</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" >
               <form method="POST" action="addnewpatient.php">
              <div class="row">
               
                  <div class="form-group col-md-6" >
                    First Name 
                    <input type="text" name="fname" class="form-control" placeholder="First Name " required="">
                  </div>
                  <div class="form-group col-md-6" >
                    Middle Name 
                    <input type="text" name="mname" class="form-control" placeholder="Middle Name ">
                  </div>
                  <div class="form-group col-md-6" >
                    Last Name 
                    <input type="text" name="lname" class="form-control" placeholder="Last Name " required="">
                  </div>
                  <div class="form-group col-md-6" >
                    Phone Number
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required="">
                  </div>
                  <div class="form-group col-md-6" >
                   Email
                    <input type="email" name="email" class="form-control" placeholder="Email ">
                  </div>
                  <div class="form-group col-md-6" >
                    Date Of Birth 
                    <input type="date" name="dob" class="form-control" placeholder="Date OF Birth" required="">
                  </div>
                  <div class="form-group col-md-6" >
                   Address
                    <input type="text" name="address" class="form-control" placeholder="Address" required="">
                  </div>
                  <div class="form-group col-md-6" >
                  Next Of Kin
                    <input type="text" name="nok" class="form-control" placeholder="Next Of Kin">
                  </div>
                  <div class="form-group col-md-6" >
                    Next Of Kin Phone Number
                    <input type="text" name="nok_phone" class="form-control" placeholder="Next Of Kin Phone Number  ">
                    <input type="hidden" name="user_id" value="<?php echo $userdetails['id'];?>">
                  </div>
                <div class="form-group col-md-6" >
                  <br>
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                  </div>
                </div>
            </form>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



       <div class="modal fade" id="modal-editdetails" >
        <div class="modal-dialog modal-xl" >
          <div class="modal-content" >
            <div class="modal-header">
              <h4 class="modal-title">Update Patient Details </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" >
               <form method="POST" action="update_patient_details.php">
              <div class="row">
               
                  <div class="form-group col-md-6" >
                    First Name 
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name " required="">
                  </div>
                  <div class="form-group col-md-6" >
                    Middle Name 
                    <input type="text" name="mname" id="mname" class="form-control" placeholder="Middle Name ">
                  </div>
                  <div class="form-group col-md-6" >
                    Last Name 
                    <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name " required="">
                  </div>
                  <div class="form-group col-md-6" >
                    Phone Number
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone Number" required="">
                  </div>
                  <div class="form-group col-md-6" >
                   Email
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email ">
                  </div>
                  <div class="form-group col-md-6" >
                    Date Of Birth 
                    <input type="date" name="dob" id="dob" class="form-control" placeholder="Date OF Birth" required="">
                  </div>
                  <div class="form-group col-md-6" >
                   Address
                    <input type="text" name="address" id="address" class="form-control" placeholder="Address" required="">
                  </div>
                  <div class="form-group col-md-6" >
                  Next Of Kin
                    <input type="text" name="nok" id="nok" class="form-control" placeholder="Next Of Kin">
                  </div>
                  <div class="form-group col-md-6" >
                    Next Of Kin Phone Number
                    <input type="text" name="nok_phone" id="nok_phone" class="form-control" placeholder="Next Of Kin Phone Number  ">
                    <input type="hidden" name="user_id" value="<?php echo $userdetails['id'];?>">
                    <input type="hidden" name="id" id="id" >
                  </div>
                <div class="form-group col-md-6" >
                  <br>
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                  </div>
                </div>
            </form>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>









              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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

  function newvisit(id,name){
      $("#modal-visits").modal("show");
      $("#pname").val(name);
      $("#patient_id").val(id);
  }

  function updatedetails(id){
     $("#modal-editdetails").modal("show");

     $.post("getpatientdetails.php", { id: id},
function(data) {
  data = $.parseJSON(data);
  console.log(data.fname);
    $("#fname").val(data.fname);
    $("#lname").val(data.lname);
    $("#mname").val(data.mname);
    $("#phone").val(data.phone);
    $("#email").val(data.email);
    $("#dob").val(data.dob);
    $("#address").val(data.address);
    $("#nok").val(data.nok);
    $("#nok_phone").val(data.nok_phone);
    $("#id").val(data.id);
});
  }
</script>
</body>
</html>
