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
        <form class="form-horizontal" id="viewProduct" name="viewProduct" action="" OnLoad="LoadFileValue('viewProduct','item_pic', <?php echo $productinfo['itemsrc'] ? $productinfo['itemsrc'] : '' ; ?>)" style="min-height:495px;" role="form" enctype='multipart/form-data' method="post">                
            <h3 class="page-title ">Add Product </h3>
            <div class="portlet-body form">
                        <div class="form-body padLeftZero">                  
                            <div class="row padLeftZero">
                                <div class="col-md-2 padLeftZero">
                                    
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                            <input class="font12px" type="text" value="" id="styleInput" style="width:32%;height:35px;border:2px solid #ddb9fc;" readonly>
                                            <input type="hidden" id="itemcolor" name="itemcolor" value="<?php echo substr($productinfo['color_code'], strpos($productinfo['color_code'], "#") + 1); ?>" readonly>
                                            <button class="jscolor {valueElement:'itemcolor', styleElement:'styleInput'}" id="colorPicker">Pick color&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></button>
                                            <span id="itemcolor-error" class="help-block hide"></span>
<!--                                            <span id="itemSubType-error" class="help-block hide"></span>-->
                                        </div>
                                    </div>
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                            <input type="text" id="itemflavour" name="itemflavour" class="form-control font12px" placeholder="Flavour " value="<?php echo $productinfo['flavor'] ? $productinfo['flavor'] : ''; ?>">
                                            <span id="itemflavour-error" class="help-block hide"></span>
<!--                                            <span id="itemSubType-error" class="help-block hide"></span>-->
                                        </div>
                                    </div>
                                    <div class="box">
                                        <input type="file" name="item_pic" id="item_pic" class="inputfile inputfile-1 hidden" data-multiple-caption="{count} files selected" onChange="VehicleImageURL(this,this.value,'profileimage');" value=""  />
                                        <label for="item_pic" class="labelCustom" title="Choose Product image" style="margin-bottom:0px !important;"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 10px;">Choose a image&hellip;</span></label>
                                    </div>
                                    <!-- Trigger the Modal -->
<!--                                    <img id="myImg" src="https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png" alt="Trolltunga, Norway"  width="138px">-->
                                    <img id="profileimage" style="border: 1px solid cyan;" width="152px" src="<?php echo $productinfo['itemsrc'] ? $productinfo['itemsrc'] : 'https://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png'; ?> " alt="Profile Photo" />
                                    <input type="hidden" name="pic_exiting" id="pic_exiting" value="<?php echo $productinfo['itemsrc'] ? $productinfo['itemsrc'] : ''; ?>"  />
                                    <span id="item_pic-error" class="help-block hide"></span>
                                </div>
                                <!--/span-->
                                <div class="col-md-5">
                                    <!-- PRODUCT NAME  -->
                                    <div class="form-group">
                                        <div class="col-md-12 customCol">
                                            <input type="text" id="itemname" name="itemname" class="form-control" placeholder="Product name" value="<?php echo $productinfo['itemname'] ? $productinfo['itemname'] : ''; ?>">
                                            <span id="itemname-error" class="help-block hide"></span>
                                        </div>                                        
                                    </div>
                                    <!-- UNIT INDICA/SLAVE  -->
                                    <div class="form-group">
                                        <div class="col-md-6 customCol">
                                            <select class="form-control" id="itemunit" name="itemunit">
                                                <option selected style="font-weight:bold;" value="">Choose Unit Type</option>
                                                <option value="1" <?php echo $productinfo['itemunit'] == '1' ? 'selected' : ''; ?> >ounces</option>
                                                <option value="2" <?php echo $productinfo['itemunit'] == '2' ? 'selected' : ''; ?> >grams</option>
                                                <option value="3" <?php echo $productinfo['itemunit'] == '3' ? 'selected' : ''; ?> >ml</option>
                                                <option value="4" <?php echo $productinfo['itemunit'] == '4' ? 'selected' : ''; ?> >piece</option>
                                            </select>
                                            <span id="itemunit-error" class="help-block hide"></span>
                                        </div>
                                        <div class="col-md-6 customCol">
                                            <select class="form-control" id="itemfamily" name="itemfamily">
                                                <option selected style="font-weight:bold;"  value="">Choose product family</option>
                                                <?php
                                                    if (count($itemfamilies) > 0) {
                                                        foreach ($itemfamilies AS $family){
                                                            $selected = $family['familyid'] == $productinfo['itemunit'] ? 'selected' : '';
                                                            echo '<option value="'.$family['familyid'].'" '.$selected.' >'.$family['familyname'].'</option>';
                                                        }
                                                        
                                                    }
                                                ?>
                                            </select>
                                            <span id="itemfamily-error" class="help-block hide"></span>
                                        </div>
                                    </div>
                                    <!-- PRICE BOX -->
                                    <div class="form-group">
                                        <div class="col-md-6 customCol">
                                            <input type="text" id="ounce8price" name="ounce8price" class="form-control font12px" onkeypress="return isNumberKey(event)" placeholder="1/8 ounce price" value="<?php echo $productinfo['price_eigth'] ? $productinfo['price_eigth'] : '' ?>">
                                            <span id="ounce8price-error" class="help-block hide"></span>
                                        </div>
                                        <div class="col-md-6 customCol">
                                            <input type="text" id="anounceprice" name="anounceprice" class="form-control font12px" onkeypress="return isNumberKey(event)" placeholder="An ounce price" value="<?php echo $productinfo['price_one'] ? $productinfo['price_one'] : '' ?>">
                                            <span id="anounceprice-error" class="help-block hide"></span>
                                        </div>
                                    </div>
