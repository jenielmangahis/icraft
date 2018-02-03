<?php include('templates/header-mobile.php')  ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $("#datepicker").datepicker();        
  });
  </script>
<section class="main-body">
    <p class="title" style="padding-left: 26px;padding-bottom: 10px;">Prescriptions</p>
    <div class="ground-elements" style="padding: 20px !important;">
        <div class="top-action-bar-mobile">
          <form action="<?php echo base_url(); ?>appointments" method="GET" >
            <div class="col-12">
              <div class="Search" style="padding-right: 0px;"><input type="text" placeholder="Search" name="search" /></div>
            </div>

            <br style="clear: both;"><br style="clear: both;">
            <div class="col-6 left">
              <div class="Search">
                  <div class="datepiker">
                      <input class="date-appointments" id="datepicker" type="text" placeholder="MM/DD/YY" name="date">
                      <span class="btn-bk cal"></span>
                  </div>
              </div>
            </div>

            <div class="col-3 left">
                <div class="actions-fil">
                    <span class="thm-btn cstm-btn"><input type="submit" value="Go" class="icon-search thm-btn"/></span>
                </div>
            </div>

            <div class="col-3 left">
              <div class="container-right">
                <div class="actions-fil">
                  <a href="<?php echo base_url(); ?>appointments" class="reset-btn">Reset</a>
                </div>
              </div>
            </div>

          </form>
        </div>
    </div>
    <br style="clear: both;">
        <?php
   if(count($prescriptions)>0){     
        foreach($prescriptions as $key=>$values){
            $data = getUsers($values['user_id']);
        ?>
      <div class="container-appointments">
        <div class="col-2 left">
          <img class="mobile-profile-img" src="<?php echo $data['profile_pic'];?>" />     
        </div> 
        <div class="col-10 left" style="padding-left:5px;">
          <span class="txt-mobile"><?php echo $data['first_name'].' '. $data['last_name']; ?></span><br/>
          <span class="txt-mobile"><?php echo $data['email']; ?></span><br/><br/>
          <span class="txt-mobile color-purple">APPOINTMENT DATE</span><br/>
          <span class="txt-mobile"><?php echo $values['appointment_time']; ?></span><br/><br/>
          <span class="txt-mobile color-purple">APPOINTMENT</span><br/>
          <span class="txt-mobile"><?php echo 'Recovery';  ?></span><br/><br/>
          <a href="<?php echo base_url(); ?>prescriptionDetail/<?php echo $values['user_id']; ?>" class="purple-button-mobile">View</a>
        </div>
        <br style="clear:both;">
      </div>  
   <?php  } }else{ ?>
         <span class="txt-mobile">No Data Found</span>
   <?php } ?>

</section>
<br style="clear:both;"><br style="clear:both;">
<?php include('templates/footer.php')  ?>
