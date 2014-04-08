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

			var htmlTopPlays = "<tr data-index='"+dataIndex+"'>";
			for (var i = 0; i < player.length; i++) {
				htmlTopPlays += "<td>"+player[i]+"</td>";
			};
			htmlTopPlays += "</tr>";

			$("table.top-plays > tbody:last").append(htmlTopPlays);
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

	$("button.solver").click(function() {
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

		var allPositions = ["P", "C", "1B", "2B", "3B", "SS", "OF"];
		var sortedSalaries = {};

		for (var i = 0; i < allPositions.length; i++) {
			sortedSalaries[allPositions[i]] = [];

			for (var n = 0; n < topPlays.length; n++) {
				var position = $(topPlays[n][0]).text();

				if (allPositions[i] == position) {
					var name = $(topPlays[n][1]).text();
					var team = $(topPlays[n][4]).text();
					var opp = $(topPlays[n][5]).text();
					var salary = parseInt($(topPlays[n][6]).text());

					sortedSalaries[allPositions[i]].push([position, name, team, opp, salary]);
				}
			};

		    sortedSalaries[allPositions[i]] = sortedSalaries[allPositions[i]].sort(function(a,b) {
		    	return a[4] > b[4];
		    });
		};		

		console.log("sortedSalaries");
		console.log(sortedSalaries);

		var totalSalary = sortedSalaries["P"][0][4] + 
						  sortedSalaries["C"][0][4] + 
						  sortedSalaries["1B"][0][4] + 
						  sortedSalaries["2B"][0][4] + 
						  sortedSalaries["3B"][0][4] + 
						  sortedSalaries["SS"][0][4] + 
						  sortedSalaries["OF"][0][4] + 
						  sortedSalaries["OF"][1][4] + 
						  sortedSalaries["OF"][2][4];

		var diff = totalSalary - 35000;

		if (totalSalary > 35000) {
			alert("The cheapest lineup is above the salary cap by $"+diff+".");
			return false;
		}

		var changeTracker = [
			["P", 0], 
			["C", 0], 
			["1B", 0], 
			["2B", 0], 
			["3B", 0], 
			["SS", 0], 
			["OF", 0], 
			["OF", 1], 
			["OF", 2]
		];

		var bestLineup = {
			salary: totalSalary,
			lineup: [
				sortedSalaries["P"][changeTracker[0][1]],
				sortedSalaries["C"][changeTracker[1][1]],
				sortedSalaries["1B"][changeTracker[2][1]],
				sortedSalaries["2B"][changeTracker[3][1]],
				sortedSalaries["3B"][changeTracker[4][1]],
				sortedSalaries["SS"][changeTracker[5][1]],
				sortedSalaries["OF"][changeTracker[6][1]],
				sortedSalaries["OF"][changeTracker[7][1]],
				sortedSalaries["OF"][changeTracker[8][1]]
			]
		};

		var randomNumber;

		console.log("changeTracker");
		console.log(changeTracker);

		if (diff * -1 > 300) { 
			$('button.solver').prop('disabled', true);
			$('button.solver').text('Solving...');

			for (var i = 0; i < 10000; i++) {
				randomNumber = Math.floor(Math.random()*sortedSalaries["P"].length) + 1;
				changeTracker[0][1] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["C"].length) + 1;
				changeTracker[0][2] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["1B"].length) + 1;
				changeTracker[0][3] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["2B"].length) + 1;
				changeTracker[0][4] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["3B"].length) + 1;
				changeTracker[0][5] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["SS"].length) + 1;
				changeTracker[0][6] = randomNumber;

				randomNumber = Math.floor(Math.random()*sortedSalaries["OF"].length) + 1;
				changeTracker[0][7] = randomNumber;

				do {
					randomNumber = Math.floor(Math.random()*sortedSalaries["OF"].length) + 1;
				} while (randomNumber != changeTracker[0][7]);
				changeTracker[0][8] = randomNumber;		

				do {
					randomNumber = Math.floor(Math.random()*sortedSalaries["OF"].length) + 1;
				} while (randomNumber != changeTracker[0][7] && randomNumber != changeTracker[0][8]);
				changeTracker[0][9] = randomNumber;			

				
			};

			showOptimalLineup(bestLineup, "bad");

			return false;			
		} else {
			showOptimalLineup(bestLineup, "good");

			return false;	
		}
	});

	function showOptimalLineup(bestLineup, unspentToggle) {
		$("table.optimal-lineup > tbody > tr").remove();

		var htmlOptimalLineup;

		for (var i = 0; i < bestLineup['lineup'].length; i++) {
			htmlOptimalLineup += "<tr>";

			for (var n = 0; n < bestLineup['lineup'][i].length; n++) {
				htmlOptimalLineup += "<td>"+bestLineup['lineup'][i][n]+"</td>";
			};

			htmlOptimalLineup += "</tr>";
		};

		if (unspentToggle == "bad") {
			var color = "<td style='color: red;'>";
		} else if (unspentToggle == "good") {
			var color = "<td style='color: green;'>";
		}

		htmlOptimalLineup += "<td colspan='4'>Total Salary</td>"+color+"<strong>"+bestLineup['salary']+"</strong></td>";

		$("table.optimal-lineup > tbody:last").append(htmlOptimalLineup);

		$('button.solver').prop('disabled', false);
		$('button.solver').text('Solve');
	}
});