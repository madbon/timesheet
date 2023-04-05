$(document).ready(function(){
	$('.modalButton').click(function(){
		$("#modalContent").html("");
        $('#myModal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});
