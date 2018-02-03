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
.form-group {
    margin-bottom: 8px;
}
label.error {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
  padding:1px 20px 1px 20px;
  font-weight: bold;
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
        <form class="form-horizontal" id="addCoupon" name="addCoupon" action="" style="min-height:495px;" role="form" method="post">                
            <h3 class="page-title ">Add Coupon </h3>              
                <div class="row padLeftZero">
                     
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="link">Coupon Name </label>
                            <input type="text" id="cname" name="cname" class="form-control" placeholder="Coupon name " minlength="5" maxlength="30" style="width:90%;display: inline-block;" value="" >
                            <span id="cname-error" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                            <label for="link">Minimum Order Price</label>
                            <input type="text" id="cminorder_price" name="cminorder_price" minlength="1" maxlength="8" class="form-control" placeholder="Minimum order price" style="width:90%;display: inline-block;" value="" onkeypress="return isNumberKey(event)">
                            <span id="cminorder_price" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 padLeftZero" >
                                <label for="link" style="width:90%;">Coupon Code </label>
                                <input type="text" id="code" name="code" class="form-control" minlength="5" maxlength="20" placeholder="Coupon code " style="width: 90%;display: inline-block;" value="" >
                            </div>  
                            <div class="col-md-6 padLeftZero" >
                                <label for="link" style="width:90%;">validity (No. of month)</label>
                                <input type="text" id="validity" name="validity" class="form-control" placeholder="e.g: 3" style="width: 85%;display: inline-block;" value="" onkeypress="return isNumberKey(event)">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="link">Coupon price</label>
                            <input type="text" id="points" name="points" class="form-control" placeholder="Coupon price" style="width:90%;display: inline-block;" value="" onkeypress="return isNumberKey(event)" >
                            <span id="price-error" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 padLeftZero" >
                                <label for="link" style="width:90%;">Discount Amount/Percentage</label>
                                <input type="text" id="discount" name="discount" minlength="1" maxlength="8" class="form-control" placeholder="Discount amount/percentage" style="width: 90%;" value="" onkeypress="return isNumberKey(event)">
                            </div>  
                            <div class="col-md-6 padLeftZero" >
                                <label for="link" style="width:90%;">Discount Type</label>
                                <select id="distype" name="distype" placeholder="" class="form-control" style="width:85%;" >
                                    <option value="1">Amount </option>
                                    <option value="2">Percentage</option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="link">Applicable product category</label>
                            <select id="categoryid" name="categoryid" placeholder="" class="form-control" style="width:90%;display: inline-block;" >
                                <option value="">Select any category</option>
                                
                                <?php if(count($categories) > 0): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['catid']; ?>" ><?php echo $category['catname']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span id="validity" class="help-block hide"></span>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn green" name="adddCouponBtn"><i class="fa fa-check"></i> Send</button>
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


