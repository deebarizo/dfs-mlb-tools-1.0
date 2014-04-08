		<div class="col-wrapper">
			<section>
				<div class="col col-left">
		      		<h3><?php echo $subhead; ?></h3>
		  
		      		<?php if (isset($error)) { ?>
				      			<p style="color:red"><?php echo $error; ?></p>
		      		<?php } ?>
		
					<?php if (isset($fstats_fd)) { ?>
						<table class="salaries">
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
							<tr data-index="153"><td>C</td><td>Yan Gomes</td><td>2.6</td><td>6</td><td>CLE</td><td>SDP</td><td>2800</td></tr><tr data-index="129"><td>1B</td><td>Adam Dunn</td><td>2.8</td><td>6</td><td>CWS</td><td>COL</td><td>3000</td></tr><tr data-index="85"><td>1B</td><td>David Ortiz</td><td>2.2</td><td>6</td><td>BOS</td><td>TEX</td><td>4200</td></tr><tr data-index="106"><td>2B</td><td>Ben Zobrist</td><td>1.9</td><td>7</td><td>TAM</td><td>KAN</td><td>3500</td></tr><tr data-index="165"><td>3B</td><td>Conor Gillaspie</td><td>3.5</td><td>4</td><td>CWS</td><td>COL</td><td>2600</td></tr><tr data-index="118"><td>SS</td><td>Asdrubal Cabrera</td><td>1.0</td><td>6</td><td>CLE</td><td>SDP</td><td>3200</td></tr><tr data-index="155"><td>OF</td><td>Grady Sizemore</td><td>3.1</td><td>4</td><td>BOS</td><td>TEX</td><td>2700</td></tr><tr data-index="116"><td>OF</td><td>Adam Eaton</td><td>2.7</td><td>6</td><td>CWS</td><td>COL</td><td>3200</td></tr><tr data-index="96"><td>OF</td><td>Alex Rios</td><td>3.3</td><td>6</td><td>TEX</td><td>BOS</td><td>4000</td></tr><tr data-index="140"><td>OF</td><td>Seth Smith</td><td>2.5</td><td>6</td><td>SDP</td><td>CLE</td><td>2900</td></tr><tr data-index="38"><td>OF</td><td>Carlos Gonzalez</td><td>5.5</td><td>7</td><td>COL</td><td>CWS</td><td>4900</td></tr><tr data-index="4"><td>P</td><td>Jon Lester</td><td>12.1</td><td>2</td><td>BOS</td><td>TEX</td><td>7500</td>
							</tr>
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