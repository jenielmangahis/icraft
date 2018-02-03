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
        <h3 class="page-title page_mrg">Manage Drivers</h3>
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
        <!-- SEARCH HEVRE -->
            <div class="row-fluid top-act">
               <form action='<?php echo base_url();?>drivers' id="searchData" method="POST">
               <div class="form-group search"> 
                  <input type="text" class="search-custom" value="<?php echo $this->input->get('searchText')!= '' ? $this->input->get('searchText'):'';?>" name="searchText" onkeyup="stoppedTyping()" placeholder="Search Driver">
               </div>
                   
                   
               
               <div class="form-group">
                  <input class="btn btn-icon-only green Add_new addnewsub" id="start_button" type="submit" >
                  <a class="btn red reset p-xl-pad" href="<?php echo base_url(); ?>drivers">Reset</a>
               </div>
                   
                   
                 <div class="col-xs-2 ">
                 <select onchange="changeStatus()" class="form-control" name="status">
                    <option value="">Status</option>
                      <option <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? 'selected=selected':''?> value="1">Online</option>
                      <option <?php echo isset($_GET['status']) && $_GET['status'] == 0 ? 'selected=selected':''?> value="0">Off Line</option>
                 </select>
                </div>   
                   
               </form>
                
            </div>
        
       
       
        <div class="row-fluid top-act">
            <div class="form-group pull-right">
               <a class="btn red reset p-xl-pad" href="add-driver" id="addDriver"><i class="fa fa-plus" style="color:white;"></i> Add New</a>
            </div>
        </div>
        
        
         
        
        <div class="row row_mrg">
            <div class="col-md-12">
                <div class="portlet-body flip-scroll table-scrollable">
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <th width="50px"> S No.</th>
                                <th class="numeric"> Driver Name </th>
                                <th class="numeric"> Email </th>
                                <th class="numeric"> Contact</th>
                                <th class="numeric"> Vehicle </th>
                                <th class="numeric"> Start Location </th>
                                <th class="numeric"> Status</th>
                                <th class="numeric"> Action </th>
                      
                            </tr>
                        </thead>
                        <?php
                        if (count($driverlist) > 0) 
                        {
                            $i = 0;

                            if ( isset($_GET['page']) )
                            {
                                if ($_GET['page'] == '') {
                                    $i = 0;
                                } else {
                                    $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                }
                            }
                            foreach ($driverlist as $key => $list) {
                                //print_r($list);die;
                                /*$ct = new DateTime($list['createdon']);
                                $pt = new DateTime($list['postdate']);*/
                                
                                ?>
                                    <tr>
                                         <?php $status = $list['online'] == '1' ? 'Online' : 'Offline'; ?>
                                        
                                        <td> <?php echo $i + 1; ?> </td>
                                        <td class="numeric editable"><?php echo $list['first_name']." ".$list['last_name']; ?> </td>

                                        <!--<td class="numeric editable"><?php echo ucfirst($list['first_name']." ".$list['last_name']); ?> </td>-->
                                        <td class="numeric editable"><?php echo $list['email'];?></td>
                                        <td class="numeric editable"><?php echo $list['contact_number'];?></td>
                                        <td class="numeric editable"><?php echo $list['registration_number'];?></td>
                                        
                                         <td class="numeric editable"    ><?php echo $list['registration_number'];?></td>
                                         <!--<td class="numeric editable"    ><?php echo $list['name'];?></td>-->
                                        
                                        <td class="numeric editable" title=""><?php echo $status; ?> </td>
                 
                                        <td class="action">
                                            <span class="no_wrap">
                                            <?php 
                                            
                                            echo '<a title="View Details" id="view" href="view-driver-detail/'.$list['driver_id'].'" class="btn btn-default btn-xs"> <i class="fa fa-eye" style="color:green;"></i> </a>';
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
                        <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                            <span  class="right show-more" ><a href="<?php echo base_url();?>drivers" data-ci-pagination-page="2" rel="next">Back</a></span>
                        <?php }else{ ?>
                            <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?><a class= "btn" href="<?php echo base_url();?>drivers?all=true" data-ci-pagination-page="2" rel="next">All</a></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Model for Block Health -->
<div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to block this health record? </div>
            <div class="modal-footer">
                <a href="" id="writeBlockURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePop">No</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Activate Health -->
<div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to activate this health record? </div>
            <div class="modal-footer">
                <a href="" id="writeActiveURL" class="btn green">Yes</a>
                <a class="btn red" id="closePop">No</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Delete Country -->
<div class="modal fade in" id="delHealthInfo" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePopForDel"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to delete the Health Info? </div>
            <div class="modal-footer">
                <a href="" id="writeDeleteURL"  class="btn green">Delete</a>
                <a class="btn red"  id="closePopForDel">Cancel</a>
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
        
        $(document).on("click","#blockHealth",function() {//enable disabled driver message popup
            var healthInfoId = $(this).attr('healthInfoId');//get driver Id
            var status = $(this).attr('status');//get driver status
            var url = 'activeDeactiveHealthInfo/'+status+'/'+healthInfoId;
            $('#writeBlockURL').attr("href", url);//write new generated url
            $('#block').show();//show popup
        });
        
        $(document).on("click","#activateHealth",function() {//enable activate driver message popup
            var healthInfoId = $(this).attr('healthInfoId');//get driver Id
            var status = $(this).attr('status');//get driver status
            var url = 'activeDeactiveHealthInfo/'+status+'/'+healthInfoId;
            $('#writeActiveURL').attr("href", url);//write new generated url
            $('#activate').show();//show popup
        });
        
        $(document).on("click","#closePop",function() {//disable both popup
            $('#block').hide();//hide deactive driver popup
            $('#activate').hide();//hide deactive driver popup
        });
        
        //--- Delete Health Info
        $(document).on("click","#deleteHealthInfo",function() {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php //echo $_GET['searchText']; ?>';//write new url to deactivate for popup
            //var url = 'activeDeactiveUser/'+status+'/'+userId
            $('#writeDeleteURL').attr("href", xhref);//write new generated url
            $('#delHealthInfo').show();//show popup
        });
        
        $(document).on("click","#closePopForDel",function() {//disable both popup
            $('#delCountry').hide();//hide deactive driver popup
            $('#delHealthInfo').hide();// hide activate driver popup
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
    
    function changeStatus(){
     $('#searchData').submit();   
    }
    
    
</script> 
