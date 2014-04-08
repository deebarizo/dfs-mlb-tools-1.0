		<div class="col-wrapper">
			<section>
				<div class="col col-left">
		      		<h3><?php echo $subhead; ?></h3>
		  
					<table class="salaries">
						<thead>
							<tr>
								<th data-sort='string'>Date (Time)</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($league as $key => $value) { ?>
	 							<tr>
									<td><a href="<?php echo base_url().'daily/fd/'.$value['date'].'/'.$value['time']; ?>"><?php echo $value['date']; ?> (<?php echo $value['capitalized_time']; ?>)</a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</section>