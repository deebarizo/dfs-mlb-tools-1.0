		var positionCount = 0;
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
		var solverCount = 0;
		var bestLineup = {
			salary: totalSalary,
			changeTracker: changeTracker,
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

		//////////////////////////////////////////////////////////////////

		if (diff * -1 > 300) { 
			for (var i = 0; i < 2000; i++) {
				var random = Math.floor(Math.random()*2) + 1;

				if (random == 1) {
					if (positionCount <= 4) {
						positionCount++;
					}
				}

				if (positionCount >= 6) {
					changeTracker[positionCount][1] += 3;
				} else {
					changeTracker[positionCount][1]++;
				}

				console.log("changeTracker: "+changeTracker);
				console.log("positionCount: "+positionCount);

				if (typeof sortedSalaries[changeTracker[positionCount][0]][changeTracker[positionCount][1]] == "undefined") {
					if (positionCount <= 5) {
						changeTracker[positionCount][1]--;

						positionCount++;
					} else {
						changeTracker[positionCount][1] -= 3;

						positionCount = 0;
					}

					
				} else {
					totalSalary = sortedSalaries["P"][changeTracker[0][1]][4] + 
								  sortedSalaries["C"][changeTracker[1][1]][4] + 
								  sortedSalaries["1B"][changeTracker[2][1]][4] + 
								  sortedSalaries["2B"][changeTracker[3][1]][4] + 
								  sortedSalaries["3B"][changeTracker[4][1]][4] + 
								  sortedSalaries["SS"][changeTracker[5][1]][4] + 
								  sortedSalaries["OF"][changeTracker[6][1]][4] + 
								  sortedSalaries["OF"][changeTracker[7][1]][4] + 
								  sortedSalaries["OF"][changeTracker[8][1]][4];

					diff = totalSalary - 35000;

					console.log(totalSalary);

					if (totalSalary > bestLineup['salary'] && totalSalary <= 35000) {
						bestLineup = {
							salary: totalSalary,
							changeTracker: changeTracker,
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
					}

					if (diff * -1 <= 300 && totalSalary <= 35000) {
						$("table.optimal-lineup > tbody > tr").remove();

						var htmlOptimalLineup;

						for (var i = 0; i < bestLineup['lineup'].length; i++) {
							htmlOptimalLineup += "<tr>";

							for (var n = 0; n < bestLineup['lineup'][i].length; n++) {
								htmlOptimalLineup += "<td>"+bestLineup['lineup'][i][n]+"</td>";
							};

							htmlOptimalLineup += "</tr>";
						};

						htmlOptimalLineup += "<td colspan='4'>Total Salary</td><td style='color: green;'><strong>"+bestLineup['salary']+"</strong></td>";

						$("table.optimal-lineup > tbody:last").append(htmlOptimalLineup);

						return false;	
					}

					if (totalSalary > 35000) {
						if (positionCount <= 5) {
							changeTracker[positionCount][1]--;

							positionCount++;
						} else {
							changeTracker[positionCount][1] -= 3;

							if (solverCount >= 6) {
								solverCount = 0;
							}

							positionCount = solverCount;
							solverCount++;

							if (changeTracker[positionCount][1] > 0) {
								changeTracker[positionCount][1]--;
							} else {
								changeTracker[positionCount][1] = 0;
							}
						}
					}	
				}
			}		
		} else {
			$("table.optimal-lineup > tbody > tr").remove();

			var htmlOptimalLineup;

			for (var i = 0; i < bestLineup['lineup'].length; i++) {
				htmlOptimalLineup += "<tr>";

				for (var n = 0; n < bestLineup['lineup'][i].length; n++) {
					htmlOptimalLineup += "<td>"+bestLineup['lineup'][i][n]+"</td>";
				};

				htmlOptimalLineup += "</tr>";
			};

			htmlOptimalLineup += "<td colspan='4'>Total Salary</td><td style='color: green;'><strong>"+bestLineup['salary']+"</strong></td>";

			$("table.optimal-lineup > tbody:last").append(htmlOptimalLineup);

			return false;	
		}