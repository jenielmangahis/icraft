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
    <p class="title" style="padding-left: 26px;padding-bottom: 10px;">Appointments</p>
    <div class="ground-elements" style="padding: 20px !important;">
        <div class="top-action-bar-mobile">
          <form action="<?php echo base_url(); ?>appointments" method="GET" >
            <div class="col-6 left">
              <div class="Search"><input type="text" placeholder="Search" name="search" /></div>
            </div>
            <div class="col-6 left">
              <div class="Combo">
                  <select name="status" class="mozkit-fix">
                      <option value="">All</option>
                      <option value="0">Pending</option>
                      <option value="1">Confirm</option>
                      <option value="2">Re-schedule</option>
                      <option value="3">Cancel</option>
                  </select>
                  <span class="btn-bk"></span>
              </div>
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
     if(count($appointments)>0){     
          foreach($appointments as $key=>$values){
              $data = getUsers($values['user_id']);
    ?>
    <a href="<?php echo base_url(); ?>clientDetail/<?php echo $values['user_id']; ?>">
      <div class="container-appointments">
        <div class="col-2 left">
          <img class="mobile-profile-img" src="<?php echo $data['profile_pic'];?>" />     
        </div> 
        <div class="col-8 left" style="padding-left:5px;">
          <span class="txt-mobile"><?php echo $data['first_name'].' '. $data['last_name']; ?></span><br/>
          <span class="txt-mobile"><?php echo "Recovery" ?></span>
          <br/><br/>
          <?php 
            if($values['status'] == '0'){
                  echo "<span class='txt-mobile cancelled'>Pending</span>";
              }else if($values['status'] == '1'){
                  echo "<span class='txt-mobile confirmed'>Confirmed</span>";
              }else if($values['status'] == '2'){
                  echo "<span class='txt-mobile pending'>Re-Schedule</span>";
              }else if($values['status'] == '3'){
                  echo "<span class='txt-mobile cancelled'>Cancelled</span>";
              }else{
            } 
          ?>
        </div>
        <div class="col-2 left" style="padding-right: 10px;">
          <span class="txt-mobile"><?php echo $values['appointment_time']; ?></span>
        </div>
        <br style="clear:both;">
      </div>
    </a>
   <?php  } }else{ ?>
         <span class="txt-mobile">No Data Found</span>
   <?php } ?>

</section>
<br style="clear:both;"><br style="clear:both;">
<?php include('templates/footer.php')  ?>
