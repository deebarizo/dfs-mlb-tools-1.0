		<div class="col-wrapper">
			<section>
				<div class="salaries">
		      		<h3><?php echo $subhead; ?></h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($fstats_fd)) { ?>
						<div class="salaries-table-container">
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
										<?php 
											if (is_null($value['top_play_index'])) {
												$toggle_top_play = "";
											} else {
												$toggle_top_play = " top-play";
											}
										?>
			 							<tr class="player<?php echo $toggle_top_play; ?>" data-index="<?php echo $key; ?>">
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
						</div>
					<?php } ?>
				</div>

				<div class="top-plays">
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
							<?php 
								if (empty($top_plays)) {
									$toggle_top_plays = "";
								} else {
									$toggle_top_plays = ' style="display: none;"';
								}
							?>
 							<tr>
								<td class="no-top-plays" colspan="7"<?php echo $toggle_top_plays; ?>>No plays yet.</td>
							</tr>
							<?php if (empty($top_plays) == false) { ?>
								<?php foreach ($top_plays as $key => $value) { ?>
									<tr data-index="<?php echo $value['top_play_index']; ?>">
										<td><?php echo $value['position']; ?></td>
										<td><?php echo $value['name']; ?></td>
										<td><?php echo $value['fppg']; ?></td>
										<td><?php echo $value['num_games']; ?></td>
										<td><?php echo $value['team']; ?></td>
										<td><?php echo $value['opponent']; ?></td>
										<td><?php echo $value['salary']; ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</section>
		</div>

			<section>
				<div class="optimal-lineups">
		      		<h3>Optimal Lineups</h3>

		      		<button type="button" class="solver">Solve</button>

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
								<td colspan="5">No lineups yet.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>