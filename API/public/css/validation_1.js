$(document).ready(function(){
    $("#form_wrap").validate({
        rules: {
            password: 
            {
                required: true,
                minlength: 6
            },
            confirm_password: 
            {
                required: true,
                equalTo: "#password"
            }
        },
        // Specify validation error messages
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                equalTo: "Confirm password must be same as password"
            },
        },

    });
});