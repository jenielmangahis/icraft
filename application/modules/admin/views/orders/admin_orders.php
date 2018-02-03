
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
.selectSearch{
    display : inline-block;
    width : 100px;
    padding: 0px 3px !important;
    font-weight:bold;
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
    width: 100px;
    padding-left: 10px;
    border-radius : 0px !important  ;
}

/*----------------- Main Dashboard fields css----------------*/


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
.colorParrot {  background: rgba(105, 191, 52, 0.8);}
.colorPink {  background: rgba(216, 106, 106, 0.8);}

.colorBlog {  background: rgba(0, 62, 115, 0.75);}
.colorFlower {  background: rgba(206, 18, 113, 0.82);}
.colorReddish {  background: rgba(243, 0, 0, 0.77);}
.table-scrollable > .table-bordered {font-size: 12px;}
.metroblock {
    width: 240px;
    min-height: 115px;
    padding: 0em 1em 1em 1em;
    color: #fff;
    font-family: 'Open Sans', sans-serif;
    margin-left: 4px;
    margin-bottom: 4px;
}

.metroblock h1, .metroblock h2, .metroblock .icon {
  font-weight: 300;
  margin: 0;
  padding: 0;
}
.metroblock h1, .metroblock .icon {
  font-size: 4em;
  text-align: center;
}
.metroblock .icon {
  margin-right: .2em;
}
.metroblock .icon i {
    font-size: 36px;
}
h2{font-size:16px;}
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
           <form action='' id="searchData" method="POST">
               
           <div class="row"> 
               <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText')!= '' ? $this->input->post('searchText'):'';?>" name="searchText"  placeholder="Search by Order Id, Customer Name, Email">
               <b>From</b> <input class="search-custom datetime" id="date_timepicker_start" type="text" value="" name="sdate" placeholder="yyyy-mm-dd" autocomplete="off">  <b>To</b> <input class="search-custom datetime" id="date_timepicker_end" type="text" value="" placeholder="dddd-mm-dd" name="edate" autocomplete="off">
                <select class="form-control selectSearch" id="orderStatus" name="orderStatus" onChange="formsubmit(this.form.id)">
                    <option value="" style="font-weight:bold;">Status</option>
                    <option value='1' <?php echo $this->input->post('orderStatus')=='1' ?'selected':''; ?> >Assigned</option>
                    <option value='0' <?php echo $this->input->post('orderStatus')=='0' ?'selected':''; ?> >Un-assigned</option>
                    <option value='2' <?php echo $this->input->post('orderStatus')=='2' ?'selected':''; ?> >In-Transit</option>
                    <option value='3' <?php echo $this->input->post('orderStatus')=='3' ?'selected':''; ?> >Hold</option>
                    <option value='4' <?php echo $this->input->post('orderStatus')=='4' ?'selected':''; ?> >Reached</option>
                    <option value='5' <?php echo $this->input->post('orderStatus')=='5' ?'selected':''; ?> >Returned</option>
                    <option value='6' <?php echo $this->input->post('orderStatus')=='6' ?'selected':''; ?> >Delivered</option>
                    <option value='7' <?php echo $this->input->post('orderStatus')=='7' ?'selected':''; ?> >Delayed</option>
                    
                </select>
                
                <select class="form-control selectSearch" id="driver" name="driver" onChange="formsubmit(this.form.id)">
                    <option value="" style="font-weight:bold;">Driver</option>
                     <?php $loc_array2 = []; ?>
                    <?php $drivers = array_unique($drivers);                     ?>
                    <?php foreach ($drivers as $list1) {    
                        $driver_postid = $this->input->post('driver') != '' ? (int) $this->input->post('driver') : '';
                        $driverValChk  = ($list1['did'] == $driver_postid) ? 'selected' : '';
                        echo '<option value="'.$list1['did'].'" '.$driverValChk.'>'.ucfirst($list1['driver_fname']." ".$list1['driver_lname']).' </option>'; 
                    } ?>
                </select>
                
                <select class="form-control selectSearch" id="location" name="location" onChange="formsubmit(this.form.id)">
                    <option value="" style="font-weight:bold;">Location</option>
                    <?php $loc_array2 = $loc_array3 = []; ?>
                    <?php foreach ($locations as $list2) { $loc_array2[] = $list2['city']; } $loc_array2 = array_unique($loc_array2);                     ?>
                    <?php foreach ($loc_array2 as $loc2) { 
                        $locationStr  = $this->input->post('location') != '' ? (string) $this->input->post('location') : '';
                        $locationChk1 = (strtolower($loc2) == strtolower($locationStr)) ? 'selected' : '';
                        echo '<option value="'.strtolower($loc2).'" '.$locationChk1.'>'.ucfirst($loc2).'</option>'; } ?>
                    
                    <!--    <option value="" style="font-weight:bold;">Choose State</option>-->
                    <?php //foreach ($locations as $list3) { $loc_array3[] = $list3['state']; } $loc_array3 = array_unique($loc_array3); ?>
                    <?php //foreach ($loc_array3 as $loc3) { 
                        //$locationStr  = $this->input->post('location') != '' ? (string) $this->input->post('location') : '';
                        //$locationChk2 = ($loc3 == $locationStr) ? 'selected' : '';
                        //echo '<option value="'.strtolower($loc3).'"  '.$locationChk2.'>'.ucfirst($loc3).'</option>'; } ?>
                </select>
                
                <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
                <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
           </div>
           </form>
          
        </div>
