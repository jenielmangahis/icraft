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
                    <div class="col-md-5 col-xs-12 padLeftZero">
                        <div class="form-group padLeftZero">
                            <label for="catname">Category Name  </label>
                            <input type="text" id="catname" name="catname" class="form-control" placeholder="New Category name" style="width:90%;display: inline-block;" value="" >
                            <span><i id="catcheck" class=""></i></span>
                            <span id="catname-error" class="help-block hide"></span>
                        </div>
                        <div class="form-group padLeftZero">
                            <button type="submit" class="btn green" name="addCategoryBtn"><i class="fa fa-check"></i> Add Category </button>
                            <a type="button" href="categories" class="btn default "><i class="fa fa-remove"></i> Cancel</a> 
                        </div>
                    </div>  
                    <div class="col-md-2 padLeftZero">
                        
                    </div>
                    <div class="col-md-5 padLeftZero">
                        
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
<script src="assets/admin/pages/scripts/categories.js"></script>
<script src="assets/admin/jscolor/jscolor.min.js"></script>

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


