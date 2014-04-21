<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Calculations {
	public function era_mod($era) {
		if ($era < 3.25) {
			$era_mod = array(
				'singles' => -0.09,
				'doubles' => -0.14,
				'triples' => -0.10,
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
				'triples' => -0.10,
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
				'triples' => -0.10,
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
				'hr' => -.09,
				'bb' => -.09,
				'rbi' => -.07,
				'runs' => -.08,
				'outs' => .01
			);
		}

		return $era_mod;
	}
}