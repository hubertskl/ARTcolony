$('#search').keyup( function(){
	var s = $('#search').val();
	
	        $.ajax({
            url: '../user/reviews/search.php',
            data: 'usearch='+s,
            success:function (data) {
				$('#feedback').html(data);
            }
        });
	
});