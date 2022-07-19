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

        //Admin Product Status Update Script
        $('.updateProductStatus').click(function(e){
            e.preventDefault();
            let status = $(this).text();
            let product_id = $(this).attr('product_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-products-status',
                data: {status:status, product_id:product_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#product-'+product_id).html('<a class="updateProductStatus" href="javascript:void(0)">Active</a>');
                    }else if(resp['status'] == 0){
                        $('#product-'+product_id).html('<a class="updateProductStatus" href="javascript:void(0)">Inactive</a>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Product Attribute Status Update Script
        $('.updateAttributeStatus').click(function(e){
            e.preventDefault();
            let status = $(this).text();
            let attribute_id = $(this).attr('attribute_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-attributes-status',
                data: {status:status, attribute_id:attribute_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#attribute-'+attribute_id).html('<a class="updateAttributeStatus" href="javascript:void(0)">Active</a>');
                    }else if(resp['status'] == 0){
                        $('#attribute-'+attribute_id).html('<a class="updateAttributeStatus" href="javascript:void(0)">Inactive</a>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Product Images Status Update Script
        $('.updateImagesStatus').click(function(e){
            e.preventDefault();
            let status = $(this).text();
            let image_id = $(this).attr('image_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-images-status',
                data: {status:status, image_id:image_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#image-'+image_id).html('<a class="updateImagesStatus" href="javascript:void(0)">Active</a>');
                    }else if(resp['status'] == 0){
                        $('#image-'+image_id).html('<a class="updateImagesStatus" href="javascript:void(0)">Inactive</a>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Brand Status Update Script
        $('.updateBrandsStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let brand_id = $(this).attr('brand_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-brand-status',
                data: {status:status, brand_id:brand_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#brand-'+brand_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#brand-'+brand_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Brand Status Update Script
        $('.updateBannersStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let banner_id = $(this).attr('banner_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-banner-status',
                data: {status:status, banner_id:banner_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#banner-'+banner_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#banner-'+banner_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
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


        // Confirm Data is Deleted
        $('.confirmDelete').click(function(){
            let record = $(this).attr('record');
            let recordId = $(this).attr('recordId');


            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/delete-${record}`+'/'+recordId;
                }
            })
        });

        //<!-- Start -->
        // Product Attributes Add/Remove script
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" name="size[]" value="" placeholder="Size" style="width: 120px; margin-right: 3px; margin-top: 3px;" /><input type="text" name="sku[]" value="" placeholder="SKU" style="width: 120px; margin-right: 3px; margin-top: 3px;" /><input type="number" name="price[]" value="" placeholder="Price" style="width: 120px; margin-right: 3px; margin-top: 3px;" /><input type="number" name="stock[]" value="" placeholder="Stock" style="width: 120px; margin-right: 3px; margin-top: 3px;" /><a href="javascript:void(0);" title="Remove" class="remove_button btn btn-rounded btn-danger btn-sm"><i class="fas fa-minus"></i></a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
        //<!-- End -->

    });
})(jQuery);
