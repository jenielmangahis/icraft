<!-- File Upload Design Css Files -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/filein/css/component.css" />
<style>
    input[type=color] {
        width: 54px;
        padding: 0px;
        height: 34px;
    }
    .inlineBlock {
            border: 1px solid #bdb3b3;
    width: 99px;
    display: inline-block !important;
    padding:7px 6px;
    }
    #colorPicker {
            border: 1px solid #bdb3b3;
    width: 65%;
    display: inline-block !important;
    padding:9px 6px;
    }
    .customAch {
        color:#825555;
        cursor: pointer;        
    }
    .font12px{
        font-size: 13px;
    }
    .customChkBtn{
        height: 18px;
        padding:5px;
        argin: 8px 7px 0;
    }
    .textAlignMiddle{
        vertical-align:middle;
    }
    .form-control{
        padding:6px 4px;
        font-size:13px !important;
    }
    .customFieldset{
        padding:0.35em 0.625em 0.60em;
    }
    .btnsmall{
        display: inline-block;
        border: 1px solid grey;
        max-width: 50px;
        padding: 8px;
        margin: 0px !important;
    }
    .btnbg1{
        background: #a16060;
    }
    .btnbg2{
        background: red;
    }
    
    
    
.dropdown {
  width:100%;
  margin: 0px;
  padding: 0px;
}

.dropdown a {
  color: #fff;
}

.dropdown dd,
.dropdown dt {
  margin: 0px;
  padding: 0px;
}

.dropdown ul {
  margin: -1px 0 0 0;
}

.dropdown dd {
  position: relative;
}

.dropdown a,
.dropdown a:visited {
  color: #fff;
  text-decoration: none;
  outline: none;
  font-size: 12px;
}

.dropdown dt a {
  background-color: #4F6877;
  display: block;
  padding: 4px 10px 5px 6px;
  min-height: 15px;
  line-height: 18px;
  overflow: hidden;
  border: 0;
  
}

.dropdown dt a span,
.multiSel span {
  cursor: pointer;
  display: inline-block;
  padding: 0 3px 2px 0;
}

.dropdown dd ul {
  background-color: #4F6877;
  border: 0;
  color: #fff;
  display: none;
  left: 0px;
  padding: 2px 15px 2px 5px;
  position: absolute;
  z-index:111;
  top: 2px;
  width:100%;
  list-style: none;
  height: 200px;
  overflow: auto;
}

.dropdown span.value {
  display: none;
}

.dropdown dd ul li a {
  padding: 5px;
  display: block;
}

.dropdown dd ul li a:hover {
  background-color: #fff;
}

.subcat{
    margin-left: 15px;
}
.cat{
    background: #4b4040;
    font-size: 14px;
    font-weight: bold;
    padding: 3px;
    margin-bottom: 3px;
}
.cathr{
    padding: 0px;
    display: block;
    border-bottom: 2px solid #dbd0d0;
    margin-top: -15px;
    width: 50%;
    margin-left: 10px;
}
#choosedItems{
    display:none;
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
        <form class="form-horizontal" id="addCategory" name="addCategory" action="" style="min-height:495px;" role="form" enctype='multipart/form-data' method="post">                
            <h3 class="page-title ">Add Category </h3>              
                <div class="row padLeftZero">
                    <div class="col-md-3 col-xs-12 padLeftZero">
                        <div class="box">
                            <input type="file" name="message_pic" id="message_pic" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" onChange="VehicleImageURL(this,this.value,'profileimage');" value=""  />
                            <label for="message_pic" class="labelCustom" title="Choose Product image" style="margin-bottom:0px !important;"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 10px;">Choose a image&hellip;</span></label>
                        </div>
                        <!-- Trigger the Modal -->
<!--                                    <img id="myImg" src="https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png" alt="Trolltunga, Norway"  width="138px">-->
                        <img id="profileimage" style="border: 1px solid cyan;width: 100%;" width="152px" src="https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg" alt="Profile Photo" />
                        <span id="message_pic-error" class="help-block hide"></span>
                    </div>  
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="link">Message Link </label>
                            <input type="text" id="link" name="link" class="form-control" placeholder="Message link(max-255 chars)" style="width:90%;display: inline-block;" value="" >
                            <span id="link-error" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                            <label for="message">Write Message  </label>
                            <textarea class="form-control font12px" id="message" rows="5" name="message" style="width:90%;" placeholder="Write message(max-255 chars)"></textarea>
                            <span id="message-error" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn green" name="adddMessageBtn"><i class="fa fa-check"></i> Send</button>
                            <a type="button" href="messages" class="btn default "><i class="fa fa-remove"></i> Cancel</a> 
                        </div>
                        
                    </div>
                    <div class="col-md-2 padLeftZero">
                        
                    </div>
                </div> 
            <!------------------content end---------------------------------->            
        </form>
    </div><!-- Page Content -->
</div><!-- Page Wrapper Close -->

<!-- File Input Best Design Js -->
<script  src="https://code.jquery.com/jquery-3.1.1.min.js"  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="  crossorigin="anonymous"></script>
  
<script src="<?php echo base_url(); ?>assets/admin/filein/js/custom-file-input.js"></script>
<!-- Page Js -->
<script src="assets/admin/pages/scripts/messages.js"></script>

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


