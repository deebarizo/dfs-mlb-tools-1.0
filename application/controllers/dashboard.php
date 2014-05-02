<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->database();

		$this->load->library('mod_name');
	}

	public function fd($date = 'empty', $time = 'empty') {
		$capitalized_time = $this->capitalize_time($time);

		$data['page_type'] = 'Dashboard';
		$data['page_title'] = 'Dashboard - '.$date.' - DFS MLB Tools';
		$data['subhead'] = 'Dashboard FD - '.$date.' - '.$capitalized_time;	

		$this->load->model('projections_model');
		$pitcher_stats = $this->projections_model->get_fd_pitcher_stats($date);	

		$this->load->model('scraping_model');
		$rotowire_lineups = $this->scraping_model->scrape_rotowire_lineups($date, $time);

		if (is_array($pitcher_stats) == false) {
			$data['error'] = $pitcher_stats;

			$this->load->view('templates/header', $data);
			$this->load->view('dashboard_fd', $data);
			$this->load->view('templates/footer');

			return false;
		}

		$this->load->model('salaries_model');
		$salaries = $this->salaries_model->get_fd_salaries($date, $time);

		if (isset($salaries['fstats_fd'])) {
			$fstats_fd = $salaries['fstats_fd'];
		} else { 
			$data['error'] = $salaries;

			$this->load->view('templates/header', $data);
			$this->load->view('dashboard_fd', $data);
			$this->load->view('templates/footer');

			return false;
		}	

		$batters = $this->remove_position($fstats_fd, 'pitcher');

		/* echo '<pre>';
		echo "Batters ";
		var_dump($batters);
		echo "Rotowire Lineups ";
		var_dump($rotowire_lineups);
		echo "Pitcher Stats ";
		var_dump($pitcher_stats);
		echo '</pre>'; exit(); */

		$batters = $this->add_starting_pitchers($batters, $rotowire_lineups, $pitcher_stats);

		$batter_projections = $this->projections_model->generate_fd_batter_projections($date, $batters);

		if (is_array($batter_projections)) {
			$batters = $this->calculate_vr($batters, $batter_projections);
			$batters = $this->lineup_check($batters, $rotowire_lineups);

			# echo '<pre>';
			# var_dump($batters);
			# echo '</pre>'; exit();

			$data['batters'] = $batters;

			$this->load->view('templates/header', $data);
			$this->load->view('dashboard_fd', $data);
			$this->load->view('templates/footer');

			return false;
		} else { 
			$data['error'] = $batter_projections;

			$this->load->view('templates/header', $data);
			$this->load->view('dashboard_fd', $data);
			$this->load->view('templates/footer');

			return false;
		}
	}

	public function lineup_check($batters, $rotowire_lineups) {
		foreach ($batters as $key => &$batter) {
			foreach ($rotowire_lineups['batters'] as $lineup) {
				if ($batter['name'] == $lineup['name'] AND $batter['team'] == $lineup['team']) {
					$batter['batting_order'] = $lineup['batting_order'];

					$batter['hand'] = $lineup['hand'];

					break;
				}
			}

			if (isset($batter['batting_order']) == false) {
				$batter['batting_order'] = 0;
			}
		}

		unset($batter);

		# echo '<pre>';
		# var_dump($batters);
		# echo '</pre>'; exit();

		return $batters;
	}

	public function add_starting_pitchers($salaries, $rotowire_lineups, $pitcher_stats) {
		if (empty($salaries)) {
			return $salaries;
		}

		foreach ($salaries as $key => &$salary) {
			foreach ($rotowire_lineups['pitchers'] as $pitcher) {
				if ($salary['opponent'] == $pitcher['team']) {
					$salary['opponent_pitcher'] = $pitcher['name'];
					$salary['opponent_hand'] = $pitcher['hand'];

					break;
				}
			}

			if (isset($salary['opponent_pitcher']) == false) {
				unset($salaries[$key]);
			}
		}

		unset($salary);

		foreach ($salaries as $key => &$salary) {
			foreach ($pitcher_stats as $pitcher) {
				$salary['opponent_pitcher'] = $this->mod_name->from_fd_to_projections($salary['opponent_pitcher']);
				
				if ($salary['opponent_pitcher'] == $pitcher['name']) {
					$salary['opponent_era'] = $pitcher['era_final'];

					break;
				}
			}
		}

		unset($salary);

		return $salaries;
	}

	public function calculate_vr($salaries, $projections) {
		if (empty($salaries)) {
			return $salaries;
		}

		foreach ($salaries as $key => &$salary) {
			foreach ($projections as $projection) {
				if ($salary['name'] == $projection['name']) {
					$salary['projection'] = $projection['total_final'];

					$vr = $projection['total_final'] / ($salary['salary'] / 1000);
					$vr = round($vr, 2);
					$salary['vr'] = number_format($vr, 2);

					break;
				}				
			}
		}

		unset($salary);

		return $salaries;
	}

	public function remove_position($salaries, $position) {
		if ($position == 'pitcher') {
			foreach ($salaries as $key => $value) {
				if ($value['position'] != 'P') {
					$batters[] = $value;
				}
			}

			if (isset($batters)) {
				return $batters;
			} else {
				return array();
			}		
		}

		if ($position == 'batter') {
			foreach ($salaries as $key => $value) {
				if ($value['position'] == 'P') {
					$pitchers[] = $value;
				}
			}

			if (isset($pitchers)) {
				return $pitchers;
			} else {
				return array();
			}		
		}	
	}

	public function capitalize_time($time) {
		switch ($time) {
			case 'all-day':
				return 'All Day';
			case 'early':
				return 'Early';
			case 'late':
				return 'Late';
			case 'later':
				return 'Later';
		}
	}
}