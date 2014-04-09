		<div class="col-wrapper">
			<section>
				<div class="col col-left">
		      		<h3><?php echo $subhead; ?></h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($fstats_fd)) { ?>
						<table class="salaries" data-id="<?php echo $fstats_fd[0]['league_id']; ?>">
							<thead>
								<tr>
									<th data-sort='string'>Pos</th>
									<th data-sort='string'>Name</th>
									<th data-sort='float'>FPPG</th>
									<th data-sort='int'>G</th>
									<th data-sort='string'>Team</th>
									<th data-sort='string'>Opp</th>
									<th data-sort='string'>Salary</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($fstats_fd as $key => $value) { ?>
		 							<tr class="player" data-index="<?php echo $key; ?>">
										<td class="position"><?php echo $value['position']; ?></td>
										<td class="name"><?php echo $value['name']; ?></td>
										<td class="fppg"><?php echo $value['fppg']; ?></td>
										<td class="num-games"><?php echo $value['num_games']; ?></td>
										<td class="team"><?php echo $value['team']; ?></td>
										<td class="opponent"><?php echo $value['opponent']; ?></td>
										<td class="salary"><?php echo $value['salary']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

				<div class="col col-mid">
		      		<h3>Top Plays</h3>

		      		<button type="button" class="save-top-plays">Save</button> <span class="save-top-plays-confirmation">These top plays were saved.</span>
		  
					<table class="top-plays">
						<thead>
							<tr>
								<th data-sort='string'>Pos</th>
								<th data-sort='string'>Name</th>
								<th data-sort='float'>FPPG</th>
								<th data-sort='int'>G</th>
								<th data-sort='string'>Team</th>
								<th data-sort='string'>Opp</th>
								<th data-sort='string'>Salary</th>
							</tr>
						</thead>
						<tbody>
 							<tr>
								<td class="no-top-plays" colspan="7" style="display: none;">No plays yet.</td>
							</tr>
							<tr data-index="9"><td>P</td><td>Gio Gonzalez</td><td>15.0</td><td>1</td><td>WAS</td><td>MIA</td><td>8300</td></tr>
						</tbody>
					</table>
				</div>

				<div class="col col-right">
		      		<h3>Optimal Lineup</h3>

					<table class="optimal-lineup">
						<thead>
							<tr>
								<th data-sort='string'>Pos</th>
								<th data-sort='string'>Name</th>
								<th data-sort='string'>Team</th>
								<th data-sort='string'>Opp</th>
								<th data-sort='string'>Salary</th>
							</tr>
						</thead>
						<tbody>
 							<tr>
								<td colspan="5">No lineup yet.</td>
							</tr>
						</tbody>
					</table>

					<button type="button" class="solver">Solve</button>
				</div>
			</section>