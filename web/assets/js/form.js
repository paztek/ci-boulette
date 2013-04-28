$(document).ready(function() {
	$('button[data-action="recopy"]').on('click', function(event) {
		event.preventDefault();
		var button = $(event.target).closest('button');
		var source = $('[data-action-name="' + button.attr('data-source') + '"]');
		var dest = $('[data-action-name="' + button.attr('data-dest') + '"]');
		dest.val(source.val());
	});
});