<!--        <div class="form-group pull-right">
            <button class="btn" type="button" onclick="PrintElem('#myData')" ><i class="fa fa-print" aria-hidden="true"></i></button>
        </div>-->
        
        <div class="row row_mrg" id="myData">
            <div class="col-md-12">
                <div class="portlet-body flip-scroll table-scrollable">
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover" >
                        <thead class="flip-content">
                            <tr>
                                <th width="50px"> S No.</th>
                                <th> Order Id </th>
                                <th class="numeric"> Data & Time </th>
                                <th class="numeric"> Customer </th>
                                <th class="numeric" style="min-width:140px;"> Location </th>
                                <th class="numeric"> Delivery Type </th>
                                <th class="numeric"> Delivery Date & Time </th>
                                <th class="numeric"> Status </th>
                                <th class="numeric"> First Order </th>
                                <th class="numeric"> Driver </th>
                                <th class="numeric"> Amount </th>
                                <th class="numeric"> Action </th>
                                <!--<th class="numeric"> Cab Referral Id </th>
                                <th class="numeric"> UBER/LYFT Referral code </th>
                                <th class="numeric"> Last Active Date </th> -->
                            </tr>
                        </thead>
                        <?php
                         $i = 0;
                         if (count($result) > 0) {
                            if ( isset($_GET['page']) )
                            {
                                if ($_GET['page'] == '') {
                                    $i = 0;
                                } else {
                                    $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                }
                            }
                            foreach ($result as $key => $list) {
                                $bt = new DateTime($list['created_at']);
                                $dt = new DateTime($list['created_at']);
                                
                                $a = $list['order_status'];
                                //0=>Unsigned,1=>Assigned,2=>in-transit/Start,3=>Hold,4=>Reached,5=>Return,6=>Delivered,7-Delayed
                                
                                $status =  ($a != 0  ? ($a != 1 ? ($a != 2 ? ($a != 3 ? ($a != 4 ? ($a != 5 ? ($a == 6 ? 'Delivered' : 'Delayed') : 'Returned') : 'Reached') : 'Hold') : 'In-transit') : 'Assigned') : 'Unasigned');
                                $orderType = $list['order_type'] == 1 ? 'Scheduled' : 'ASAP';
                                ?>
                                    <tr>
                                        <td> <?php echo $i + 1; ?> </td>
                                        <td class="numeric editable"><?php echo $list['oid']; ?> </td>
                                        <td class="numeric editable"><?php echo $bt->format('d-M-Y'); ?></td>
                                        <td class="numeric editable"><b><?php echo ucfirst($list['user_fname'])." ".ucfirst($list['user_lname'])."</b><br />".$list['user_email'];?></td>
                                        <td class="numeric editable"><?php echo ucfirst($list['address']).",<br>".ucfirst($list['city']).",".ucfirst($list['state']); ?> </td>
                                        <td class="numeric editable"><?php echo ucfirst($orderType);   ?></td>
                                        <td class="numeric editable"><?php echo $dt->format('d-M-Y');?></td>
                                        <td class="numeric editable"><?php echo $status;?></td>
                                        <td class="numeric editable text-center">
                                            <?php if ( isset($list['first_time']) && $list['first_time'] == true ): ?>
                                                <span class="fa fa-check text-success"></span>
                                            <?php else: ?>
                                                <span class="fa fa-times text-danger"></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="numeric editable"><b><a title="View this order details" id ="" href="order-detail/<?php echo $list['oid']; ?>"><small><?php echo ucfirst($list['driver_fname']." ".$list['driver_lname']);?></small></a></b></td>
                                        <td class="numeric editable"><?php echo $list['amount'];?></td>
                                        <!--
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
                                        -->
                                        <td class="action">
                                            <span class="no_wrap">
                                                <a title="View this order details" id ="" href="order-detail/<?php echo $list['oid']; ?>" class="btn btn-default btn-xs"> <i class="fa fa-eye" style="color:green;"></i> </a>
                                                <!--<a title="View this order details" class="pop-up-html" data-url="order-detail/<?php echo $list['oid']; ?>" id ="userDel" class="btn btn-default btn-xs"> <i class="fa fa-eye" style="color:red;"></i> </a>-->
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
                                    <td colspan="12" style="text-align: center"> No Record Found </td>
                                </tr>
                            </tbody>
<?php } ?>
                    </table>
                    <div class=" row_mrg paginate">
                        <div class=" row_mrg paginate">
                            <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                                <span  class="right show-more" ><a href="<?php echo base_url();?>orders" data-ci-pagination-page="2" rel="next">Back</a></span>
                            <?php }else{ ?>
                                <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?><a class= "btn" href="<?php echo base_url();?>orders?all=true" data-ci-pagination-page="2" rel="next">All</a></span>
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

<!-- Page Js -->
<script src="assets/admin/pages/scripts/admin_orders.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
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
    
    $('.pop-up-html').click(function(){
        hrefNew = $(this).attr('data-url');
        var a_href = $('#writeDeleteURL').attr('href', hrefNew);
//        e.preventDefault();
    });
});
</script>

