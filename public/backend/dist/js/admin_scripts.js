(function($){
    $(document).ready(function () {
        //Admin Current password check
        $('#current_pwd').keyup(function(){
            let current_pwd = $(this).val();
            $.ajax({
                type: 'POST',
                url : '/admin/check-current-pwd',
                data : { current_pwd:current_pwd },
                success : function(data){
                    if(data == 'false'){
                        $('#chkCurrentPwd').html("<font color=red>Current Password is incurrecnt</font>");
                    }else if(data == 'true'){
                        $('#chkCurrentPwd').html("<font color=green>Current Password is currecnt</font>");
                    }
                },
                error : function(){
                    alert("Error")
                }
            });
        });
    });
})(jQuery);