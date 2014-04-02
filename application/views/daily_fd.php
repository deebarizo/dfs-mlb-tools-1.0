		<div class="col-wrapper">
			<section>
				<div class="col col-left">
		      		<h3><?php echo $subhead; ?></h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($fstats_fd)) { ?>
						<table>
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
		 							<tr>
										<td><?php echo $value['position']; ?></td>
										<td><?php echo $value['name']; ?></td>
										<td><?php echo $value['fppg']; ?></td>
										<td><?php echo $value['num_games']; ?></td>
										<td><?php echo $value['team']; ?></td>
										<td><?php echo $value['opponent']; ?></td>
										<td><?php echo $value['salary']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

				<div class="col col-mid">
		      		<h3>Top Plays</h3>
		  
					<table>
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
								<td colspan="7">No plays yet.</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col col-right">
		      		<h3>Optimal Lineup</h3>

					<table>
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
				</div>
			</section>