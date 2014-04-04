$(document).ready(function() {
	$("tr.player").click(function() {
		var dataIndex = $(this).data("index");

		if ($(this).hasClass("top-play") != true) {
			$(this).addClass("top-play");

			var player = [];

			var playerData = $(this).children();

			$(playerData).each(function(index){
				player[index] = $(this).text();
			});

			if($("td.no-top-plays").is(":visible")) {
				$("td.no-top-plays").hide();
			}

			var html = "<tr data-index='"+dataIndex+"'>";
			for (var i = 0; i < player.length; i++) {
				html += "<td>"+player[i]+"</td>";
			};
			html += "</tr>";

			$("table.top-plays > tbody:last").append(html);
		} else {
			$(this).removeClass("top-play");

			$("table.top-plays > tbody > tr[data-index='"+dataIndex+"']").remove();

			topPlayCheck();
		}
	});

	$(document).on("click", "table.top-plays tbody tr", function() {
		var dataIndex = $(this).data("index");

		$(this).remove();

		$("table.salaries > tbody > tr[data-index='"+dataIndex+"']").removeClass("top-play");

		topPlayCheck();
	});

	function topPlayCheck() {
		var topPlayCheck = $(".top-play").length;
		if (topPlayCheck == 0) {
			$("td.no-top-plays").show();
		} 		
	}

	$("button.solve-optimal-lineup").click(function() {
		var topPlays = [];

		$("table.top-plays > tbody > tr").each(function(index) {
			var playerData = $(this).children();

			topPlays.push(playerData);
		});

		var singlePositions = ["P", "C", "1B", "2B", "3B", "SS"];
		var unfilledPositions = [];
		var positionFilled = false;

		for (var i = 0; i < singlePositions.length; i++) {
			for (var n = 0; n < topPlays.length; n++) {
				var position = $(topPlays[n][0]).text();

				if (singlePositions[i] == position) {
					positionFilled = true;

					break;
				}
			};

			if (positionFilled == false) {
				unfilledPositions.push(singlePositions[i]);
			}

			positionFilled = false;
		};

		var multiplePositions = [[3, "OF"]];
		var count = 0;

		for (var i = 0; i < multiplePositions.length; i++) {
			for (var n = 0; n < topPlays.length; n++) {
				var position = $(topPlays[n][0]).text();

				if (multiplePositions[i][1] == position) {
					count++;

					if (count == multiplePositions[i][0]) {
						positionFilled = true;

						break;
					}
				}
			};

			if (positionFilled == false) {
				unfilledPositions.push([count, multiplePositions[i][1]]);
			}

			positionFilled = false;
		};		

		if (unfilledPositions.length > 0) {
			alert("There are unfilled positions. "+unfilledPositions);
			return false;
		}
	});
});