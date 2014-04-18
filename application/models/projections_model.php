<?php
class projections_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function generate_fd_projections($date) {
		$csv_zips_file = 'files/projections/'.preg_replace('/-/', '', $date).'_zips_batter.csv';

		if (file_exists($csv_zips_file)) {
			if (($handle = fopen($csv_zips_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];

				    	$games = $csv_data[1];

				    	$ab = $csv_data[3];
				    	
				    	$hits = $csv_data[4];
				    	$doubles = $csv_data[5];
				    	$triples = $csv_data[6];
				    	$hr = $csv_data[7];

				    	$runs = $csv_data[8];
				    	$rbi = $csv_data[9];

				    	$bb = $csv_data[10];
				    	$hbp = $csv_data[12];

				    	$sb = $csv_data[13];

				    	$player_id = $csv_data[23];

				    	$singles = $hits - $doubles - $triples - $hr;
				    	$outs = $ab - $hits;

				    	$projections[$player_id]['name'] = $name;
				    	$projections[$player_id]['games'] = $games;

				    	$projections[$player_id]['bb_zips'] = $bb / $games;
				    	$projections[$player_id]['hbp_zips'] = $hbp / $games;
				    	$projections[$player_id]['singles_zips'] = $singles / $games;
				    	$projections[$player_id]['doubles_zips'] = ($doubles / $games) * 2;
				    	$projections[$player_id]['triples_zips'] = ($triples / $games) * 3;
				    	$projections[$player_id]['hr_zips'] = ($hr / $games) * 4;

				    	$projections[$player_id]['rbi_zips'] = $rbi / $games;
				    	$projections[$player_id]['runs_zips'] = $runs / $games;

				    	$projections[$player_id]['sb_zips'] = ($sb / $games) * 2;

				    	$projections[$player_id]['outs_zips'] = ($outs / $games) * -0.25;

				    	$total = 0;
				    	foreach ($projections[$player_id] as $key => $value) {
				    		if ((strpos($key,'zips') !== false)) {
				    			$total += $value;
				    		}
				    	}

						$projections[$player_id]['total_zips'] = $total;
					}

				    $row++;
				}
			}
		} else {
			return 'The Zips csv file is missing.';
		}

		$csv_steamer_file = 'files/projections/'.preg_replace('/-/', '', $date).'_steamer_batter.csv';

		if (file_exists($csv_steamer_file)) {
			if (($handle = fopen($csv_steamer_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];

				    	$pa = $csv_data[1];

				    	$ab = $csv_data[2];
				    	
				    	$hits = $csv_data[3];
				    	$doubles = $csv_data[4];
				    	$triples = $csv_data[5];
				    	$hr = $csv_data[6];

				    	$runs = $csv_data[7];
				    	$rbi = $csv_data[8];

				    	$bb = $csv_data[9];
				    	$hbp = $csv_data[11];

				    	$sb = $csv_data[12];

				    	$player_id = $csv_data[22];

				    	$singles = $hits - $doubles - $triples - $hr;
				    	$outs = $ab - $hits;

				    	if (isset($projections[$player_id]['games'])) {
				    		$games = $projections[$player_id]['games'];

					    	$projections[$player_id]['name'] = $name;

					    	$projections[$player_id]['bb_steamer'] = $bb / $games;
					    	$projections[$player_id]['hbp_steamer'] = $hbp / $games;
					    	$projections[$player_id]['singles_steamer'] = $singles / $games;
					    	$projections[$player_id]['doubles_steamer'] = ($doubles / $games) * 2;
					    	$projections[$player_id]['triples_steamer'] = ($triples / $games) * 3;
					    	$projections[$player_id]['hr_steamer'] = ($hr / $games) * 4;

					    	$projections[$player_id]['rbi_steamer'] = $rbi / $games;
					    	$projections[$player_id]['runs_steamer'] = $runs / $games;

					    	$projections[$player_id]['sb_steamer'] = ($sb / $games) * 2;

					    	$projections[$player_id]['outs_steamer'] = ($outs / $games) * -0.25;

					    	$total = 0;
					    	foreach ($projections[$player_id] as $key => $value) {
					    		if ((strpos($key,'steamer') !== false)) {
					    			$total += $value;
					    		}
					    	}

							$projections[$player_id]['total_steamer'] = $total;
				    	} else {
					    	$projections[$player_id]['name'] = $name;

					    	$projections[$player_id]['bb_steamer'] = ($bb / $pa) * 4.25; // http://espn.go.com/fantasy/baseball/story/_/page/mlbdk2k13_lineuppositions/jose-altuve-erick-aybar-giancarlo-stanton-see-fantasy-values-affected-most-lineup-position
					    	$projections[$player_id]['hbp_steamer'] = ($hbp / $pa) * 4.25;
					    	$projections[$player_id]['singles_steamer'] = ($singles / $pa) * 4.25;
					    	$projections[$player_id]['doubles_steamer'] = ($doubles / $pa) * 4.25 * 2;
					    	$projections[$player_id]['triples_steamer'] = ($triples / $pa) * 4.25 * 3;
					    	$projections[$player_id]['hr_steamer'] = ($hr / $pa) * 4.25 * 4;

					    	$projections[$player_id]['rbi_steamer'] = ($rbi / $pa) * 4.25;
					    	$projections[$player_id]['runs_steamer'] = ($runs / $pa) * 4.25;

					    	$projections[$player_id]['sb_steamer'] = ($sb / $pa) * 4.25 * 2;

					    	$projections[$player_id]['outs_steamer'] = ($outs / $pa) * 4.25 * -0.25;

					    	$total = 0;
					    	foreach ($projections[$player_id] as $key => $value) {
					    		if ((strpos($key,'steamer') !== false)) {
					    			$total += $value;
					    		}
					    	}

							$projections[$player_id]['total_steamer'] = $total;				    		
				    	}
					}

				    $row++;
				}
			}
		} else {
			return 'The Steamer csv file is missing.';
		}

		foreach ($projections as $key => &$value) {
			if (isset($value['total_zips']) AND isset($value['total_steamer'])) {
				$value['total_final'] = ($value['total_zips'] + $value['total_steamer']) / 2;
				continue;
			}

			if (isset($value['total_zips'])) {
				$value['total_final'] = $value['total_zips'];
				continue;
			}

			if (isset($value['total_steamer'])) {
				$value['total_final'] = $value['total_steamer'];
				continue;
			}
		}

		unset($value);

		foreach ($projections as $key => &$value) {
			$value['total_final'] = round($value['total_final'], 2);
			$value['total_final'] = number_format($value['total_final'], 2);
		}

		unset($value);

		return $projections;
	}
}