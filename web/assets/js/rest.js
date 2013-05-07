$(document).ready(function() {
	$('a[data-method]').on('click', function(event) {
		event.preventDefault();
		var a = $(event.target).closest('a');
		var input = $('<input>').attr('type', 'hidden').attr('name', '_method').val(a.attr('data-method'));
		var form = $('<form />').attr('action', a.attr('href')).attr('method', 'POST').append(input);
		$('body').append(form);
		form.submit();
	});
});