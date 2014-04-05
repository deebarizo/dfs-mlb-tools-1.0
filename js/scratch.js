				if (typeof sortedSalaries[changeTracker[positionCount][0]][changeTracker[positionCount][1]] == "undefined") {
					if (positionCount == 6) {
						positionCount = 0;
					} else {
						positionCount++;
					}

					console.log("changeTracker: "+changeTracker);
					console.log("positionCount: "+positionCount);
					
					continue;
				} else {
					console.log("changeTracker: "+changeTracker);
					console.log("positionCount: "+positionCount);

					if (positionCount <= 5) {
						changeTracker[positionCount][1]++;
						rankCount++;
					} else {
						changeTracker[positionCount][1] += 3;
					}

					console.log(changeTracker);

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

					if (totalSalary > 35000) {
						if (positionCount <= 5) {
							changeTracker[positionCount][1]--;
						} else {
							changeTracker[positionCount][1] -= 3;
						}

						if (positionCount == 6) {
							positionCount = 0;
						} else {
							positionCount++;
							rankCount = 1;
						}					
						
						continue;
					} else if (diff * -1 > 300) {
						if (positionCount <= 5) {
							changeTracker[positionCount][1]++;
							rankCount++;
						} else {
							changeTracker[positionCount][1] += 3;
						}

						console.log("changeTracker: "+changeTracker);
						console.log("positionCount: "+positionCount);

						continue;
					} else {
						alert("Here is the optimal lineup total salary $"+totalSalary+".");
					}