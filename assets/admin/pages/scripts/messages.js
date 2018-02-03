var catCheckVal = false;
$( "#catname" ).keyup(function(){
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
    
    
    //--- Validate Form Submission 
    $("#addCategory").submit(function(event){ 
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var link_regex  = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        var error = [];
        var message_pic = $("#message_pic").val();
        var message     = $("#message").val();
        var link        = $("#link").val();
        
       //--- Message Pic Validation
        if(message_pic == ''){
            setFeedError('message_pic-error','required field');
            error['message_pic'] = true;
        }
        else if(!validate_uploadfile_format(message_pic,'image')){
            setFeedError('message_pic-error','File not supprted');
            error['message_pic'] = true;                    
        }
        else{
            washFeedError('message_pic-error');
            error['message_pic'] = false;
        }
        
        //--- Message Name Validation
        if(message == '' || message == undefined){
            setFeedError('message-error','required field');
            error['message'] = true;
        }
        else if(message.length < 5){
            setFeedError('message-error','can\'t be less than 5 chars');
            error['message'] = true;
        }
        else if(message.length > 255){
            setFeedError('message-error','can\'t exceed 255 chars');
            error['message'] = true;
        }
        else{
            washFeedError('message-error');
            error['message'] = false;
        }
        
        //--- Link Name Validation
        if(link == '' || link == undefined){
            setFeedError('link-error','required field');
            error['link'] = true;
        }
        else if(link.length < 5){
            setFeedError('link-error','can\'t be less than 5 chars');
            error['link'] = true;
        }
        else if(link.length > 255){
            setFeedError('link-error','can\'t exceed 255 chars');
            error['link'] = true;
        }
        else if(link_regex.test(link) == false){
            setFeedError('link-error','Please enter a valid link.');
            error['email'] = true;                    
        }
        else{
            washFeedError('link-error');
            error['link'] = false;
        }

        
        
        if(error['message'] == false && error['link'] == false && error['message_pic'] == false){
            return true;
        }else{
            return false;
        }


    });
        
        
    
