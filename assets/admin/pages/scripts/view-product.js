//--On Body Load Set Image File Value
function chkAtLstOneInGroupChkBx() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function () {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  // Do something with atLeastOneIsChecked
}


function DriverImageURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function VehicleImageURL(input,val,imgTagId) {
    if(validate_uploadfile_format(val,'image') == 'true'){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+imgTagId)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }else{
        $('#'+imgTagId).attr('src', 'http://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png');
    }        
}

//-- Created By N.K.
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) == false ? false : true;
    }
    
    //--- Validate input file extension
    function validate_uploadfile_format(fileName,filterType)
    {
         
        var allowed_extensions1  = new Array("jpeg","jpg","png","gif");
        var allowed_extensions2  = new Array("pdf","doc","docs");
        var allowed_extensions12 = new Array("jpeg","jpg","png","gif","pdf","doc","docx");
        
        var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

        if(filterType == 'image'){
            for(var i = 0; i <= allowed_extensions1.length; i++)
            {
                if(allowed_extensions1[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        if(filterType == 'docs'){
            for(var i = 0; i <= allowed_extensions2.length; i++)
            {
                if(allowed_extensions2[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        if(filterType == 'imgdocs'){
            for(var i = 0; i <= allowed_extensions12.length; i++)
            {
                if(allowed_extensions12[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        
        
        return 'false';
    }
  

    
    //-- Created By N.K.
    function setFeedError(ele, dpart) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.removeClass("hide");
            element.html(dpart);
        }else{
            element.html(dpart);
        }
    }

    //-- Created By N.K.
    function washFeedError(ele) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.html("");
        }else{
            element.addClass("hide");
            element.html("");
        }
    }
    
    
    //--- Validate Form Submission 
    $("#viewProduct").submit(function(event){ 
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var error = [];

        //-- Personal Info 
        var categories    = $("#categories").val();
        var itemname = $("#itemname").val();
        var itemunit = $("#itemunit").val();
        var itemfamily = $("#itemfamily").val();
        var ounce8price = $("#ounce8price").val();
        var anounceprice = $("#anounceprice").val();
        var itemrecommends = $("#itemrecommends").val();
        var itemeffects = $("#itemeffects").val();
        var itemreview = $("#itemreview").val();
        var itemcolor = $("#itemcolor").val();
        var itemflavour = $("#itemflavour").val();

        //-------------------------------------------
        
        
        //--- Category Type Validation
        if(categories == '' || categories == undefined){
            setFeedError('categories-error','required field');
            error['categories'] = true;
        }
        else{
            washFeedError('categories-error');
            error['categories'] = false;
        }
        
        //--- Item Name Validation
        if(itemname == '' || itemname == undefined){
            setFeedError('itemname-error','required field');
            error['itemname'] = true;
        }
        else if(itemname.length < 5){
            setFeedError('itemname-error','can\'t be less than 5 chars');
            error['itemname'] = true;
        }
        else if(itemname.length >= 50){
            setFeedError('itemname-error','can\'t exceed 50 chars');
            error['itemname'] = true;
        }
        else{
            washFeedError('itemname-error');
            error['itemname'] = false;
        }
        
        //--- Item Unit Validation
        if(itemunit == '' || itemunit == undefined){
            setFeedError('itemunit-error','required field');
            error['itemunit'] = true;
        }
        else{
            washFeedError('itemunit-error');
            error['itemunit'] = false;
        }
        
        //--- Item Family Validation
        if(itemfamily == '' || itemfamily == undefined){
            setFeedError('itemfamily-error','required field');
            error['itemfamily'] = true;
        }
        else{
            washFeedError('itemfamily-error');
            error['itemfamily'] = false;
        }
        
        //--- Ounces eight price Validation
        if(ounce8price == '' || ounce8price == undefined){
            setFeedError('ounce8price-error','required field');
            error['ounce8price'] = true;
        }
        else{
            washFeedError('ounce8price-error');
            error['ounce8price'] = false;
        }
        
        //--- an ounce price  Validation
        if(anounceprice == '' || anounceprice == undefined){
            setFeedError('anounceprice-error','required field');
            error['anounceprice'] = true;
        }
        else{
            washFeedError('anounceprice-error');
            error['anounceprice'] = false;
        } 
        
        //--- Item Recommended Validation
        if(itemrecommends == '' || itemrecommends == undefined){
            setFeedError('itemrecommends-error','required field');
            error['itemrecommends'] = true;
        }
        else if(itemrecommends.length < 5){
            setFeedError('itemrecommends-error','can\'t be less than 5 chars');
            error['itemrecommends'] = true;
        }
        else if(itemrecommends.length >= 128){
            setFeedError('itemrecommends-error','can\'t exceed 128 chars');
            error['itemrecommends'] = true;
        }
        else{
            washFeedError('itemrecommends-error');
            error['itemrecommends'] = false;
        }
        
        //--- Item Effects Validation  
        if(itemeffects == '' || itemeffects == undefined){
            setFeedError('itemeffects-error','required field');
            error['itemeffects'] = true;
        }
        else if(itemeffects.length < 5){
            setFeedError('itemeffects-error','can\'t be less than 5 chars');
            error['itemeffects'] = true;
        }
        else if(itemeffects.length >= 128){
            setFeedError('itemeffects-error','can\'t exceed 128 chars');
            error['itemeffects'] = true;
        }
        else{
            washFeedError('itemeffects-error');
            error['itemeffects'] = false;
        }
        
        //--- Item Review Validation  
        if(itemreview == '' || itemreview == undefined){
            setFeedError('itemreview-error','required field');
            error['itemreview'] = true;
        }
        else if(itemreview.length < 5){
            setFeedError('itemreview-error','can\'t be less than 5 chars');
            error['itemreview'] = true;
        }
        else if(itemreview.length >= 128){
            setFeedError('itemreview-error','can\'t exceed 128 chars');
            error['itemreview'] = true;
        }
        else{
            washFeedError('itemreview-error');
            error['itemreview'] = false;
        }
        
        // itemcolor itemflavour biweekly luxurious hot thc cbg cbc cbn cbd thcv
        
        //--- Item Color Validation
        if(itemcolor == '' || itemcolor == undefined){
            setFeedError('itemcolor-error','required field');
            error['itemcolor'] = true;
        }
        else if(itemcolor == 'FFFFFF'){
            setFeedError('itemcolor-error','Please pick any color');
            error['itemcolor'] = true;
        }
        else{
            washFeedError('itemcolor-error');
            error['itemcolor'] = false;
        } 
        
        //--- Item Flavour Validation  
        if(itemflavour == '' || itemflavour == undefined){
            setFeedError('itemflavour-error','required field');
            error['itemflavour'] = true;
        }
        else if(itemflavour.length < 5){
            setFeedError('itemflavour-error','can\'t be less than 5 chars');
            error['itemflavour'] = true;
        }
        else if(itemflavour.length >= 128){
            setFeedError('itemflavour-error','can\'t exceed 128 chars');
            error['itemflavour'] = true;
        }
        else{
            washFeedError('itemflavour-error');
            error['itemflavour'] = false;
        }

        if(error['categories'] == false && error['itemname'] == false 
                && error['itemunit'] == false && error['itemfamily'] == false && error['ounce8price'] == false && error['anounceprice'] == false 
                && error['itemrecommends'] == false && error['itemeffects'] == false && error['itemreview'] == false 
                && error['itemcolor'] == false && error['itemflavour'] == false){
            return true;
        }else{
            return false;
        }


    });
        
        
    
