(function($){
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //sorting/filtering products by php form submit
        // $('#sort').change(function(){
        //     this.form.submit();
        // });

        // sorting / filtering products by ajax request
        $('#sort').change(function(){
            const sort = $(this).val();
            const url = $('#url').val();
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });


        $('.brand').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.fabric').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.sleeve').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.pattern').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.fit').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.occasion').on('click', function(){
            let brand = getFilter('brand');
            let fabric = getFilter('fabric');
            let sleeve = getFilter('sleeve');
            let pattern = getFilter('pattern');
            let fit = getFilter('fit');
            let occasion = getFilter('occasion');
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {brand:brand,fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        // call selected item function
        function getFilter(class_name){
            let filter = [];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            // console.log(filter);
            return filter;
        }


        // price change by size
        $('.getProductPrice').change(function(){
            let size = $(this).val();
            let product_id = $(this).attr('product_id');
            $.ajax({
                url: '/get-product-price',
                type: 'post',
                data: {size:size,product_id:product_id},
                success: function(data){

                    $('.mainCurrencyPrice').hide();

                    if(data['discount']>0){
                        $('.setProductPrice').html('<del>Rs. ' + data['product_price']+"</del> Rs. "+data['final_price']+data['currency']);
                    }else {
                        $('.setProductPrice').html('Rs. ' + data['product_price']+data['currency']);
                    }

                },
                error: function(){
                    alert('Error');
                }
            });
        });

        // Update Cart Items
        $(document).on('click', '.btnItemUpdate', function(){
            if($(this).hasClass('qtyMinus')){
                // If qtyMinus button get click by User
                let quantity = $(this).prev().val();
                if(quantity <= 1){
                    alert('Item quantity must be 1 or greater!')
                    return false;
                }else {
                    new_qty = parseInt(quantity) - 1;
                }
            }
            if($(this).hasClass('qtyPlus')){
                // If qtyPlus button get click by User
                let quantity = $(this).prev().prev().val();
                new_qty = parseInt(quantity) + 1;
            }
            let cartid = $(this).data('cartid');
            $.ajax({
                data: { "cartid":cartid, 'qty':new_qty },
                url: '/update-cart-item-qty',
                type: 'post',
                success:function(data){
                    if(data.status == false){
                        alert(data.message);
                    }
                    $('.totalCartItems').html(data.totalCartItems);
                    $('#appendCartItems').html(data.view);
                },error:function(){
                    alert('Error');
                }
            });
        });

        // Delete Cart Items
        $(document).on('click', '.btnItemDelete', function(){
            let cartid = $(this).data('cartid');
            let result = confirm('Want to delete this cart item')

            if(result){
                $.ajax({
                    data: { "cartid":cartid },
                    url: '/delete-cart-item-qty',
                    type: 'post',
                    success:function(data){
                        $('#appendCartItems').html(data.view);
                        $('.totalCartItems').html(data.totalCartItems);
                    },error:function(){
                        alert('Error');
                    }
                });
            }

        });

        // validate register form on keyup and submit
		$("#registerForm").validate({
			rules: {
				name: "required",
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 15,
                    digits: true
				},
                email: {
					required: true,
					email: true,
                    remote: 'check-email'
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				name: "Please enter your name",
				mobile: {
					required: "Please enter a mobile",
					minlength: "Your mobile must consist of 11 digits",
					maxlength: "Your mobile must consist of 15 digits",
					digits: "Please enter your valid mobile",
				},
				email: {
					required: "Please enter a email",
					email: "Please enter your valid email",
                    remote: "Email already exists"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});

        // validate login form on keyup and submit
		$("#loginForm").validate({
			rules: {
                email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				email: {
					required: "Please enter a email",
					email: "Please enter your valid email",
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});

        // validate account form on keyup and submit
		$("#accountForm").validate({
			rules: {
				name: "required",
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 15,
                    digits: true
				}
			},
			messages: {
				name: "Please enter your name",
				mobile: {
					required: "Please enter a mobile",
					minlength: "Your mobile must consist of 11 digits",
					maxlength: "Your mobile must consist of 15 digits",
					digits: "Please enter your valid mobile",
				}
			}
		});


        // validate user password update form on keyup and submit
		$("#updatePasswordForm").validate({
			rules: {
				current_password: {
					required: true,
					minlength: 6,
					maxlength: 20,
				},
                new_password: {
					required: true,
					minlength: 6,
					maxlength: 20,
				},
                confirm_password: {
					required: true,
					minlength: 6,
					maxlength: 20,
                    equalTo: "#new_password"
				},
			}
		});

        // check current user password
        $("#current_password").keyup(function(){
            let current_password = $(this).val();
            $.ajax({
                type: "post",
                url: '/check-user-password',
                data: {current_password:current_password},
                success:function(data){
                    if(data == 'false'){
                        $('#ckPass').html("<font color='red'>Current password is Incorrect</font>")
                    }else if(data == 'true'){
                        $('#ckPass').html("<font color='green'>Current password is Correct</font>")
                    }
                },error:function(){
                    alert("Error");
                }
            });
        });

        // Cupon apply into product
        $('#applyCoupon').submit(function(){
            let user = $(this).attr('user');
            if(user == 1){
                // noting do
            }else {
                alert('Please login to apply coupon!');
                return false;
            }
            let code = $('#code').val();
            $.ajax({
                url: '/apply-coupon',
                type: 'post',
                data: {code:code},
                success:function(data){

                    if(data.message != ""){
                        alert(data.message);
                    }

                    $('#appendCartItems').html(data.view);
                    $('.totalCartItems').html(data.totalCartItems);

                    if(data.coupon_amount >= 0){
                        $('.coupon_amount').text("Rs. "+data.coupon_amount);
                    }else {
                        $('.coupon_amount').text("Rs. 0");
                    }

                    if(data.grand_total >= 0){
                        $('.grand_total').text("Rs. "+data.grand_total);
                    }
                },error:function(){
                    alert("Error");
                }
            });
        });

        // Delete Delivery Address Confirm script
        $('#delete_delivery_address').click(function(){
            let result = confirm('Are you sure you want to delete!');
            if(!result){
                return false;
            }
        });

        // Shipping Charges Applied
        $('input[name=address_id]').bind('change', function(){
            let shipping_charges = $(this).attr('shipping_charges');
            let total_price = $(this).attr('total_price');
            let coupon_amount = $(this).attr('coupon_amount');
            let codPincodeCount = $(this).attr('codPincodeCount');
            let prepaidPincodeCount = $(this).attr('prepaidPincodeCount');

            if(codPincodeCount > 0){
                // COD Method Show
                $('.isCod').show();
            }else {
                // COD Method Hide
                $('.isCod').hide();
            }

            if(prepaidPincodeCount > 0){
                // COD Method Show
                $('.isPrepaid').show();
            }else {
                // COD Method Hide
                $('.isPrepaid').hide();
            }

            if(coupon_amount == ""){
                coupon_amount = 0;
            }
            let grand_total = parseInt(total_price) - parseInt(coupon_amount) + parseInt(shipping_charges);
            $('.coupon_amount').text('Rs. '+coupon_amount);
            $('.shipping_charges').text('Rs. '+shipping_charges);
            $('.grand_total').text('Rs. '+grand_total);
        });

        // Check delivery pincode valid or not
        $('#checkPincode').click(function(){
            let pincode = $('#pincode').val();
            if(pincode == ""){
                alert('Please insert pincode');
            }else {
                $.ajax({
                    type: 'post',
                    data: {pincode:pincode},
                    url: '/check-pincode',
                    success: function(data){
                        alert(data);
                    },error: function(){
                        alert('Error');
                    }
                });
            }
        });

        // Check user is not login
        $('.userLogin').click(function(){
            alert('Login your account then add to wishlist.');
        });

        // Product add and remnove from whichlist
        $('.updateWishlist').click(function(){
            let product_id = $(this).data('productid');
            $.ajax({
                type: 'post',
                url: '/update-wishlist',
                data: { product_id:product_id },
                success: function(data){
                    if(data.action == 'add'){
                        $('button[data-productid='+product_id+']').html('Wishlist <i class="icon-heart"></i>');
                        alert('Product added to wishlist');
                    }
                    if(data.action == 'remove'){
                        $('button[data-productid='+product_id+']').html('Wishlist <i class="icon-heart-empty"></i>');
                        alert('Product remove from wishlist');
                    }
                },error: function(){
                    alert('Error');
                }

            });
        });

        // Remove wishlist item
        $(document).on('click', '.wishlistItemDelete', function(){
            let wishlistId = $(this).data('wishlistid');
            $.ajax({
                type: 'post',
                url: '/delete-wishlist-item',
                data: { wishlistId:wishlistId },
                success: function(data){
                    $('.totalWishlistItems').html(data.totalWishlistItems);
                    $("#appendWishlistItems").html(data.view);
                },error: function(){
                    alert('Error');
                }
            });
        });

        // Cancel Order
        $(document).on('click', '.btnCancelOrder', function(e){
            let result = confirm('Are you sure! you want to delete this order.');
            if(!result){
                e.preventDefault();
            }
        });


    });
})(jQuery);
