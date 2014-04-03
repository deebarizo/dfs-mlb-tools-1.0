$(document).ready(function() {
	$(".player").click(function() {
		if ($(this).hasClass("top-play") != true) {
			$(this).addClass("top-play");

			var player = [];

			var playerData = $(this).children();

			console.log(playerData);

			$(playerData).each(function(index){
				player[index] = $(this).text();
			});

			console.log(player);

			if($("td.no-top-plays").is(":visible")) {
				$("td.no-top-plays").hide();
			}

			var html = "<tr>";

			console.log(player.length);

			for (var i = 0; i < player.length; i++) {
				html += "<td>"+player[i]+"</td>";
			};

			html += "</tr>";

			$("table.top-plays > tbody:last").append(html);
		} else {
			$(this).removeClass("top-play");
		}
	});
});