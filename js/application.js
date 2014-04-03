$(document).ready(function() {
	$(".player").click(function() {
		if ($(this).hasClass("top-play") != true) {
			$(this).addClass("top-play");

			var player = {};

			var count;
			count = 0;

			console.log($(this).children());

		/*	do {
				$(this).eq(count).alert('bob');

				count++;
			} while $(this).eq(count).length != 0; */
		} else {
			$(this).removeClass("top-play");
		}
	});
});