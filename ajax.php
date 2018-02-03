<html>
    <head>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var baseurl = "<?php echo $_SERVER['HTTP_HOST'];?>/learn_ent/";
                $.ajax
                ({
                    type: "POST",
                    url: 'checkCompleteStatus',
                    data: {userId: '2'},
                    success: function (res)
                    {
                        if(res){
                           
                        }else{
                            console.log('no');
                        }
                    }
                });


            });
        </script>
    </head>
</html>
