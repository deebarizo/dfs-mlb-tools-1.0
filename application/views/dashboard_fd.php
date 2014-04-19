		<div class="col-wrapper">
			<section>
				<div class="projections">
		      		<h3><?php echo $subhead; ?></h3>
		  
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
										<th data-sort='string'>Team</th>
										<th data-sort='string'>Opp</th>
										<th data-sort='string'>Salary</th>
										<th data-sort='float'>FPPG</th>
										<th data-sort='float'>VR</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($batters as $key => $value) { ?>
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
											<td class="team"><?php echo $value['team']; ?></td>
											<td class="opponent"><?php echo $value['opponent']; ?></td>
											<td class="salary"><?php echo $value['salary']; ?></td>
											<td class="opponent"><?php echo $value['projection']; ?></td>
											<td class="salary"><?php echo $value['vr']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</div>
			</section>
		</div>