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

        //Admin Banner Status Update Script
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

        //Admin Coupon Status Update Script
        $('.updateCouponsStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let coupon_id = $(this).attr('coupon_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-coupon-status',
                data: {status:status, coupon_id:coupon_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#coupon-'+coupon_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#coupon-'+coupon_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Shipping Charges Status Update Script
        $('.updateShippingStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let shipping_id = $(this).attr('shipping_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-shipping-status',
                data: {status:status, shipping_id:shipping_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#shipping-'+shipping_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#shipping-'+shipping_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
                    }

                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Users Status Update Script
        $('.updateUsersStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let user_id = $(this).attr('user_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-user-status',
                data: {status:status, user_id:user_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#user-'+user_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#user-'+user_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
                    }
                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin CMS Page Status Update Script
        $('.updateCmsPageStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let page_id = $(this).attr('page_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-cms-page-status',
                data: {status:status, page_id:page_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#page-'+page_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#page-'+page_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
                    }
                },
                error:function(){
                    alert('Error');
                }
            });
        });

        //Admin Admins/Subadmins Status Update Script
        $('.updateAdminsSubAdminsStatus').click(function(e){
            e.preventDefault();
            let status = $(this).children('i').attr('status');
            let admin_id = $(this).attr('admin_id');
            $.ajax({
                type: 'post',
                url: '/admin/update-admins-subadmins-status',
                data: {status:status, admin_id:admin_id},
                success:function(resp){
                    if(resp['status'] == 1){
                        $('#admin-'+admin_id).html('<i class="fas fa-toggle-on" status="Active"></i>');
                    }else if(resp['status'] == 0){
                        $('#admin-'+admin_id).html('<i class="fas fa-toggle-off" status="Inactive"></i>');
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

        //<!-- Start Input Multiple Input Field -->
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
        //<!-- End Input Multiple Input Field -->

        // Show/Hine Manual Coupon Code
        $('#automatic_option').click(function(){
            $('#coupon_manual_code').hide();
        });

        $('#manual_option').click(function(){
            $('#coupon_manual_code').show();
        });

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        // Show Courier Name and Tracking Number in case of shipped order status
        $('#courier_name').hide();
        $('#tracking_number').hide();

        $('#order_status').click(function(){
            if(this.value == 'Shipped'){
                $('#courier_name').show();
                $('#tracking_number').show();
            }else {
                $('#courier_name').hide();
                $('#tracking_number').hide();
            }
        });

        


    });
})(jQuery);