<!--                                    <div class="form-group">
                                      <div class="col-md-12 customCol">
                                          <input type="text" id="deducted_price" name="deducted_price" class="form-control font12px" onkeypress="return isNumberKey(event)" placeholder="deducted price" value="<?php echo $productinfo['deducted_price'] ? $productinfo['deducted_price'] : '' ?>">
                                            <span id="deducted_price-error" class="help-block hide"></span>
                                      </div>
                                    </div>-->
                                    <!-- EFFECTS RECOMMENDED_USAGES REVIEW  -->
                                    <div class="form-group">
                                      <div class="col-md-12 customCol">
                                          <textarea class="form-control font12px" id="itemrecommends" name="itemrecommends" placeholder="Recommended usages" ><?php echo $productinfo['recommended_uses'] ? $productinfo['recommended_uses'] : '' ?></textarea>
                                          <span id="itemrecommends-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12 customCol">
                                          <textarea class="form-control font12px" id="itemeffects" rows="2" name="itemeffects" placeholder="Effects"><?php echo $productinfo['effect'] ? $productinfo['effect'] : '' ?></textarea>
                                          <span id="itemeffects-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12 customCol">
                                          <textarea class="form-control font12px" id="itemreview" rows="2" name="itemreview" placeholder="Connoisseur's Review" ><?php echo $productinfo['itemdsc'] ? $productinfo['itemdsc'] : '' ?></textarea>
                                          <span id="itemreview-error" class="help-block hide"></span>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <!-- PICK COLOR  -->
                                    <div class="form-group">
                                        <div class="col-md-12" style="margin-bottom:0px;">
                                            <dl class="dropdown"> 
                                                <?php 
                                                    $item_categories_array  = array();
                                                    $item_categories_string = '';
                                                    if($itemcategories){
                                                        foreach ($itemcategories AS $catrow){
                                                            array_push($item_categories_array,  $catrow['category_id']);
                                                            $item_categories_string .= $catrow['category_id'].',';
                                                        }                                                                    
                                                    }
                                                ?>
                                                <dt>
                                                <a>
                                                  <span class="hida">Select Category & sub-category</span> <span class="pull-right"><i class="fa fa-caret-down"></i></span>
                                                  <input type="" id="categories" name="categories" value="<?php echo $item_categories_string ? $item_categories_string : ''; ?>" style="display:none;width:0px;height:1px;" /> 
                                                  <p class="multiSel" id="choosedItems"></p>  
                                                </a>
                                                    
                                                </dt>
                                                
                                                <dd>
                                                    <div class="mutliSelect">
                                                        
                                                        <ul>
                                                            <?php
                                                               
                                                                if (isset($categories) && count($categories) > 0) {
                                                                    foreach ($categories AS $category){
                                                                        $catid         = $category['catid']; $catname = $category['catname'];
                                                                        $select_catChk = in_array($catid, $item_categories_array) ? 'checked' : '';
                                                                        echo '<li class="cat"><input class="chkbox" type="checkbox" data-info="category_'.$catid.'" id="catid_'.$catid.'" name="categories[]" value="'.$catid.'" data-val="'.$catname.'" '.$select_catChk.' /> '.$catname.' </li>';
                                                                        if(isset($category['subcategories']) && count($category['subcategories']) > 0){
                                                                            foreach ($category['subcategories'] AS $subcategory){
                                                                                $subcatid         = $subcategory['subcatid']; $subcatname = $subcategory['subcatname'];
                                                                                $select_subcatChk = in_array($subcatid, $item_categories_array) ? 'checked' : '';
                                                                                echo '<li class="subcat"><input class="chkbox" type="checkbox" data-info="subcategory_'.$catid.'" id="subcatid_'.$subcatid.'" name="categories[]" value="'.$subcatid.'"  data-val="'.$subcatname.'" '.$select_subcatChk.' />'.$subcatname.'</li>';                                                                               
                                                                            }
                                                                        }
                                                                    }
                                                                }else{
                                                                    echo '<li>No category defined, Please create one.<button class="btn btn-sm btn-info" id="createCat" style="margin-top:10px" type="button">Create new category</button></li>';
                                                                }
                                                            ?>
                                                            <!--
                                                            <li class="cat"><input type="checkbox" data-info="category_44" id="catid_44" value="44" data-val="Cat 1" /> Cat 1 </li>

                                                                    <li class="subcat"><input type="checkbox" data-info="subcategory_44" id="subcatid_45" value="45"  data-val="Apple 1"  />Apple 1</li>
                                                                    <li class="subcat"><input type="checkbox" data-info="subcategory_44" id="subcatid_46" value="46"  data-val="Apple 2"  />Apple 2</li>
                                                                    <li class="subcat"><input type="checkbox" data-info="subcategory_44" id="subcatid_47" value="47"  data-val="Apple 3"  />Apple 3</li>
                                                                    <li class="subcat"><input type="checkbox" data-info="subcategory_44" id="subcatid_48" value="48"  data-val="Apple 4"  />Apple 4</li>



                                                            <li class="cat"><input type="checkbox" data-info="category_95" id="catid_95" value="95" data-val="Phone" /> Phone </li>
                                                                <li class="subcat"><input type="checkbox" data-info="subcategory_95" id="subcatid_96" value="96"  data-val="Apple"  />Apple</li>
                                                                <li class="subcat"><input type="checkbox" data-info="subcategory_95" id="subcatid_97" value="97"  data-val="Sony Ericson"  />Sony Ericson</li>
                                                                <li class="subcat"><input type="checkbox" data-info="subcategory_95" id="subcatid_98" value="98"  data-val="Nokia"  />Nokia</li>

                                                            <li class="cat"><input type="checkbox" data-info="category_11" id="catid_11" value="11" data-val="Game" /> Game </li>
                                                            -->
                                                        </ul>

                                                    </div>
                                                </dd>
                                            </dl>
                                            <span id="categories-error" class="help-block hide"></span>
                                        </div>
                                    </div>
                                    <!-- CHOOSE SPECIAL  -->
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                            <fieldset class="customFieldset">
                                                <legend style="font-size:13px;margin-bottom: 5px;"> Choose for Specials</legend>
                                                <div class="pad_8">
                                                <div class="form-group textAlignMiddle  checckbox_list">
                                                    <div class="col-md-4 customCol  ">
                                                        <label class="checkbox clearfix">
                                                            <input class="customChkBtn" type="checkbox" name="biweekly" id="biweekly" value="biweekly" <?php echo $productinfo['is_biweekly'] ? 'checked' : '' ?> /> 
                                                            <span id="biweekly-error" class="help-block hide"></span>
                                                            <span class="box_line"> </span>
                                                            <span class="checkbox_txt">Biweekly</span> 
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4 customCol ">
                                                        <label class="checkbox clearfix">
                                                        <input class="customChkBtn" type="checkbox" name="luxurious" id="luxurious" value="luxurious" <?php echo $productinfo['is_luxurious_item'] ? 'checked' : '' ?> />
                                                        <span id="luxurious-error" class="help-block hide"></span>
                                                         <span class="box_line"> </span>
                                                            <span class="checkbox_txt">Most Luxurious </span> 
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4 customCol ">
                                                         <label class="checkbox clearfix">
                                                        <input class="customChkBtn" type="checkbox" name="hot" id="hot" value="hot" <?php echo $productinfo['is_hot_item'] ? 'checked' : '' ?> />
                                                        <span id="hot-error" class="help-block hide"></span>
                                                        <span class="box_line"> </span>
                                                            <span class="checkbox_txt">Hot item</span> 
                                                        </label>
                                                    </div>
                                                </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <!-- TEST RESULTS -->
                                    <div class="form-group padLeftZero">
                                        <div class="col-md-12 padLeftZero">
                                            
                                            <fieldset class="customFieldset">
                                                <legend style="font-size:13px;margin-bottom: 5px;"> Test Results</legend>
                                                <div class="form-group">
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="thc" name="thc" class="form-control font12px" placeholder="THC %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['thc'] ? $productinfo['thc'] : '' ?>">
                                                        <span id="thc-error" class="help-block hide"></span>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="cbg" name="cbg" class="form-control font12px" placeholder="CBG %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['cbg'] ? $productinfo['cbg'] : '' ?>">
                                                        <span id="cbg-error" class="help-block hide"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="cbc" name="cbc" class="form-control font12px" placeholder="CBC %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['cbc'] ? $productinfo['cbc'] : '' ?>">
                                                        <span id="cbc-error" class="help-block hide"></span>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="cbn" name="cbn" class="form-control font12px" placeholder="CBN %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['cbn'] ? $productinfo['cbn'] : '' ?>">
                                                        <span id="cbn-error" class="help-block hide"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="cbd" name="cbd" class="form-control font12px" placeholder="CBD %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['cbd'] ? $productinfo['cbd'] : '' ?>">
                                                        <span id="cbd-error" class="help-block hide"></span>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <input type="text" id="thcv" name="thcv" class="form-control font12px" placeholder="THCV %" onkeypress="return isNumberKey(event)" value="<?php echo $productinfo['thcv'] ? $productinfo['thcv'] : '' ?>">
                                                        <span id="thcv-error" class="help-block hide"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <!-- WAREHOUSE INVENTORY -->
                                <div class="col-md-12 padLeftZero">
                                    <fieldset class="customFieldset">
                                        <legend style="font-size:13px;margin-bottom: 5px;"> Inventory </legend>
                                        <div class="portlet-body flip-scroll table-scrollable">
                                            <table class="table table-bordered table-striped table-condensed flip-content table-hover" >
                                                <thead class="flip-content">
                                                    <tr>
                                                        <th width="50px"> S No.</th>
                                                        <th style="width:140px;">Warehouse Name </th>
                                                        <th class="numeric" style="width:180px;"> Address </th>
                                                        <th class="numeric" style="width:65px;"> Inventory(Left)</th>
                                                        <th class="numeric" style="width:50px;"> Status </th>
                                                        <th class="numeric" style="width:60px;"> Last Updated </th>
                                                        <th class="numeric" style="width:190px;"> Action </th>
                                                    </tr>
                                                </thead>
                                                
                                                <?php
                                                    
                                                 if (count($warehouses) > 0) {
                                                  $i = 0;
                                                    foreach ($warehouses as $key => $list) {
                                                        $a      = $list['warehouse_status'];
                                                        $status = $a != '0' ? "Active" : 'Inactive';
                                                        $whT    = new DateTime($list['warehouse_created_at']);
                                                ?>      
                                                            <tr id="row_<?php echo $list['warehouse_id']; ?>">
                                                                <td> <?php echo $i + 1; ?> </td>
                                                                <td class="numeric editable" title="<?php echo "Created on ".$list['warehouse_created_at']; ?>"><b><?php echo ucfirst($list['warehouse_name']); ?></td>
                                                                <td class="numeric editable"><?php echo ucfirst($list['warehouse_address']); ?> </td>
                                                                <td class="numeric editable"><?php echo '0';   ?></td>
                                                                <td class="numeric editable"><?php echo $status; ?> </td>
                                                                <td class="numeric editable"><?php echo $whT->format('d-M-Y');?></td>
                                                                <td class="numeric">
                                                                    <span>
                                                                      <a class="btnsmall btn-primary" onclick="inOutQnty('whQnty_<?php echo $list['warehouse_id']; ?>', 1, 'plus')">
                                                                        <i class="fa fa-plus"></i>
                                                                      </a>
                                                                    </span>
                                                                    <input type="text" value="<?php echo $list['quantity'] ? $list['quantity'] : 0 ; ?>" class="form-control" style="display:inline-block;width:50px;margin-right:2px;" name="whQnty_<?php echo $list['warehouse_id'] ?>" id="whQnty_<?php echo $list['warehouse_id']; ?>" onkeypress="return isNumberKey(event)"  />
                                                                        <span>
                                                                          <a class="btnsmall btn-info" onclick="inOutQnty('whQnty_<?php echo $list['warehouse_id']; ?>', 1, 'minus')">
                                                                            <i class="fa fa-minus"></i>
                                                                          </a>
                                                                        </span>
                                                                </td>
                                                            </tr>                                
                                                <?php  $i++; }  } else { ?>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6" style="text-align: center"> No Record Found </td>
                                                        </tr>
                                                    </tbody>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <div class="form-group" style="margin-top:5px;padding-left:1px; ">
                                        
                                        <div class="col-md-6 ">
                                            <button type="submit" class="btn green" name="adddProductBtn"><i class="fa fa-check"></i> Save</button>
                                            <a type="button" href="<?php echo base_url(); ?>products" class="btn default "><i class="fa fa-remove"></i> Cancel</a> 
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            
                        </div>  
                
            <!------------------content end---------------------------------->
            </div>
            
        </form>
        

<!-- File Input Best Design Js -->
<script  src="https://code.jquery.com/jquery-3.1.1.min.js"  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="  crossorigin="anonymous"></script>
  
<script src="<?php echo base_url(); ?>assets/admin/filein/js/custom-file-input.js"></script>
<!-- Page Js -->
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/view-product.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/jscolor/jscolor.min.js"></script>

<script>
//-- Inventory ++/--
function inOutQnty(effetiveId, numVal, logic){
    if(logic == 'plus'){
        var preVal = parseInt($("#"+effetiveId).val());
        var newVal = preVal + numVal;
        $("#"+effetiveId).val(newVal);
    }
    if(logic == 'minus'){
        var preVal = parseInt($("#"+effetiveId).val());
        var newVal = preVal - numVal;
        if(newVal >= 0){
            $("#"+effetiveId).val(newVal);
        }else{
            alert('Quantity must be more than or equal to 0');
        }
        
    }
        
}
function rmMatchText(pText){
    var ret = "data-123".replace('data-','');
    console.log(ret);
}
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


$(".dropdown dt a").on('click', function() {
  $(".dropdown dd ul").show('fast');
});

$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$('.mutliSelect input[type="checkbox"]').on('click', function() {
    //var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').attr('dataval');
    //alert(title);
    var eleType = $(this).attr('data-info');
    var elArr   = eleType.split('_');
    var catid   = elArr[1];
    // Category show
    if(elArr[0] == 'category'){
        console.log("category - " + catid);
        var catChk = $('#catid_'+catid).is(':checked');
        
        title1 = $(this).attr('data-val') + ",";
        values = $(this).attr('value') + ",";
        if ($(this).is(':checked')) {
            console.log('x');
            var html = '<span title="' + title1 + '">' + title1 + '</span>';
            $('.multiSel').append(html);
            //$(".hida").hide();
        } else {
            console.log('z');
            $('span[title="' + title1 + '"]').remove();
            var ret = $(".hida");
            $('.dropdown dt a').append(ret);

            if($('#choosedItems > span').length == 0){
                $(".hida").show();
            }
        }  
        
        if(!catChk){
            console.log('y');
            $( '.mutliSelect input[data-info="category_'+catid+'"]' ).prop('checked', false);
            $( '.mutliSelect input[data-info="subcategory_'+catid+'"]' ).prop('checked', false);
            
            var titleArr= [];
            $('.mutliSelect input[data-info="subcategory_'+catid+'"]').each(function() {
                   ttexta = $(this).attr('data-val');
                   titleArr.push(ttexta);
                   //$('.mutliSelect span[title="' + tlsa + '"]').remove();
            });
            $.each( titleArr, function( key, value ) {
                
                 $('span[title="' + value + ',"]').remove();
                 $('span[title="' + value + '"]').remove();
            });
            
            if($('#choosedItems > span').length == 0){
                //$(".hida").show();
            }
        }
            
    }
    // Sub-Category
    if(elArr[0] == 'subcategory'){
        var catChk = $('#catid_'+catid).is(':checked');
        console.log('#catid_'+catid + " is " +catChk);
        if(!catChk){
            //var catid   = $(this).closest('.mutliSelect').find('#catid_'+catid).attr('value');
            //var catname = $(this).closest('.mutliSelect').find('#catid_'+catid).attr('data-val');
            alert($('#catid_'+catid).attr('data-val') + ' is not checked');
            $( '.mutliSelect input[data-info="category_'+catid+'"]' ).prop('checked', false);
            $( '.mutliSelect input[data-info="subcategory_'+catid+'"]' ).prop('checked', false);
            
            var titleArr1= [];
            $('.mutliSelect input[data-info="subcategory_'+catid+'"]').each(function() {
                   ttextaa = $(this).attr('data-val');
                   titleArr1.push(ttextaa);
                   //$('.mutliSelect span[title="' + tlsa + '"]').remove();
            });
            $.each( titleArr1, function( key, value ) {
                 $('span[title="' + value + ',"]').remove();
                 $('span[title="' + value + '"]').remove();
            });
            
        }else{
            //---Now Proceed its data
            title2 = $(this).attr('data-val') + ",";
            values = $(this).attr('value') + ",";
            if ($(this).is(':checked')) {
              var html = '<span title="' + title2 + '">' + title2 + '</span>';
              $('.multiSel').append(html);
              //$(".hida").hide();
            } else {
              $('span[title="' + title2 + '"]').remove();
              var ret = $(".hida");
              $('.dropdown dt a').append(ret);
              if($('#choosedItems > span').length == 0){
                  //$(".hida").show();
              }
            }
        }
            
    }
    
    if($("input[name='categories[]']").is(":checked")){
        $("#categories").val('true');
    }else{
        $("#categories").val('');
    }
    
  
});
});
</script>


