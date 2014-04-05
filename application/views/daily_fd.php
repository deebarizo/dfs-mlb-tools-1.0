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
								<td class="no-top-plays" colspan="7">No plays yet.</td>
							</tr>
					<!--	<tr data-index="312"><td>C</td><td>Miguel Montero</td><td>3.4</td><td>3</td><td>ARI</td><td>SFG</td><td>3300</td></tr><tr data-index="129"><td>1B</td><td>Chris Davis</td><td>-104.3</td><td>1</td><td>BAL</td><td>BOS</td><td>4500</td></tr><tr data-index="303"><td>2B</td><td>Aaron Hill</td><td>3.3</td><td>3</td><td>ARI</td><td>SFG</td><td>3500</td></tr><tr data-index="249"><td>3B</td><td>Evan Longoria</td><td>-107.3</td><td>1</td><td>TAM</td><td>TOR</td><td>4200</td></tr><tr data-index="281"><td>SS</td><td>Elvis Andrus</td><td>-112.0</td><td>1</td><td>TEX</td><td>PHI</td><td>3800</td></tr><tr data-index="143"><td>OF</td><td>Bryce Harper</td><td>-75.0</td><td>1</td><td>WAS</td><td>NYM</td><td>4300</td></tr><tr data-index="316"><td>OF</td><td>Will Venable</td><td>-43.5</td><td>2</td><td>SDP</td><td>LOS</td><td>3300</td></tr><tr data-index="15"><td>P</td><td>Gio Gonzalez</td><td>11.2</td><td>32</td><td>WAS</td><td>NYM</td><td>8000</td></tr><tr data-index="126"><td>OF</td><td>Andrew McCutchen</td><td>-97.5</td><td>1</td><td>PIT</td><td>CHC</td><td>4600</td></tr><tr data-index="289"><td>3B</td><td>Pedro Alvarez</td><td>-107.0</td><td>1</td><td>PIT</td><td>CHC</td><td>3600</td></tr><tr data-index="260"><td>1B</td><td>David Ortiz</td><td>-88.5</td><td>1</td><td>BOS</td><td>BAL</td><td>4000</td></tr><tr data-index="291"><td>C</td><td>Yadier Molina</td><td>-79.0</td><td>1</td><td>STL</td><td>CIN</td><td>3600</td></tr><tr data-index="138"><td>1B</td><td>Edwin Encarnacion</td><td>-96.5</td><td>1</td><td>TOR</td><td>TAM</td><td>4400</td></tr><tr data-index="276"><td>OF</td><td>Wil Myers</td><td>-51.3</td><td>1</td><td>TAM</td><td>TOR</td><td>3800</td></tr><tr data-index="97"><td>OF</td><td>Carlos Gonzalez</td><td>6.5</td><td>1</td><td>COL</td><td>MIA</td><td>5000</td></tr><tr data-index="332"><td>1B</td><td>Justin Morneau</td><td>0.3</td><td>1</td><td>COL</td><td>MIA</td><td>3200</td></tr><tr data-index="127"><td>OF</td><td>Giancarlo Stanton</td><td>6.3</td><td>1</td><td>MIA</td><td>COL</td><td>4600</td></tr><tr data-index="333"><td>C</td><td>Carlos Ruiz</td><td>-50.8</td><td>1</td><td>PHI</td><td>TEX</td><td>3200</td></tr><tr data-index="142"><td>1B</td><td>Prince Fielder</td><td>-110.5</td><td>1</td><td>TEX</td><td>PHI</td><td>4300</td></tr><tr data-index="132"><td>3B</td><td>Adrian Beltre</td><td>-101.0</td><td>1</td><td>TEX</td><td>PHI</td><td>4500</td></tr><tr data-index="304"><td>1B</td><td>Mark Teixeira</td><td>2.2</td><td>15</td><td>NYY</td><td>HOU</td><td>3500</td></tr><tr data-index="321"><td>C</td><td>Jason Castro</td><td>2.6</td><td>120</td><td>HOU</td><td>NYY</td><td>3300</td></tr><tr data-index="160"><td>C</td><td>Buster Posey</td><td>-83.8</td><td>1</td><td>SFG</td><td>ARI</td><td>4200</td></tr><tr data-index="301"><td>1B</td><td>Brandon Belt</td><td>-80.5</td><td>1</td><td>SFG</td><td>ARI</td><td>3500</td></tr><tr data-index="90"><td>1B</td><td>Paul Goldschmidt</td><td>3.6</td><td>3</td><td>ARI</td><td>SFG</td><td>5100</td></tr><tr data-index="372"><td>OF</td><td>Corey Hart</td><td>0.0</td><td>0</td><td>SEA</td><td>LAA</td><td>3000</td></tr><tr data-index="58"><td>OF</td><td>Mike Trout</td><td>7.5</td><td>1</td><td>LAA</td><td>SEA</td><td>5700</td></tr><tr data-index="31"><td>P</td><td>Brandon Morrow</td><td>7.0</td><td>10</td><td>TOR</td><td>TAM</td><td>5200</td></tr><tr data-index="21"><td>P</td><td>Taijuan Walker</td><td>8.3</td><td>3</td><td>SEA</td><td>OAK</td><td>5900</td></tr>
					-->	
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