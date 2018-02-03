

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
.show-more > p {
    display: inline-block;
}
</style>
<?php $this->session->userdata('loginId'); ?>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Manage Users</h3>
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
        <!-- SEARCH HERE  --> 
            <div class="row-fluid top-act">
               <form action='<?php echo base_url();?>manageUsers' id="searchData" method="GET">
               <div class="form-group search"> 
                  <input type="text" class="search-custom" value="<?php echo $this->input->get('searchText')!= '' ? $this->input->get('searchText'):'';?>" name="searchText" onkeyup="stoppedTyping()" placeholder="search user ">
               </div>
               
               <div class="form-group">
                  <input class="btn btn-icon-only green Add_new addnewsub" id="start_button" type="submit" >
                  <a class="btn red reset p-xl-pad" href="<?php echo base_url(); ?>manageUsers">Reset</a>
               </div>
               </form>
                
            </div>
        <div class="row row_mrg">
            <div class="col-md-12">
                <div class="portlet-body flip-scroll table-scrollable">
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <th width="50px"> S No.</th>
                                <th> First Name </th>
                                <th class="numeric"> Last Name </th>
                                <th class="numeric"> Email </th>
                                <th class="numeric"> Phone </th>
                                <th class="numeric"> Birthday </th>
                                <th class="numeric"> Created</th>
                                <th class="numeric"> Country </th>
                                <th class="numeric"> Action </th>
                                <!--<th class="numeric"> Cab Referral Id </th>
                                <th class="numeric"> UBER/LYFT Referral code </th>
                                <th class="numeric"> Last Active Date </th> -->
                            </tr>
                        </thead>
                        <?php
                         if (count($result) > 0) {
                            if ($_GET['page'] == '') {
                                        $i = 0;
                                    } else {
                                        $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                    }
                            foreach ($result as $key => $list) {
                                $bt = new DateTime($list['birthday']);
                                $dt = new DateTime($list['createdon']);
                                
                                ?>
                                    <tr>
                                        <td> <?php echo $i + 1; ?> </td>
                                        <td class="numeric editable"><?php echo $list['fname']; ?> </td>
                                        <td class="numeric editable"><?php echo $list['lname'];?></td>
                                        <td class="numeric editable"><?php echo $list['email'];?></td>
                                        <td class="numeric editable"><?php echo $list['phone']; ?> </td>
                                        <td class="numeric editable"><?php echo $bt->format('d-M-Y');   ?></td>
                                        <td class="numeric editable"><?php echo $dt->format('d-M-Y');?></td>
                                        <td class="numeric editable"><?php echo $list['country'];?></td>
                                        <!--
                                        <td class="numeric editable"><?php //echo $list['cabReferralId'];?></td>
                                        <td class="numeric editable"><?php //echo $list['cabReferralCode'];?></td>
                                        <td class="numeric editable"><?php //echo date("d-m-Y",strtotime($list['modifiedOn']));?></td>
                                        -->
                                        <td class="action">
                                            <span class="no_wrap">
                                            <?php 
                                            $titleTxt = $list['active']=='1' ? 'Block this user' : 'Activate this user';
                                            if($list['active']=='1'){ 
                                                echo '<button title="'.$titleTxt.'" id="blockUser" userId="'.$list['id'].'"  status="'.$list['active'].'" class="btn btn-default btn-xs"> <i class="fa fa-ban" style="color:#4e4141;"></i> </button>';
                                            }else{
                                                 echo '<button title="'.$titleTxt.'" id="activeUser" userId="'.$list['id'].'"  status="'.$list['active'].'" class="btn btn-default btn-xs"> <i class="fa fa-check" style="color:#4e4141;"></i> </button>';              
                                            } 
                                            /*echo '<a title="View" href="userDetail/'.$list['id'].'" class="btn btn-default btn-xs"><i class="fa fa-eye" style="color:#5b9bd1;"></i></a>' */
                                              echo '<button title="Delete" id ="userDel" href="userDelete/'.$list['id'].'" class="btn btn-default btn-xs"> <i class="fa fa-trash" style="color:red;"></i> </button>';
                                            ?>
                                            </span>
                                        </td>
                                            
                                    </tr>                                
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tbody>
                                <tr>
                                    <td colspan="6" style="text-align: center"> No Record Found </td>
                                </tr>
                            </tbody>
<?php } ?>
                    </table>
                    <div class="row row_mrg paginate">
                        <div class="row row_mrg paginate">
                            <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                                <span  class="right show-more" ><a href="<?php echo base_url();?>manageUsers" data-ci-pagination-page="2" rel="next">Back</a></span>
                            <?php }else{ ?>
                                <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?><a class= "btn" href="<?php echo base_url();?>manageUsers?all=true" data-ci-pagination-page="2" rel="next">All</a></span>
                            <?php } ?>
                        </div>
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


<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
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
        
        
    });
    
    
</script> 
<script type="text/javascript">
    
$(document).ready(function(){
     
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

//    document.getElementById('resetusers').onclick=function(){
//        location.href = "<?php echo $this->config->base_url(); ?>manage_users";
//    }
    });
</script> 
