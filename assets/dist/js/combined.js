$(window).load(function() {
  $("#loader").delay(400).fadeOut("slow");
});

jQuery(document).ready(function($) {

	$('#form').on('submit', function(e) {
	    $.ajax({
	        url: $(this).attr('action'),
	        type: 'POST',
	        dataType : 'json',
	        data: $(this).serialize(),
	        

			// beforeSend: function() {
			// 	// $('.spinner-wrap').addClass('-show');
			// },

			// complete: function() {
			// 	// $('.spinner-wrap').removeClass('-show');
			// }
	    })

	    .done(function(json_response) {
			swal({   
				title: "Success!",   
				text: '<div class="swal_success"><p>Name: ' + json_response.name + '</p>' +
				'<p>Email: ' + json_response.email + '</p>' +
				'<p>Order: ' + json_response.order + '</p></div>',
				html: true, 
				type: "success"
			});

			// console.log(json_response);
			$('.form__list').append('<li class="form__list-item" data-order=' + json_response.order + '>' + json_response.name + ' (' + json_response.email + ')<span class="form__list-item-delete">&#10799;</span></li>');
			$('.form__list-item.-empty').remove();

			// sorting
			$(".form__list li").sort(orderSort).appendTo('.form__list');

	    })

	    .fail(function(msg) {
	    	json_response = $.parseJSON(msg.responseText);
	    	// console.log(json_response);
	    	sweetAlert("Oops...", json_response.message, "error");
	    })

	    e.preventDefault();
	});



	// delete item
	$('.form__list').on('click', '.form__list-item-delete', function(e) {

		var order_id = $(this).parent().attr('data-order');
		var api_url = 'api.php?api_key=sdgv0ddff7kko3hj&delete=true';

		$.ajax({
	        url: api_url,
	        type: 'POST',
	        dataType : 'json',
	        data: { 'order' : order_id },
	    })

	    .done(function(json_response) {
			swal({   
				title: "Success!",   
				text: 'item deleted!',
				html: true, 
				type: "success"
			});
			
			$('.form__list-item[data-order='+order_id+']').remove();

			if ( $('.form__list li').length == 0) {
				$('.form__list').append('<p class="form__list-item -empty">user list is empty</p>');
			}

	    })

	    .fail(function(msg) {
	    	sweetAlert("Oops...", 'on deleting happened error :(', "error");
	    })

	    e.preventDefault();
	});

});



// ----------- SORT func -------------

function orderSort(x, y){
    return ($(y).data('order')) < ($(x).data('order')) ? 1 : -1;    
}
