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
            const fabric = getFilter("fabric");
            $.ajax({
                url:url,
                method:'post',
                data: {fabric:fabric,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.fabric').on('click', function(){
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
                data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.sleeve').on('click', function(){
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
                data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.pattern').on('click', function(){
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
                data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.fit').on('click', function(){
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
                data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });

        $('.occasion').on('click', function(){
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
                data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion,sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });


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
                    if(data['discount']>0){
                        $('.setProductPrice').html('<del>Rs. ' + data['product_price']+"</del> Rs. "+data['discount']);
                    }else {
                        $('.setProductPrice').html('Rs. ' + data['product_price']);
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
                    },error:function(){
                        alert('Error');
                    }
                });
            }

        });


    });
})(jQuery);
