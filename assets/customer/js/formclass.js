$(document).ready(function () {
    $(".ajaxform").submit(function (event)
    {
    	if(pageckeditor)
    	{
    		CKupdate();
    	}
        var formId = $(this).attr('id');
        if (formId)
            var formClass = '#' + formId;
        else
            var formClass = ".ajaxform";
        var posturl = $(this).attr('action');
        
        $(this).ajaxSubmit({
            url: posturl,
            dataType: 'json',
            beforeSend: function () {
                $('.wait-div').show();
            },

            success: function (response) {
                
                $(formClass).find('#jGrowl .jGrowl-notification').removeClass('alert-success').removeClass('alert-danger');
                $('.wait-div').hide();
                $(formClass).find('#jGrowl').fadeIn(600);
                
                if (response.success)
                {
                    $(formClass).find('#jGrowl .jGrowl-notification').addClass('alert alert-success alert-dismissable').children('.ajax_message').html(response.success_message);
                    window.madeChangeInForm = false;
                } else
                {
                    $(formClass).find('#jGrowl .jGrowl-notification').addClass('alert alert-danger alert-dismissable').children('.ajax_message').html(response.error_message);
                }
                
                if (!response.forgot && response.url)
                {
                    setTimeout(function ()
                    {
                        window.location.href = response.url;
                    }, 1000)
                }
                else if (response.url)
                {
                    setTimeout(function ()
                    {
                        window.location.href = response.url;
                    }, 7000)
                }

                if (response.resetForm)
                    $(formClass).resetForm();

                if (response.scrollToElement)
                    scrollToElement(response.scrollToElement, 1000);

                if (response.scrollToThisForm)
                    scrollToElement(formClass, 1000);

                if (response.selfReload)
                    location.reload();

                if (response.ajaxtCallBackFunction)
                {
                    ajaxtCallBackFunction(response);
                }
                setTimeout(function ()
                {
                    $(formClass).find('#jGrowl').fadeOut(600);
                }, 7000);
            },
            error: function (response) {
                showConnectionError();
            }
        });

        return false;
    });
});

function CKupdate() {
    for (instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}

function scrollToElement(element, speed)
{
    $('html, body').animate({scrollTop: $(element).position().top - 70}, speed);
}
function showConnectionError()
{
    alert('server error');
}

