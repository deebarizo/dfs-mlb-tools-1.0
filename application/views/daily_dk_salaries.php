		<div class="col-wrapper">
			<section>
				<div class="salaries">
		      		<h3><?php echo $subhead; ?></h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($salaries_dk)) { ?>
						<div class="salaries-table-container">
							<table class="salaries" data-id="<?php echo $league_id; ?>">
								<thead>
									<tr>
										<th data-sort='string'>Pos</th>
										<th data-sort='string'>Name</th>
										<th data-sort='int'>Salary</th>
										<th data-sort='string'>Game Info</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($salaries_dk as $key => $value) { ?>
										<?php 
											if (is_null($value['top_play_index'])) {
												$toggle_top_play = "";
											} else {
												$toggle_top_play = " top-play";
											}
										?>
			 							<tr class="player<?php echo $toggle_top_play; ?>" data-index="<?php echo $key; ?>">
											<td class="position"><?php echo $value['position']; ?></td>
											<td class="name dk"><?php echo $value['name']; ?></td>
											<td class="salary"><?php echo $value['salary']; ?></td>
											<td class="game_info"><?php echo $value['game_info']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</div>

				<div class="top-plays">
		      		<h3>Top Plays</h3>

		      		<button type="button" class="save-top-plays dk">Save</button> <span class="save-top-plays-confirmation">These top plays were saved.</span>
		  
		  			<div class="top-plays-table-container">
						<table class="top-plays">
							<thead>
								<tr>
									<th data-sort='string'>Pos</th>
									<th data-sort='string'>Name</th>
									<th data-sort='int'>Salary</th>
									<th data-sort='string'>Game Info</th>
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
											<td><?php echo $value['salary']; ?></td>
											<td><?php echo $value['game_info']; ?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
<!--
			<section>
				<div class="optimal-lineups">
		      		<h3>Optimal Lineups</h3>

		      		<button type="button" class="solver">Solve</button>

		      		<div style="clear:both"></div>
				</div>
			</section>
-->