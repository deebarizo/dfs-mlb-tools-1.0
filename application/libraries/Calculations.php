<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Calculations {
	public function calculate_correlation($array, $x_var, $y_var) {


		return $correlation;
	}

	public function stat_projection_fd($raw_projection, $games, $pa, $era_mod, $stat) {
		if ($games != 'NA' AND $pa == 'NA') {
			switch ($stat) {
			    case 'bb':
			    	$answer = ($raw_projection / $games) + (($raw_projection / $games) * $era_mod);
			    	return $answer;
			    case 'singles':
			    	$answer = ($raw_projection / $games) + (($raw_projection / $games) * $era_mod);
			    	return $answer;
			    case 'doubles':
			    	$answer = (($raw_projection / $games) + (($raw_projection / $games) * $era_mod)) * 2;
			    	return $answer;
			    case 'triples':
			    	$answer = (($raw_projection / $games) + (($raw_projection / $games) * $era_mod)) * 3;
			    	return $answer;
			    case 'hr':
			    	$answer = (($raw_projection / $games) + (($raw_projection / $games) * $era_mod)) * 4;
			    	return $answer;
			    case 'rbi':
			    	$answer = ($raw_projection / $games) + (($raw_projection / $games) * $era_mod);
			    	return $answer;
			    case 'runs':
			    	$answer = ($raw_projection / $games) + (($raw_projection / $games) * $era_mod);
			    	return $answer;
			    case 'outs':
			    	$answer = (($raw_projection / $games) + (($raw_projection / $games) * $era_mod)) * -0.25;
			    	return $answer;
			}			
		} else if ($games == 'NA' AND $pa != 'NA') {
			switch ($stat) {
			    case 'bb':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 4.25;
			    	return $answer;
			    case 'singles':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 4.25;
			    	return $answer;
			    case 'doubles':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 2 * 4.25;
			    	return $answer;
			    case 'triples':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 3 * 4.25;
			    	return $answer;
			    case 'hr':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 4 * 4.25;
			    	return $answer;
			    case 'rbi':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 4.25;
			    	return $answer;
			    case 'runs':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * 4.25;
			    	return $answer;
			    case 'outs':
			    	$answer = (($raw_projection / $pa) + (($raw_projection / $pa) * $era_mod)) * -0.25 * 4.25;
			    	return $answer;
			}	
		}
	}

	public function era_mod($era) {
		if ($era < 3.25) {
			$era_mod = array(
				'singles' => -0.09,
				'doubles' => -0.14,
				'triples' => -0.04,
				'hr' => -0.24,
				'bb' => -0.23,
				'rbi' => -0.25,
				'runs' => -0.23,
				'outs' => 0.03
			);
		}

		if ($era >= 3.25 AND $era < 3.50) {
			$era_mod = array(
				'singles' => -0.06,
				'doubles' => -0.13,
				'triples' => -0.13,
				'hr' => -0.15,
				'bb' => -0.15,
				'rbi' => -0.16,
				'runs' => -0.17,
				'outs' => 0.02
			);
		}

		if ($era >= 3.50 AND $era < 3.75) {
			$era_mod = array(
				'singles' => -0.02,
				'doubles' => -0.08,
				'triples' => -0.11,
				'hr' => -0.12,
				'bb' => -0.11,
				'rbi' => -0.12,
				'runs' => -0.12,
				'outs' => 0.01
			);
		}

		if ($era >= 3.75 AND $era < 4.00) {
			$era_mod = array(
				'singles' => -0.01,
				'doubles' => -0.04,
				'triples' => -0.02,
				'hr' => -0.09,
				'bb' => -0.09,
				'rbi' => -0.07,
				'runs' => -0.08,
				'outs' => 0.01
			);
		}

		if ($era >= 4.00 AND $era < 4.25) {
			$era_mod = array(
				'singles' => -0.02,
				'doubles' => -0.02,
				'triples' => 0.00,
				'hr' => -0.04,
				'bb' => -0.03,
				'rbi' => -0.04,
				'runs' => -0.04,
				'outs' => 0.00
			);
		}

		if ($era >= 4.25 AND $era < 4.50) {
			$era_mod = array(
				'singles' => 0.01,
				'doubles' => 0.00,
				'triples' => -0.05,
				'hr' => 0.01,
				'bb' => -0.03,
				'rbi' => 0.00,
				'runs' => 0.00,
				'outs' => 0.00
			);
		}

		if ($era >= 4.50 AND $era < 4.75) {
			$era_mod = array(
				'singles' => 0.02,
				'doubles' => 0.03,
				'triples' => 0.07,
				'hr' => 0.05,
				'bb' => 0.03,
				'rbi' => 0.05,
				'runs' => 0.05,
				'outs' => 0.00
			);
		}

		if ($era >= 4.75 AND $era < 5.00) {
			$era_mod = array(
				'singles' => 0.03,
				'doubles' => 0.06,
				'triples' => -0.02,
				'hr' => 0.08,
				'bb' => 0.07,
				'rbi' => 0.08,
				'runs' => 0.08,
				'outs' => -0.01
			);
		}

		if ($era >= 5.00) {
			$era_mod = array(
				'singles' => 0.02,
				'doubles' => 0.08,
				'triples' => 0.10,
				'hr' => 0.15,
				'bb' => 0.21,
				'rbi' => 0.16,
				'runs' => 0.15,
				'outs' => -0.01
			);
		}

		return $era_mod;
	}
}