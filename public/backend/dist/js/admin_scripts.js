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

        //Admin Section Status Update Script
        $('.updateSectionStatus').click(function(e){
            e.preventDefault();
            let status = $(this).text();
            let section_id = $(this).attr('section_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-section-status',
                data: {status:status, section_id:section_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#section-'+section_id).html('<a class="updateSectionStatus" href="javascript:void(0)">Active</a>');
                    }else if(resp['status'] == 0){
                        $('#section-'+section_id).html('<a class="updateSectionStatus" href="javascript:void(0)">Inactive</a>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Category Status Update Script
        $('.updateCategoryStatus').click(function(e){
            e.preventDefault();
            let status = $(this).text();
            let category_id = $(this).attr('category_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-categories-status',
                data: {status:status, category_id:category_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#category-'+category_id).html('<a class="updateCategoryStatus" href="javascript:void(0)">Active</a>');
                    }else if(resp['status'] == 0){
                        $('#category-'+category_id).html('<a class="updateCategoryStatus" href="javascript:void(0)">Inactive</a>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        // Append Category Level
        $('#section_id').change(function(){
            let section_id = $(this).val();
            $.ajax({
                type: 'post',
                url: '/admin/append-category-level',
                data: {section_id:section_id},
                success:function(resp){
                    $('#appendCategoryLevel').html(resp);
                },error:function(){
                    alert("Error");
                }
            });
        });

    });
})(jQuery);
