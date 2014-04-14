		if (bestLineup['salary'] >= 34700) {
			unspentToggle = "good";
		} else {
			unspentToggle = "bad";
		}

		showOptimalLineup(bestLineup, unspentToggle);

		return false;			
		} else {
			unspentToggle = "good";
			showOptimalLineup(bestLineup, unspentToggle);

			return false;	
		}


			if (totalSalary > bestLineups[bestLineups.length-1]['salary'] && totalSalary <= 35000) {
				if (bestLineups.length < 10) { 
					var eligibleLineup = {
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

					bestLineups.push(eligibleLineup);
				}
			}