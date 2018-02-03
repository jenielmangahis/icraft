<?php include('templates/header.php')  ?>
<style>
.appointment-date{
  display: block;
  padding: 10px;
  background-color: #847ded;
  color:#ffffff;
  margin-left: 1px;
  margin-top: 15px;
}
</style>
<section class="main-body">
    <p class="title">Analysis</p>
        <div class="ground-elements">
          <div class="data-details">
            <?php foreach($appointments as $key => $values){ ?>
              <h4 class="appointment-date"><?php echo $key ?> : Total Appointments <?php echo count($values); ?></h4>
              <table>
                <thead>                        
                  <tr>
                      <th>Name</th>
                      <th>Appointment Time</th>
                  </tr>
                </thead>
              <?php foreach( $values as $v ){ ?>
                  <tr>
                      <td><?php echo $v->name ?></td>
                      <td><?php echo $v->appointment_time ?></td>
                  </tr>
              <?php } ?>
              </table>
            <?php } ?>
          </div>
        </div>
    </section>

<?php include('templates/footer.php')  ?>
