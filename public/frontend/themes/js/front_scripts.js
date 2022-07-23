(function($){
    $(document).ready(function(){
        //sorting products
        // $('#sort').change(function(){
        //     this.form.submit();
        // });

        $('#sort').change(function(){
            const sort = $(this).val();
            const url = $('#url').val();
            $.ajax({
                url:url,
                method:'post',
                data: {sort:sort,url:url},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('Error');
                }
            });
        });
    });
})(jQuery);
