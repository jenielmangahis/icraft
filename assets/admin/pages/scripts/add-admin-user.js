var catCheckVal = false;
$( "#catname" ).on('keyup change paste',function(){
    var catnem = $("#catname").val();
    var urlpart = "check-category";
    datapart = {catname: catnem};
    if(catnem != ''){
        $.ajax({
            type: "POST",
            url: urlpart,
            data: datapart,
            dataType: "html",           
            complete: function (response) {
                if(response.status == 200){
                    var res = response.responseText;
                    if(res == 'true'){
                        catCheckVal = 'false';
                        $('#catcheck').attr('class','fa fa-close');
                    }else{
                        catCheckVal = 'true';
                        $('#catcheck').attr('class','fa fa-check-circle');
                    }
                }

            },
        });
    }else{
        $('#catcheck').attr('class','');
    }

});
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
    
    //-- Validate Group Check Box for Modules
    $(document).on("click",".groupchk",function() {//disable both popup      
       var checkboxs=document.getElementsByClassName("groupchk");
        var okay=false;
        for(var i=0;i< checkboxs.length;i++)
        {
            if(checkboxs[i].checked)
            {
                okay=true;
                break;
            }
        }
        if(okay){$('#selectedModules').val(true);}
        else{$('#selectedModules').val(''); }
    });
    
    //--- Validate Form Submission 
    $("#addUser").submit(function(event){ 
        var phone_regex = /^[0-9]{10,12}$/;
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var link_regex  = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        var error = [];
        var modules     = $('#selectedModules').val();
        var fname       = $("#fname").val();
        var lname       = $("#lname").val();
        var email       = $("#email").val();
        var contact     = $("#contact").val();
        
       //--- Message Pic Validation
        if(modules == ''){
            setFeedError('modules-error','required field');
            error['modules'] = true;
        }
        else{
            washFeedError('modules-error');
            error['modules'] = false;
        }
        
        //--- First Name Validation
        if(fname == '' || fname == undefined){
            setFeedError('fname-error','required field');
            error['fname'] = true;
        }
        else if(fname.length < 5){
            setFeedError('fname-error','can\'t be less than 5 chars');
            error['fname'] = true;
        }
        else if(fname.length > 25){
            setFeedError('fname-error','can\'t exceed 25 chars');
            error['fname'] = true;
        }
        else{
            washFeedError('fname-error');
            error['fname'] = false;
        }
        
        //--- Last NameValidation
        if(lname == '' || lname == undefined){
            setFeedError('lname-error','required field');
            error['lname'] = true;
        }
        else if(lname.length < 5){
            setFeedError('lname-error','can\'t be less than 5 chars');
            error['lname'] = true;
        }
        else if(lname.length > 25){
            setFeedError('lname-error','can\'t exceed 25 chars');
            error['lname'] = true;
        }
        else{
            washFeedError('lname-error');
            error['lname'] = false;
        }
        
        //--- Email Validation
        if(email == '' || email == undefined){
            setFeedError('email-error','required field');
            error['email'] = true;
        }
        else if(email.length < 5){
            setFeedError('email-error','can\'t be less than 5 chars');
            error['email'] = true;
        }
        else if(email.length > 128){
            setFeedError('email-error','can\'t exceed 128 chars');
            error['email'] = true;
        }
        else if(email_regex.test(email) == false){
            setFeedError('email-error','Please enter a valid email.');
            error['email'] = true;                    
        }
        else{
            washFeedError('email-error');
            error['email'] = false;
        }

        //--- Conatct Validation
        if(contact == '' || contact == undefined){
            setFeedError('contact-error','required field');
            error['contact'] = true;
        }
        else if(contact.length < 5){
            setFeedError('contact-error','can\'t be less than 5 chars');
            error['contact'] = true;
        }
        else if(contact.length > 12){
            setFeedError('contact-error','can\'t exceed 12 chars');
            error['contact'] = true;
        }
        else if(phone_regex.test(contact) == false){
            setFeedError('contact-error','Please enter a valid contact.');
            error['contact'] = true;                    
        }
        else{
            washFeedError('contact-error');
            error['contact'] = false;
        }

        
        
        if(error['fname'] == false && error['lname'] == false && error['email'] == false && error['contact'] == false && error['modules'] == false){
            return true;
        }else{
            return false;
        }


    });
        
        
    
