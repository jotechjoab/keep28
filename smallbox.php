 <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $patient_number=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM patient_details")); ?>
                <h3><?php echo number_format($patient_number);?></h3>

                <p>Registered Patients</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="patients.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php $visits_week=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM visits WHERE YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1)")); ?>
                <h3><?php echo number_format($visits_week);?></h3>

                <p>Patient visits This Week</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="visits.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
               <?php $patient_week=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM patient_details WHERE YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1)")); ?>
                <h3><?php echo number_format($patient_week);?></h3>

                <p>New Patients This Week</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="patients.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php $today_patients=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_visits WHERE date(next_visit_date) = current_date AND status=0")); ?>
                <h3><?php echo number_format($today_patients);?></h3>
                <p>Patients On Schedule Today</p>
              </div>
              <div class="icon">
                <i class="ion ion-clock"></i>
              </div>
              <a href="bookings.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>