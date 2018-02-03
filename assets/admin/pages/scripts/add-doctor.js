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
    if(validate_uploadfile_format(val,'image') == true){
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
                    return true; // valid file extension
                }
            }
        }
        if(filterType == 'docs'){
            for(var i = 0; i <= allowed_extensions2.length; i++)
            {
                if(allowed_extensions2[i]==file_extension)
                {
                    return true; // valid file extension
                }
            }
        }
        
        if(filterType == 'imgdocs'){
            for(var i = 0; i <= allowed_extensions12.length; i++)
            {
                if(allowed_extensions12[i]==file_extension)
                {
                    return true; // valid file extension
                }
            }
        }
        
        
        
        return false;
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
    $("#addDoctor").submit(function(event){ 
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var error = [];
        var profile_pic = $("#profile_pic").val();
        //-- Personal Info 
        var dctrFname   = $("#dctrFname").val();
        var dctrLname   = $("#dctrLname").val();
        var dctrEmail   = $("#dctrEmail").val();
        var dctrPhone   = $("#dctrPhone").val();
        //-- Document Info 
        var document1   = $("#document1").val();
        var file_1      = $("#file_1").val();
        var document2   = $("#document2").val();
        var file_2      = $("#file_2").val();
        var document3   = $("#document3").val();
        var file_3      = $("#file_3").val();
        
        
        //--- Profile Pic Validation
        if(profile_pic == ''){
            setFeedError('profile_pic-error','required field');
            error['profile_pic'] = true;
        }
        else if(!validate_uploadfile_format(profile_pic,'image')){
            setFeedError('profile_pic-error','File not supprted');
            error['profile_pic'] = true;                    
        }
        else{
            washFeedError('profile_pic-error');
            error['profile_pic'] = false;
        }
        
        
        
        //-------------------------------------------
        //--- First Name Validation
        if(dctrFname == '' || dctrFname == undefined){
            setFeedError('dctrFname-error','required field');
            error['dctrFname'] = true;
        }
        else if(dctrFname.length < 5){
            setFeedError('dctrFname-error','can\'t be less than 5 chars');
            error['dctrFname'] = true;
        }
        else if(dctrFname.length > 25){
            setFeedError('dctrFname-error','can\'t exceed 25 chars');
            error['dctrFname'] = true;
        }
        else{
            washFeedError('dctrFname-error');
            error['dctrFname'] = false;
        }
        
        //--- Last Name Validation
        if(dctrLname == '' || dctrLname == undefined){
            setFeedError('dctrLname-error','required field');
            error['dctrLname'] = true;
        }
        else if(dctrLname.length < 5){
            setFeedError('dctrLname-error','can\'t be less than 5 chars');
            error['dctrLname'] = true;
        }
        else if(dctrLname.length > 25){
            setFeedError('dctrLname-error','can\'t exceed 25 chars');
            error['dctrLname'] = true;
        }
        else{
            washFeedError('dctrLname-error');
            error['dctrLname'] = false;
        }
        
        //--- Email Validation
        if(dctrEmail == ''){
            setFeedError('dctrEmail-error','required field');
            error['dctrEmail'] = true;
        }
        else if(!isEmail(dctrEmail)){
            setFeedError('dctrEmail-error','invalid email.');
            error['dctrEmail'] = true;                    
        }
        else if(dctrEmail.length > 50){
            setFeedError('dctrEmail-error','can\'t exceed 50 chars');
            error['dctrEmail'] = true;
        }
        else{
            washFeedError('dctrEmail-error');
            error['dctrEmail'] = false;
        }
        
        //--- Contact / Phone Validation
        if(dctrPhone == '' || dctrPhone == undefined){
            setFeedError('dctrPhone-error','required field');
            error['dctrPhone'] = true;
        }
        else if(dctrPhone.length < 10){
            setFeedError('dctrPhone-error','can\'t be less than 10 chars');
            error['dctrPhone'] = true;
        }
        else if(dctrPhone.length > 15){
            setFeedError('dctrPhone-error','can\'t exceed 15 chars');
            error['dctrPhone'] = true;
        }
        else{
            washFeedError('dctrPhone-error');
            error['dctrPhone'] = false;
        }
        
        
        
        //----------------------------------------------------------
        //--- Document Name 1 - Validation 
        if(document1 == '' || document1 == undefined){
            setFeedError('document1Error','required field');
            error['document1'] = true;
        }
        else if(document1.length < 5){
            setFeedError('document1Error','can\'t be less than 5 chars');
            error['document1'] = true;
        }
        else if(document1.length > 50){
            setFeedError('document1Error','can\'t exceed 50 chars');
            error['document1'] = true;
        }
        else{
            washFeedError('document1Error');
            error['document1'] = false;
        }
        
        //--- Document file 1 Validation
        if(file_1 == '' || file_1 == undefined){
            setFeedError('file_1-error','required field');
            error['file_1'] = true;
        }
        else if(!validate_uploadfile_format(file_1,'imgdocs')){
            setFeedError('file_1-error','File not supprted');
            error['file_1'] = true;                    
        }
        else{
            washFeedError('file_1-error');
            error['file_1'] = false;
        }
        
        
        //--- Document Name 2 - Validation 
        if(document2 == '' || document2 == undefined){
            setFeedError('document2Error','required field');
            error['document2'] = true;
        }
        else if(document2.length < 5){
            setFeedError('document2Error','can\'t be less than 5 chars');
            error['document2'] = true;
        }
        else if(document2.length > 50){
            setFeedError('document2Error','can\'t exceed 50 chars');
            error['document2'] = true;
        }
        else{
            washFeedError('document2Error');
            error['document2'] = false;
        }
        
        //--- Document file 2 Validation
        if(file_2 == '' || file_2 == undefined){
            setFeedError('file_2-error','required field');
            error['file_2'] = true;
        }
        else if(!validate_uploadfile_format(file_2,'imgdocs')){
            setFeedError('file_2-error','File not supprted');
            error['file_2'] = true;                    
        }
        else{
            washFeedError('file_2-error');
            error['file_2'] = false;
        }
        
        
        //--- Document Name 3 - Validation 
        if(document3 == '' || document3 == undefined){
            setFeedError('document3Error','required field');
            error['document3'] = true;
        }
        else if(document3.length < 5){
            setFeedError('document3Error','can\'t be less than 5 chars');
            error['document3'] = true;
        }
        else if(document3.length > 50){
            setFeedError('document3Error','can\'t exceed 50 chars');
            error['document3'] = true;
        }
        else{
            washFeedError('document3Error');
            error['document3'] = false;
        }
        
        //--- Document file 3 Validation
        if(file_3 == '' || file_3 == undefined){
            setFeedError('file_3-error','required field');
            error['file_3'] = true;
        }
        else if(!validate_uploadfile_format(file_3,'imgdocs')){
            setFeedError('file_3-error','File not supprted');
            error['file_3'] = true;                    
        }
        else{
            washFeedError('file_3-error');
            error['file_3'] = false;
        }
        
        

        if(error['profile_pic'] == false && error['dctrFname'] == false && error['dctrLname'] == false && error['dctrEmail'] == false && error['dctrPhone'] == false && error['document1'] == false && error['file_1'] == false && error['document2'] == false && error['file_2'] == false && error['document3'] == false && error['file_3'] == false){
            return true;
        }else{
            return false;
        }


    });
        
        
    
