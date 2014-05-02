<?php
class projections_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->database();

		$this->load->library('calculations');
		$this->load->library('mod_name');
	}

	public function get_fd_pitcher_projections($date) {
		$csv_zips_file = 'files/projections/'.preg_replace('/-/', '', $date).'_zips_pitcher.csv';

		if (file_exists($csv_zips_file)) {
			if (($handle = fopen($csv_zips_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];

				    	$era = $csv_data[3];
				    	
				    	$player_id = $csv_data[17];

				    	$pitcher_stats[$player_id]['name'] = $name;
				    	$pitcher_stats[$player_id]['era_zips'] = $era;
					}

				    $row++;
				}
			}
		} else {
			return 'The Zips csv file for pitchers is missing.';
		}

		$csv_steamer_file = 'files/projections/'.preg_replace('/-/', '', $date).'_steamer_pitcher.csv';

		if (file_exists($csv_steamer_file)) {
			if (($handle = fopen($csv_steamer_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];

				    	$era = $csv_data[3];
				    	
				    	$player_id = $csv_data[18];

				    	$pitcher_stats[$player_id]['name'] = $name;
				    	$pitcher_stats[$player_id]['era_steamer'] = $era;
					}

				    $row++;
				}
			}
		} else {
			return 'The Steamer csv file for pitchers is missing.';
		}

		foreach ($pitcher_stats as $key => &$value) {
			if (isset($value['era_zips']) AND isset($value['era_steamer'])) {
				$value['era_final'] = ($value['era_zips'] + $value['era_steamer']) / 2;
				continue;
			}

			if (isset($value['era_zips'])) {
				$value['era_final'] = $value['era_zips'];
				continue;
			}

			if (isset($value['era_steamer'])) {
				$value['era_final'] = $value['era_steamer'];
				continue;
			}
		}

		unset($value);

		foreach ($pitcher_stats as $key => &$value) {
			$value['era_final'] = round($value['era_final'], 2);
			$value['era_final'] = number_format($value['era_final'], 2);
		}

		unset($value);

		return $pitcher_stats;
	}

	public function generate_fd_batter_projections($date, $batters) {
		$csv_zips_file = 'files/projections/'.preg_replace('/-/', '', $date).'_zips_batter.csv';

		if (file_exists($csv_zips_file)) {
			if (($handle = fopen($csv_zips_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];
				    	$name = $this->mod_name->from_projections_to_fd($name);

				    	foreach ($batters as $key => $batter) {
				    		if ($name == $batter['name']) {
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

						    	$woba = $csv_data[19];

						    	$player_id = $csv_data[23];

						    	$singles = $hits - $doubles - $triples - $hr;
						    	$outs = $ab - $hits;

						    	if (isset($batter['opponent_era'])) {
						    		$era_mod = $this->calculations->era_mod($batter['opponent_era']);

    						    	$projections[$player_id]['name'] = $name;
							    	$projections[$player_id]['games'] = $games;

							    	$pa = 'NA';

							    	$projections[$player_id]['bb_zips'] = $this->calculations->stat_projection_fd($bb, $games, $pa, $era_mod['bb'], 'bb');
							    	$projections[$player_id]['hbp_zips'] = $hbp / $games;
							    	$projections[$player_id]['singles_zips'] = $this->calculations->stat_projection_fd($singles, $games, $pa,  $era_mod['singles'], 'singles');
							    	$projections[$player_id]['doubles_zips'] = $this->calculations->stat_projection_fd($doubles, $games, $pa,  $era_mod['doubles'], 'doubles');
							    	$projections[$player_id]['triples_zips'] = $this->calculations->stat_projection_fd($triples, $games, $pa,  $era_mod['triples'], 'triples');
							    	$projections[$player_id]['hr_zips'] = $this->calculations->stat_projection_fd($hr, $games, $pa,  $era_mod['hr'], 'hr');
							    	$projections[$player_id]['rbi_zips'] = $this->calculations->stat_projection_fd($rbi, $games, $pa,  $era_mod['rbi'], 'rbi');
							    	$projections[$player_id]['runs_zips'] = $this->calculations->stat_projection_fd($runs, $games, $pa,  $era_mod['runs'], 'runs');

							    	$projections[$player_id]['sb_zips'] = ($sb / $games) * 2;

							    	$projections[$player_id]['outs_zips'] = $this->calculations->stat_projection_fd($outs, $games, $pa,  $era_mod['outs'], 'outs');

							    	$total = 0;
							    	foreach ($projections[$player_id] as $key => $value) {
							    		if (strpos($key,'zips') !== false AND $key != 'woba_zips') {
							    			$total += $value;
							    		}
							    	}

									$projections[$player_id]['total_zips'] = $total;

									$projections[$player_id]['total_wo_sb_zips'] = $projections[$player_id]['total_zips'] - $projections[$player_id]['sb_zips'];

									$projections[$player_id]['woba_zips'] = $woba;

					    			break;
						    	} else if ($batter['opponent_pitcher'] != NULL) {
							    	echo '<pre>Missing opponent pitcher:';
							    	var_dump($batter);
									var_dump($era_mod);
									echo '</pre>';						    		
						    	}
				    		}
				    	}
					}

				    $row++;
				}
			}
		} else {
			return 'The Zips csv file for batters is missing.';
		}

		$csv_steamer_file = 'files/projections/'.preg_replace('/-/', '', $date).'_steamer_batter.csv';

		if (file_exists($csv_steamer_file)) {
			if (($handle = fopen($csv_steamer_file, 'r')) !== false) {
				$row = 0;

				while (($csv_data = fgetcsv($handle, 5000, ',')) !== false) {
				    if ($row != 0) {
				    	$name = $csv_data[0];
				    	$name = $this->mod_name->from_projections_to_fd($name);

				    	foreach ($batters as $key => $batter) {
				    		$batter['name'] = $this->mod_name->from_fd_to_projections($batter['name']);

				    		if ($name == $batter['name']) {
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

						    	$woba = $csv_data[18];

						    	$player_id = $csv_data[22];

						    	$singles = $hits - $doubles - $triples - $hr;
						    	$outs = $ab - $hits;

						    	$era_mod = $this->calculations->era_mod($batter['opponent_era']);

						    	if (isset($batter['opponent_era']) == false) {
							    	echo '<pre>Missing opponent pitcher:';
							    	var_dump($batter);
									var_dump($era_mod);
									echo '</pre>';					    		
						    	}

						    	$games = 'NA'; 						    	
						    	$pa = $csv_data[1];

						    	$projections[$player_id]['name'] = $name;

						    	$projections[$player_id]['bb_steamer'] = $this->calculations->stat_projection_fd($bb, $games, $pa, $era_mod['bb'], 'bb'); // http://espn.go.com/fantasy/baseball/story/_/page/mlbdk2k13_lineuppositions/jose-altuve-erick-aybar-giancarlo-stanton-see-fantasy-values-affected-most-lineup-position
						    	$projections[$player_id]['hbp_steamer'] = ($hbp / $pa) * 4.25;
						    	$projections[$player_id]['singles_steamer'] = $this->calculations->stat_projection_fd($singles, $games, $pa,  $era_mod['singles'], 'singles');
						    	$projections[$player_id]['doubles_steamer'] = $this->calculations->stat_projection_fd($doubles, $games, $pa,  $era_mod['doubles'], 'doubles');
						    	$projections[$player_id]['triples_steamer'] = $this->calculations->stat_projection_fd($triples, $games, $pa,  $era_mod['triples'], 'triples');
						    	$projections[$player_id]['hr_steamer'] = $this->calculations->stat_projection_fd($hr, $games, $pa,  $era_mod['hr'], 'hr');

						    	$projections[$player_id]['rbi_steamer'] = $this->calculations->stat_projection_fd($rbi, $games, $pa,  $era_mod['rbi'], 'rbi');
						    	$projections[$player_id]['runs_steamer'] = $this->calculations->stat_projection_fd($runs, $games, $pa,  $era_mod['runs'], 'runs');

						    	$projections[$player_id]['sb_steamer'] = ($sb / $pa) * 4.25 * 2;

						    	$projections[$player_id]['outs_steamer'] = $this->calculations->stat_projection_fd($outs, $games, $pa,  $era_mod['outs'], 'outs');

						    	$total = 0;
						    	foreach ($projections[$player_id] as $key => $value) {
						    		if (strpos($key,'steamer') !== false AND $key != 'woba_zips') {
						    			$total += $value;
						    		}
						    	}

								$projections[$player_id]['total_steamer'] = $total;	

								$projections[$player_id]['total_wo_sb_steamer'] = $projections[$player_id]['total_steamer'] - $projections[$player_id]['sb_steamer'];			    		

								$projections[$player_id]['woba_steamer'] = $woba;

						    	break;
							}
						}
					}

				    $row++;
				}
			}
		} else {
			return 'The Steamer csv file for batters is missing.';
		}

		$avg_keys = array('total', 'total_wo_sb', 'woba');

		foreach ($projections as $key => &$value) {
			foreach ($avg_keys as $avg_key) {
				if (isset($value[$avg_key.'_zips']) AND isset($value[$avg_key.'_steamer'])) {
					$value[$avg_key.'_final'] = ($value[$avg_key.'_zips'] + $value[$avg_key.'_steamer']) / 2;
					continue;
				}

				if (isset($value[$avg_key.'_zips'])) {
					$value[$avg_key.'_final'] = $value[$avg_key.'_zips'];
					continue;
				}

				if (isset($value[$avg_key.'_steamer'])) {
					$value[$avg_key.'_final'] = $value[$avg_key.'_steamer'];
					continue;
				}
			}
		}	

		unset($value);

		# $correlation = $this->calculations->calculate_correlation($projections, 'total_wo_sb_final', 'woba_final');

    	# echo '<pre>';
    	# var_dump($projections);
		# echo '</pre>'; exit();

		return $projections;
	}
}