(function($){
    $(document).ready(function(){
        //sorting products
        // $('#sort').change(function(){
        //     this.form.submit();
        // });

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
            let fabric = getFilter(this);
            const sort = $('#sort option:selected').val();
            const url = $('#url').val();
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

        function getFilter(class_name){
            let filter = [];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            // console.log(filter);
            return filter;
        }
    });
})(jQuery);
