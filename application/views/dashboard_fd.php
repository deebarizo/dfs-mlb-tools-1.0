		<div class="col-wrapper">
			<section>
				<div class="options-dashboard">
					<h3><?php echo $subhead; ?></h3>

	      			<h4>Position</h4>

					<form action="">
						<select class="position-drop-down" name="position-drop-down">
							<option value="all" selected>All</option>
							<option value="C">C</option>
							<option value="1B">1B</option>
							<option value="2B">2B</option>
							<option value="3B">3B</option>
							<option value="SS">SS</option>
							<option value="OF">OF</option>
						</select>
					</form>
				</div>
			</section>
			<section>
				<div class="projections">
		      		<h3>Projections</h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($batters)) { ?>
						<div class="projections-table-container">
							<table class="projections" data-id="<?php echo $batters[0]['league_id']; ?>">
								<thead>
									<tr>
										<th data-sort='string'>Pos</th>
										<th data-sort='string'>Name</th>
										<th data-sort='int'>BO</th>
										<th data-sort='string'>Hand</th>
										<th data-sort='string'>Team</th>
										<th data-sort='string'>Opp</th>
										<th data-sort='string'>Opp P</th>
										<th data-sort='string'>Opp ERA</th>
										<th data-sort='string'>Opp Hand</th>
										<th data-sort='string'>Salary</th>
										<th data-sort='float'>FPPG</th>
										<th data-sort='float'>VR</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($batters as $key => $value) { ?>
										<?php 
											if ($value['batting_order'] > 0) {
												$toggle_in_lineup = "show-row in-lineup ";
											} else {
												$toggle_in_lineup = "hide-row ";
											}

											if (is_null($value['top_play_index'])) {
												$toggle_top_play = "";
											} else {
												$toggle_top_play = " top-play";
											}
										?>
			 							<tr class="<?php echo $toggle_in_lineup; ?>player<?php echo $toggle_top_play; ?>" data-index="<?php echo $key; ?>">
											<td class="position"><?php echo $value['position']; ?></td>
											<td class="name"><?php echo $value['name']; ?></td>
											<td class="batting-order"><?php echo $value['batting_order']; ?></td>
											<td class="hand"><?php echo isset($value['hand']) ? $value['hand'] : 'N'; ?></td>
											<td class="team"><?php echo $value['team']; ?></td>
											<td class="opponent"><?php echo $value['opponent']; ?></td>
											<td class="opponent-pitcher"><?php echo $value['opponent_pitcher']; ?></td>
											<td class="opponent-era"><?php echo (isset($value['opponent_era']) ? $value['opponent_era'] : '5.01'); ?></td>
											<td class="opponent-hand"><?php echo $value['opponent_hand']; ?></td>
											<td class="salary"><?php echo $value['salary']; ?></td>
											<td class="fppg"><?php echo (isset($value['projection']) ? $value['projection'] : '0.00'); ?></td>
											<td class="vr"><?php echo (isset($value['vr']) ? $value['vr'] : '0.00'); ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</div>
			</section>
		</div>