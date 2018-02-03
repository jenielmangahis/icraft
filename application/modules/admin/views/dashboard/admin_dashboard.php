<style>
.top-act .form-group {
    float: left;
}
.top-act .form-group input.btn, .top-act .clear-search button{
    margin-left: 4px;
}
.btn.d-grey{
   background-color:#e4e3e3;
}
td.action i.fa.fa-user {
    color: #fff;
}

.modal.fade.in {
    top: 10%;
    padding-right: 15px;
    display: block;
    width: 651px;
    right: 84%;
    left: 49%;
}
.modal{ width:670px; }

.modal-content {
    box-shadow: none !Important;
    border: none !Important;
}
.paginate{     padding-left: 40px; }


input.datetime{
    display: inline-block;
    width:auto;
}

/*----------------- Main Dashboard fields css----------------*/
//@import url(https://weloveiconfonts.com/api/?family=fontawesome);
//@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300);

/* fontawesome */
[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
}
.left {
  float: left;
}
.clear {
clear: both;
}

.buysblock { background: rgba(133, 62, 226, 0.79);}
.commentsblock {  background: rgb(38,168,226);}
.commentshade {  background: #51be71;}
.colorParrot {  background: rgba(105, 191, 52, 0.8);}
.colorPink {  background: rgba(216, 106, 106, 0.8);}

.colorBlog {  background: rgba(0, 62, 115, 0.75);}
.colorFlower {  background: rgba(206, 18, 113, 0.82);}
.colorReddish {  background: rgba(243, 0, 0, 0.77);}
.colorgreeny {  background: rgba(200, 138, 92, 0.79);}
.colorshade {  background: #77909d;}

.metroblock {
    width: 194px;
    background: rgb(38,168,226);
    min-height: 110px;
    padding: 0em 1em 1em 1em;
    color: #fff;
    font-family: 'Open Sans', sans-serif;
    margin-left: 4px;
    margin-bottom: 4px;
}

.metroblock h1, .metroblock h2, .metroblock .icon {
  font-weight: 500 ;
  margin: 0;
  padding: 0;
}
.metroblock .icon {
  font-size: 4em;
}
.metroblock h1 {
  font-size: 3em;
}
.metroblock h1, .metroblock .icon {
  text-align: center;
  margin-bottom: 5px;
}
.metroblock .icon {
  margin-right: .2em;
}
.metroblock .icon i {
    font-size: 36px;
}
h2{font-size:15px;}

//--- js validator 
.error {
    border:1px solid red !important;
    box-shadow:2px 3px 3px 3px black;
    margin: 5px;
}
</style>

<?php $this->session->userdata('loginId'); ?>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
<!--        <h3 class="page-title page_mrg">Manage Users</h3>-->
        <?php echo validation_errors(); ?>
       
        <?php if ($this->session->userdata('SuccessMsg') != "") {  ?>
                    <div class="success alert-info toBeHidden custom-success" role="alert">
                        <?php echo $this->session->userdata('SuccessMsg');
                            $this->session->unset_userdata('SuccessMsg');
                        ?>
                    </div>
        <?php } ?>
        
        <?php if ($this->session->userdata('errorMsg') != "") { 
                ?>
                <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                    <?php echo $this->session->userdata('errorMsg');
                        $this->session->unset_userdata('errorMsg');
                    ?>
                </div>
         <?php  } ?>

        <div class="row-fluid top-act">
           <form action='<?php echo base_url();?>admin_dashboard' id="searchData" method="POST">
           <div class="form-group"> 
               Start <input class="search-custom datetime" id="date_timepicker_start" type="text" value="" name="sdate" placeholder="yyyy-mm-dd">  End <input class="search-custom datetime" id="date_timepicker_end" type="text" value="" placeholder="dddd-mm-dd" name="edate">
           </div>

           <div class="form-group">
               <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" >Reset</a>
               <input class="btn red reset p-xl-pad" id="submit" type="submit" value="Submit">
           </div>
           </form>
          
        </div>
        <div class="form-group pull-right">
            <button class="btn" type="button" onclick="PrintElem('#mydiv')" ><i class="fa fa-print" aria-hidden="true"></i></button>
        </div>
        
        <div class="row row_mrg">
            <div class="col-md-12" id="mydiv">
                <div class="portlet-body flip-scroll table-scrollable" style="padding-top:5px;" >
                    
                    <!-- Total Customer -->
                        <div class="metroblock commentshade left ">
                            <span class="icon fontawesome-briefcase left"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <h1><?php echo $result['customer_counts']; ?></h1>
                            <div class="clear"></div>
                            <h2>Total Customer</h2>
                        </div>
                    <!-- Total Doctors -->    
                        <div class="metroblock buysblock left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                            <h1><?php echo $result['doctor_counts']; ?></h1>
                            <div class="clear"></div>
                            <h2>Total Doctors</h2>
                        </div>                     
                    <!-- Total Orders -->    
                        <div class="metroblock colorParrot left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                            <h1><?php echo $result['total_orders']; ?></h1>
                            <div class="clear"></div>
                            <h2>Total Orders</h2>
                        </div>                     
                    <!-- Scheduled Orders -->
                        <div class="metroblock colorPink left ">
                            <span class="icon fontawesome-briefcase left"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                            <h1><?php echo $result['scheduled_orders']; ?></h1>
                            <div class="clear"></div>
                            <h2>Scheduled Orders</h2>
                        </div>
                    <!-- Orders In-Transit -->    
                        <div class="metroblock colorBlog left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                            <h1><?php echo $result['orders_in_transnit']; ?></h1>
                            <div class="clear"></div>
                            <h2>Orders In-Transit</h2>
                        </div>                    
                    <!-- Orders Completed -->
                        <div class="metroblock colorFlower left ">
                            <span class="icon fontawesome-briefcase left"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                            <h1><?php echo $result['orders_completed']; ?></h1>
                            <div class="clear"></div>
                            <h2>Orders Completed</h2>
                        </div>
                    <!-- Total Appointments -->    
                        <div class="metroblock colorReddish left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-suitcase" aria-hidden="true"></i></span>
                            <h1><?php echo $result['total_appointments']; ?></h1>
                            <div class="clear"></div>
                            <h2>Total Appointments</h2>
                        </div>
                    
                    <!-- Prescription Issued -->    
                        <div class="metroblock colorgreeny left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
                            <h1><?php echo $result['total_appointments']; ?> *</h1>
                            <div class="clear"></div>
                            <h2>Prescription Issued</h2>
                        </div>
                    <!-- Total Products Issued -->    
                        <div class="metroblock commentsblock left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
                            <h1><?php echo $result['total_appointments']; ?> *</h1>
                            <div class="clear"></div>
                            <h2>Total Products </h2>
                        </div>
                    <!-- Total Coupons Issued -->    
                        <div class="metroblock colorshade left ">
                            <span class="icon fontawesome-comments left"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
                            <h1><?php echo $result['total_appointments']; ?> *</h1>
                            <div class="clear"></div>
                            <h2>Coupons redeemed</h2>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model for Block User -->
<div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to block the user? </div>
            <div class="modal-footer">
                <a href="" id="writeDeactivateURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePop">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Activate User -->
<div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to activate the user again? </div>
            <div class="modal-footer">
                <a href="" id="writeActivateURL" class="btn green">Yes</a>
                <a class="btn red" id="closePop">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Delete User -->
<div class="modal fade in" id="deluser" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePopForDel"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to delete the user? </div>
            <div class="modal-footer">
                <a href="" id="writeDeleteURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePopForDel">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>-->
<!--<script src="<?php echo base_url();?>js/jquery.validate.js"></script>-->
<script>
    jQuery(document).ready(function () {
        
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        
        $(document).on("click","#blockUser",function() {//enable disabled driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php// echo $_GET['searchText']; ?>';//write new url to deactivate for popup
            var url = 'activeDeactiveUser/'+status+'/'+userId;
            $('#writeDeactivateURL').attr("href", url);//write new generated url
            $('#block').show();//show popup
        });
        
        $(document).on("click","#activeUser",function() {//enable activate driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText']; ?>'; //write new url to activate for popup
            var url = 'activeDeactiveUser/'+status+'/'+userId;
            $('#writeActivateURL').attr("href", url);//write new generated url
            $('#activate').show();//show popup
        });
        
        $(document).on("click","#closePop",function() {//disable both popup
            $('#block').hide();//hide deactive driver popup
            $('#activate').hide();//hide deactive driver popup
        });
        //--- Delete User
        $(document).on("click","#userDel",function() {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php //echo $_GET['searchText']; ?>';//write new url to deactivate for popup
            //var url = 'activeDeactiveUser/'+status+'/'+userId
            $('#writeDeleteURL').attr("href", xhref);//write new generated url
            $('#deluser').show();//show popup
        });
        
        $(document).on("click","#closePopForDel",function() {//disable both popup
            $('#deluser').hide();//hide deactive driver popup
            $('#ActivateDriver').hide();// hide activate driver popup
        });
        
        //--- Start Date  
        jQuery('#date_timepicker_start').datetimepicker({
            format:'Y-m-d',
            mask :'',
            onShow:function( ct ){
             this.setOptions({
              maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
             })
            },
            timepicker:false
        });
        //--- End Date
        jQuery('#date_timepicker_end').datetimepicker({
            format:'Y-m-d',
            value:'<?php echo date('Y-m-d'); ?>',
            mask : '',
            onShow:function( ct ){
             this.setOptions({
              minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false,
             })
            },
            maxDate:'+1970/01/01',
            timepicker:false
        });
        
        
        //--- SEARCH BOX VALIDATOR 
        $('#start_button').click(function(){ 
            $("#searchData").validate({ 
               rules: {
                   searchText:{
                       required: true
                   }
               },
               messages: {
                   searchText:{
                       required: "Please enter a text to search"
                   }
               }
            });
        });
        
        
        //--- Validate Date Range Form 
        $("#searchData").validate({
            validateOnBlur : false, // disable validation when input looses focus
            errorMessagePosition : 'top', // Instead of 'inline' which is default
            scrollToTopOnError : false, // Set this property to true on longer forms
            //-- date_timepicker_start date_timepicker_end
            rules: {
                    sdate: {
                            required: true
                    },
                    edate: {
                            required: true
                    },
            },
            errorPlacement: function(error, element) {}

        });
                
        
    });
</script> 
