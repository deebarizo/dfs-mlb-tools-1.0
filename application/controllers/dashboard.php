<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function fd($date = 'empty', $time = 'empty') {
		$capitalized_time = $this->capitalize_time($time);

		$data['page_type'] = 'Dashboard';
		$data['page_title'] = 'Dashboard - '.$date.' - DFS MLB Tools';
		$data['subhead'] = 'Dashboard FD - '.$date.' - '.$capitalized_time;	

		$this->load->model('projections_model');
		$batter_projections = $this->projections_model->generate_fd_batter_projections($date);
		$pitcher_stats = $this->projections_model->get_fd_pitcher_stats($date);	

		if (is_array($batter_projections)) {
			$this->load->model('salaries_model');
			$salaries = $this->salaries_model->get_fd_salaries($date, $time);

			if (isset($salaries['fstats_fd'])) {
				$fstats_fd = $salaries['fstats_fd'];
				$top_plays = $salaries['top_plays'];
			} else { 
				$data['error'] = $salaries;

				$this->load->view('templates/header', $data);
				$this->load->view('dashboard_fd', $data);
				$this->load->view('templates/footer');

				return false;
			}	

			$batters = $this->remove_position($fstats_fd, 'pitcher');
			$batters_top_plays = $this->remove_position($top_plays, 'pitcher');

			$batters = $this->calculate_vr($batters, $batter_projections);
			$batters_top_plays = $this->calculate_vr($batters_top_plays, $batter_projections);

			$this->load->model('scraping_model');
			$rotowire_lineups = $this->scraping_model->scrape_rotowire_lineups();

			$batters = $this->add_starting_pitchers($batters, $rotowire_lineups, $pitcher_stats);
			$batters_top_plays = $this->add_starting_pitchers($batters_top_plays, $rotowire_lineups, $pitcher_stats);

			$data['batters'] = $batters;
			$data['batters_top_plays'] = $batters_top_plays;

			# echo '<pre>';
			# var_dump($batters);
			# echo '</pre>'; exit();

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

	public function add_starting_pitchers($salaries, $rotowire_lineups, $pitcher_stats) {
		if (empty($salaries)) {
			return $salaries;
		}

		foreach ($salaries as $key => &$salary) {
			foreach ($rotowire_lineups['pitchers'] as $pitcher) {
				if ($salary['opponent'] == $pitcher['team']) {
					$salary['opponent_pitcher'] = $pitcher['name'];

					break;
				}				
			}
		}

		unset($salary);

		foreach ($salaries as $key => &$salary) {
			foreach ($pitcher_stats as $pitcher) {
				if ($salary['opponent_pitcher'] == $pitcher['name']) {
					$salary['opponent_era'] = $pitcher['era_final'];

					break;
				}
			}
		}

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