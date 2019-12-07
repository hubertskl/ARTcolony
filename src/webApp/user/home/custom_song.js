$('#search2').keyup( function(){
	var s = $('#search2').val();
	        $.ajax({
            url: '../user/home/search_songs.php',
            data: 'usearch='+s,
            success:function (data) {
				$('#songs_content').html(data);
				if (s === "") {
				$("#songs_content").empty();
				}
            }	
        });
		
	
});
