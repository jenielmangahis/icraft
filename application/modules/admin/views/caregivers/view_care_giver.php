<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/component.css" />

<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Add Doctor</h3>
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
        <form class="form-horizontal" id="addDoctor" name="addDoctor" action="" style="min-height:495px;" role="form" enctype='multipart/form-data' method="post">    
            <div class="portlet-body form">
                        <div class="form-body">                  
                            <div class="row">
                                <div class="col-md-2">
                                    <h3 class="form-section" style="    margin-bottom: 50px;"></h3>
                                    <div class="box">
                                        <input type="file" name="profile_pic" id="profile_pic" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" onChange="VehicleImageURL(this,this.value,'profileimage');" value=""  />
                                        <label for="profile_pic" class="labelCustom" title="Choose another profile imange"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 10px;">Choose a image&hellip;</span></label>
                                    </div>
                                    <!-- Trigger the Modal -->
<!--                                    <img id="myImg" src="https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png" alt="Trolltunga, Norway"  width="138px">-->
                                    <img id="profileimage"  width="138px" src="https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png" alt="Profile Photo" />
                                    <span id="profile_pic-error" class="help-block hide"></span>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <h3 class="form-section text text-primary">Personal details</h3>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" id="dctrFname" name="dctrFname" class="form-control" placeholder="First name" value="<?php if(isset($_POST['dctrFname'])) echo $_POST['dctrFname']; ?>">
                                            <span id="dctrFname-error" class="help-block hide"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" id="dctrLname" name="dctrLname" placeholder="Last name" value="<?php if(isset($_POST['dctrLname']))echo $_POST['dctrLname']; ?>">
                                          <span id="dctrLname-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" id="dctrEmail" name="dctrEmail" placeholder="Email id " value="<?php if(isset($_POST['dctrEmail'])) echo $_POST['dctrEmail']; ?>">
                                          <span id="dctrEmail-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" id="dctrPhone" name="dctrPhone" placeholder="Contact Number" onkeypress="return isNumberKey(event)" maxlength="15"  value="<?php if(isset($_POST['dctrPhone'])) echo $_POST['dctrPhone']; ?>">
                                          <span id="dctrPhone-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h3 class="form-section text text-primary">Documents details</h3>
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-6 padLeftZero">    
                                           <input type="text" class="form-control" name="document1" id="document1" placeholder="Document Name" value="<?php if(isset($_POST['document1'])) echo $_POST['document1']; ?>">
                                           <span id="document1Error" class="help-block hide"></span>    
                                           </div>

                                          <div class="col-md-6">
                                           <div class="box">
                                                <input type="file" name="file_1" id="file_1" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_1" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                            </div>
                                           <span id="file_1-error" class="help-block hide"></span> 
                                          </div>
                                        </div>
                                    </div>

                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-6 padLeftZero">    
                                           <input type="text" class="form-control" name="document2" id="document2" placeholder="Document Name" value="<?php if(isset($_POST['document2'])) echo $_POST['document2']; ?>">
                                           <span id="document2Error" class="help-block hide"></span>    
                                           </div>

                                          <div class="col-md-6">
                                            <div class="box">
                                                <input type="file" name="file_2" id="file_2" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_2" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>    
                                            </div>
                                            <span id="file_2-error" class="help-block hide"></span>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                           <div class="col-md-6 padLeftZero">    
                                            <input type="text" class="form-control" name="document3" id="document3" placeholder="Document Name"  value="<?php if(isset($_POST['document3'])) echo $_POST['document3']; ?>">
                                            <span id="document3Error" class="help-block hide"></span>    
                                           </div>

                                          <div class="col-md-6">
                                           <div class="box">
                                                <input type="file" name="file_3" id="file_3" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" />
                                                <label for="file_3" class="labelCustom docFileColor" style="background: rgb(142, 139, 107);"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                                
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
                        <button type="submit" class="btn green" name="adddoctorbtn"><i class="fa fa-check"></i> Save</button>
                        <a type="button" href="doctors" class="btn default"><i class="fa fa-remove"></i> Cancel</a> 
                </div>
            </div>    
        </form>
        

<!-- File Input Best Design Js -->
<script src="<?php echo base_url(); ?>assets/admin/filein/js/custom-file-input.js"></script>
<!-- Page Js -->
<script src="assets/admin/pages/scripts/add-doctor.js"></script>

<script>
     jQuery(document).ready(function () {
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
        
        
        
        });
        

</script>


