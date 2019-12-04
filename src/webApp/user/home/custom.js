$('#search').keyup( function(){
	var s = $('#search').val();
	        $.ajax({
            url: '../user/home/search_users.php',
            data: 'usearch='+s,
            success:function (data) {
				$('#users_content').html(data);
				if (s === "") {
				$("#users_content").empty();
				}
            }	
        });
		
	
});
