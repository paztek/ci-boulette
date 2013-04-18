$(document).ready(function() {
	$('a[data-method]').on('click', function(event) {
		event.preventDefault();
		var a = $(event.target);
		var input = $('<input>').attr('type', 'hidden').attr('name', '_method').val(a.attr('data-method'));
		$('<form />').attr('action', a.attr('href')).attr('method', 'POST').append(input).submit();
	});
});