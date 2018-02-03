<?php include('templates/header-mobile.php')  ?>
<section class="main-body">
    <p class="title" style="padding-left: 26px;padding-bottom: 10px;">ANALYSIS</p>
    <br style="clear: both;">
    <?php foreach($appointments as $key => $values){ ?>
      <div class="container-appointments">
          <div class="col-12 left" style="padding-left:5px;">
            <span class="txt-mobile" style="font-weight: bold;"><?php echo $key ?> : Total Appointments <?php echo count($values); ?></span><br/>
          </div>
          <br style="clear: both;"><br/>
          <div class="col-12">
              <table style="width: 100%;border-right: 1px solid #ded9d9;border-top: 1px solid #ded9d9;border-left: 1px solid #ded9d9;">
                <thead>                        
                  <tr class="align-left">
                      <th class="table-left border-1" style="background-color: #847ded;color:white;">Name</th>
                      <th class="table-left border-2" style="background-color: #847ded;color:white;">Appointment Time</th>
                  </tr>
                </thead>
            <?php foreach( $values as $v ){ ?>
                <tr class="align-left">
                    <td class="table-left border-1"><?php echo $v->name ?></td>
                    <td class="table-left border-2"><?php echo $v->appointment_time ?></td>
                </tr>
            <?php } ?>
            </table>
          </div>
        <br style="clear:both;">
      </div>
   <?php  } ?>

</section>
<br style="clear:both;"><br style="clear:both;">
<?php include('templates/footer.php')  ?>
