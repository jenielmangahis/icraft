<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/component.css" />

<style type="text/css">
    
/*---------Form Spaecial-------  */
 
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
.paginate{padding-left: 10px;}


input.datetime{
    display: inline-block;
    width: 160px;
    padding: 10px 0 15px 10px;
    border-radius : 0px !important  ;
}
.pad9topBtm { 
    padding-top: 9px !important;
    padding-bottom: 9px !important;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <?php echo validation_errors(); ?>

        <?php if ($this->session->userdata('SuccessMsg') != "") { ?>
            <div class="success alert-info toBeHidden custom-success" role="alert">
                <?php
                echo $this->session->userdata('SuccessMsg');
                $this->session->unset_userdata('SuccessMsg');
                ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('errorMsg') != "") {
            ?>
            <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                <?php
                echo $this->session->userdata('errorMsg');
                $this->session->unset_userdata('errorMsg');
                ?>
            </div>
        <?php } ?>
        <!------------------content start ------------------------------>
        <!-- BEGIN FORM-->
        <form class="form-horizontal" id="updateDoctor" name="addDoctor" action="" style="min-height:300px;" role="form" enctype='multipart/form-data' method="post">    
            <div class="portlet-body form">
                        <div class="form-body">                  
                            <div class="row">
                                <div class="col-md-2">
                                    <h3 class="form-section" style="    margin-bottom: 50px;"></h3>
                                    <div class="box">
                                        <input type="file" name="profile_pic" id="profile_pic" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" onChange="VehicleImageURL(this,this.value,'profileimage');" />
                                        <label for="profile_pic" class="labelCustom" title="Choose another profile imange"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 10px;">Choose a image&hellip;</span></label>
                                    </div>
                                    <!-- Trigger the Modal -->
                                    <img id="profileimage"  width="138px" src="<?php echo $doctorinfo['doctor_pic'] ? $doctorinfo['doctor_pic'] : 'https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png'; ?> ?>" alt="Profile Photo" />
                                    <span id="profile_pic-error" class="help-block hide"></span>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <h3 class="form-section text text-primary">Personal details</h3>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" id="dctrFname" name="dctrFname" class="form-control" placeholder="First name" value="<?php echo $doctorinfo['doctor_fname'] ? $doctorinfo['doctor_fname'] : '' ; ?>">
                                            <span id="dctrFname-error" class="help-block hide"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" id="dctrLname" name="dctrLname" placeholder="Last name" value="<?php echo $doctorinfo['doctor_lname'] ? $doctorinfo['doctor_lname'] : '' ; ?>">
                                          <span id="dctrLname-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          Appointments details<input type="text" class="form-control" id="dctrEmail" name="dctrEmail" placeholder="Email id " value="<?php echo $doctorinfo['doctor_email'] ? $doctorinfo['doctor_email'] : '' ; ?>">
                                          <span id="dctrEmail-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <?php //print_r($doctorinfo);die; ?>
                                          <input type="hidden" value="<?php echo $doctorinfo['id'] ? $doctorinfo['id'] : '' ;?>" name="doctorid" />
                                          <input type="text" class="form-control" id="dctrPhone" name="dctrPhone" placeholder="Contact Number" onkeypress="return isNumberKey(event)" maxlength="15"  value="<?php echo $doctorinfo['doctor_phone'] ? $doctorinfo['doctor_phone'] : '' ; ?>">
                                          <span id="dctrPhone-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h3 class="form-section text text-primary">Documents details</h3>
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-4 padLeftZero" style="padding:0px !important;">    
                                           <input type="text" class="form-control" name="document1" id="document1" placeholder="Document Name" value="<?php echo $doctorinfo['doc1_name'] ? $doctorinfo['doc1_name'] : '' ; ?>">
                                           <span id="document1Error" class="help-block hide"></span>    
                                           </div>

                                          <div class="col-md-2" style="padding:0px !important;">
                                            <a href="<?php echo $doctorinfo['doc1_url'] ? $doctorinfo['doc1_url'] : '' ; ?>" name="" id="" class="btn btn-primary" style="margin:0px;" target="blank"  > View </a>
                                          </div>
                                          <div class="col-md-6">
                                           <div class="box">
                                                <input type="file" name="file_1" id="file_1" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_1" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose another&hellip;</span></label>
                                                
                                            </div>
                                            <span id="file_3-error" class="help-block hide"></span>    
                                          </div>
                                        </div>
                                    </div>

                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-4 padLeftZero" style="padding:0px !important;">    
                                           <input type="text" class="form-control" name="document2" id="document2" placeholder="Document Name" value="<?php echo $doctorinfo['doc2_name'] ? $doctorinfo['doc2_name'] : '' ; ?>">
                                           <span id="document2Error" class="help-block hide"></span>    
                                           </div>

                                            <div class="col-md-2" style="padding:0px !important;">
                                            <a href="<?php echo $doctorinfo['doc2_url'] ? $doctorinfo['doc2_url'] : '' ; ?>" name="" id="" class="btn btn-primary" style="margin:0px;" target="blank"  > View </a>
                                           </div>
                                           <div class="col-md-6">
                                           <div class="box">
                                                <input type="file" name="file_2" id="file_2" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_2" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose another&hellip;</span></label>
                                                
                                            </div>
                                            <span id="file_3-error" class="help-block hide"></span>    
                                          </div>
                                        </div>
                                    </div>

                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-4 padLeftZero" style="padding:0px !important;">    
                                            <input type="text" class="form-control" name="document3" id="document3" placeholder="Document Name"  value="<?php echo $doctorinfo['doc3_name'] ? $doctorinfo['doc3_name'] : '' ; ?>">
                                            <span id="document3Error" class="help-block hide"></span>    
                                           </div>

                                           <div class="col-md-2" style="padding:0px !important;">
                                               <a href="<?php echo $doctorinfo['doc3_url'] ? $doctorinfo['doc3_url'] : '' ; ?>" name="" id="" class="btn btn-primary" style="margin:0px;" target="blank"  > View </a>
                                           </div>
                                           <div class="col-md-6">
                                           <div class="box">
                                                <input type="file" name="file_3" id="file_3" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_3" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose another&hellip;</span></label>
                                                
                                            </div>
                                            <span id="file_3-error" class="help-block hide"></span>    
                                          </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>      
            <!------------------content end---------------------------------->
            </div>
            <div class="row">
                <div class="col-md-6">
                        <button type="submit" class="btn btn-warning" name="adddoctorbtn"><i class="fa fa-check"></i> Update</button>
                </div>
            </div>    
        </form>
        <!------------------content end---------------------------------->
        
        <hr style="border:1px solid #d0d0d0; margin: 10px 0;"/>
        <div class="row"> 
            <?php
                $date= $searchDate;
                $day_before = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                $day_after  = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h3 class="form-section text text-primary" style="display:inline-block;    line-height: 0.1;">Appointments details</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span>Search By Date : </span>
                <button title="Prev date" type="button" class="btn red" style="padding:5px 14px !important;"  id="sdate1" name="sdate1" value="<?php echo $day_before; ?>" style="padding: 5px 14px;" onclick="formSearchByDate(this.value);"> <i class="fa fa-angle-left" ></i></button>
                <input class="form-control search-custom datetime" id="manufactur_date" type="text" value="<?php echo $searchDate; ?>" name="sdate2" placeholder="" autocomplete="off" onChange="formSearchByDate(this.value);" />
                <button title="Next date" type="button" style="padding:5px 14px !important;" id="sdate3" name="sdate3"  class="btn red" value="<?php echo $day_after; ?>"  onclick="formSearchByDate(this.value);" > <i class="fa fa-angle-right"></i></button>
            </div>
        </div>
        <form class="form-horizontal" id="addDoctor" name="addDoctor" action="" style="min-height:495px;" role="form" enctype='multipart/form-data' method="post">    
                <div class="row">
                
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="font-size:10px;padding-right:0px;">
                        <div class="portlet-body flip-scroll table-scrollable" >
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover" style="font-size:10px;<?php echo (count($result) == 0 ? 'min-height:200px;' : ''); ?>" >
                                <thead class="flip-content">
                                    <tr>
                                        <th width="50px"> S No.</th>
                                        <th  width="180px"> Patient Name</th>
                                        <th class="numeric" width="160px"> Appointment Date </th>
                                        <th class="numeric" width="95px"> Status </th>
                                        <th class="numeric"> Action </th>
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
                                        
                                        $ct = new DateTime($list['created_at']);
                                        $a = $list['status'];
                                        $status =  $a != '0' ? ($a != '1' ? ($a != '2' ? "Canceled" : "Rescheduled") : "Confirmed") : 'Pending';
                                        $address = '';
                                        if(isset($list['address']) && $list['address'] != ''){
                                            $address .= ucfirst($list['address']);
                                            if(isset($list['city'])  && $list['city'] != ''){
                                                $address .=',<br>';
                                                $address .= ucfirst($list['city']);
                                                if(isset($list['state'])  && $list['state'] != ''){
                                                    $address .=',<br>';
                                                    $address .= ucfirst($list['state']);
                                                }
                                            }   
                                        }
                                ?>
                                            <tr>
                                                <td> <?php echo $i + 1; ?> </td>
<!--                                                <td class="numeric editable"><b><?php echo $list['first_name']; ?></td>-->
                                                <td class="numeric editable" title="<?php echo $list['email']; ?>" ><b><?php echo ucfirst($list['first_name'])." ".ucfirst($list['last_name'])."</b>"; ?></td>
                                                <td class="numeric editable"><?php echo $ct->format('d-M-Y')." ";echo $ct->format('H:i A')  ?></td>
                                                <td class="numeric editable"><b><?php echo $status; ?></b></td>
                                                <td class="action">
                                                    <span class="no_wrap">
<!--                                                        <a title="View this order details" id ="viewDoctor" href="doctor_detail/<?php echo $list['id']; ?>" class="btn btn-default btn-xs">  view details</a>-->
                                                        <a class="btn btn-default btn-xs appointmentInfo" data-href="<?php echo base_url() ?>appointment-userinfo"  data-val="<?php echo $list['recordid']; ?>"> view details </a>
                                                        <?php if(isset($list['is_medical_prescription']) && $list['is_medical_prescription'] != '0'){ ?>
<!--                                                            <a title="View this order details" id ="viewDoctor" href="doctor_detail/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> view prescription</a>-->
                                                            <a class="btn btn-default btn-xs prescriptionInfo" data-href="<?php echo base_url() ?>prescription-userinfo"  data-val="<?php echo $list['recordid']; ?>"> view prescription </a>
                                                        <?php } ?>
                                                            
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
                            <div class="row_mrg paginate" style="margin-top:10px !important;">
                                <div class="row_mrg paginate">
                                    <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                                        <span  class="right show-more" ><a href="<?php echo base_url();?>doctor-details<?php echo "/".$this->uri->segment('2') ?>" data-ci-pagination-page="2" rel="next">Back</a></span>
                                    <?php }else{ ?>
                                        <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?>
                                            <?php if(count($result) > 0){ ?>
                                                <a class= "btn" href="?all=true&date=<?php echo $date; ?>" data-ci-pagination-page="2" rel="next">All</a>
                                            <?php } ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="font-size:10px;padding-left:0px;padding-right:0px;">
                        <div class="portlet-body flip-scroll table-scrollable" >
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover detained" style="padding-left:0px;padding-right:0px;" >
                                
                                <thead class="flip-content">
                                    <tr>
                                        <th colspan="2"> Total Appointments </th>   
                                    </tr>
                                </thead>
                                <tbody style="font-size:11px;border-bottom: 1px solid #e8d1d1;box-shadow: 3px -2px 17px 0px;">
                                    <tr>
                                        <td clas="pad9topBtm"> <strong>Appointments taken</strong></td>
                                        <td class="numeric pad9topBtm"><?php echo intval($revenue['totalcounts']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pad9topBtm"> <strong>Appointments Pending</strong></td>
                                        <td class="numericpad9topBtm"><?php echo intval($revenue['pending']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pad9topBtm"> <strong>Appointments Approved</strong></td>
                                        <td class="numericpad9topBtm"><?php echo intval($revenue['confirmed']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pad9topBtm"> <strong>Appointments Canceled</strong></td>
                                        <td class="numeric pad9topBtm"><?php echo intval($revenue['canceled']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pad9topBtm"> <strong>Appointments Rescheduled</strong></td>
                                        <td class="numeric pad9topBtm"><?php echo intval($revenue['rescheduled']); ?></td> 
                                    </tr>
                                    <tr>
                                        <td class="pad9topBtm"> <strong>Prescription Issued</strong></td>
                                        <td class="numeric pad9topBtm"><?php echo intval($revenue['prescription_issues']); ?></td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="pad9topBtm"><strong> *Revenues</strong></td>
                                        <td class="numeric pad9topBtm"> <strong><?php echo '$'.  intval($revenue['confirmed'])*29; ?></strong></td>
                                    </tr>   
                                </tfoot>
                            </table>
                        </div>


<!--                    <div class="col-md-6">
                            <button type="submit" class="btn green" name="adddoctorbtn"><i class="fa fa-check"></i> Save</button>
                            <a type="button" href="doctors" class="btn default"><i class="fa fa-remove"></i> Cancel</a> 
                    </div>-->
                </div>   
            
            </div>
             
        </form>
        
    </div>
</div>

<!-- Model for Block Health -->
<div class="modal fade in" id="appointmentUserInfoModal" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content" id="appointData">
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Model for Block Health -->
<div class="modal fade in" id="prescriptionUserInfoModal" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog" style="">
        <div class="modal-content" id="prescriptionData">
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- File Input Best Design Js -->
<script src="<?php echo base_url(); ?>assets/admin/filein/js/custom-file-input.js"></script>
<!-- Page Js -->
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/view-doctor.js"></script>
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
    
    jQuery('#manufactur_date').datetimepicker({
        format:'Y-m-d',
        mask :'',
        timepicker:false,
    });


    jQuery('#from_time').datetimepicker({
        format:'H:i',
        mask :'',
        datepicker:false,
    });

    jQuery('#to_time').datetimepicker({
        format:'H:i',
        mask :'',
        datepicker:false,
    });
    
    
    //-- On Search Date Change 
    
});
</script>



