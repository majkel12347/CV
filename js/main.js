$(document).ready(function() {
	console.log('Hello word');

    $('.fancy').fancybox();
	listener_goup();
	listener_contact();
});

function listener_goup(){
	$('.arrow').on('click', function(){
        var body = $("html, body");
        body.animate({scrollTop:0}, '1000');
    });
} 


function listener_contact(){
	$('.contact_btn').on('click', function(){
        $('.error').css('display', 'none');
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "send.php",
            data:{ 
				name:	$('#c_name').val(), 
				email:	$('#c_email').val(),
				text:	$('#c_text').val()
			}
        }).done(function(data) {
            if(data.type=='error'){
                $.each(data.code, function(k,v){
                    $('.err_c_'+k).html(v).css('display','block');
                });
            }else if(data.type=='success'){
                $('.kontakt_box_all1').css('display','none');
                $('.kontakt_box_all2').css('display','block').html(data.code);
            }
        }); 
    });
}