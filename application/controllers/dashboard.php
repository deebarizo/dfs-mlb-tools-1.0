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
		$data['subhead'] = 'Daily FD - '.$date.' - '.$capitalized_time;	

		$this->load->model('projections_model');
		$projections = $this->projections_model->generate_fd_projections($date);

		if (is_array($projections)) {
			$this->load->model('salaries_model');
			$salaries = $this->salaries_model->get_fd_salaries($date, $time);

			if (isset($salaries['fstats_fd'])) {
				$fstats_fd = $salaries['fstats_fd'];
				$top_plays = $salaries['top_plays'];
			} else { 
				$data['error'] = $salaries;

				// views and return false
			}	

			$batters = $this->remove_pitchers($fstats_fd);
			$batters_top_plays = $this->remove_pitchers($top_plays);

			$batters = $this->calculate_vr($batters, $projections);
			$batters_top_plays = $this->calculate_vr($batters_top_plays, $projections);

			$data['batters'] = $batters;
			$data['batters_top_plays'] = $batters_top_plays;

			# echo '<pre>';
			# var_dump($batters);
			# var_dump($batters_top_plays);
			# echo '</pre>'; exit();

			$this->load->view('templates/header', $data);
			$this->load->view('dashboard_fd', $data);
			$this->load->view('templates/footer');

			return false;
		} else { 
			$data['error'] = $projections;

			// views and return false
		}
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
				}				
			}

			/*
			if (isset($salary['vr']) == false) {
				echo '<pre>';
				var_dump($salary);
				echo '</pre>'; exit();
			}
			*/
		}

		unset($salary);

		return $salaries;
	}

	public function remove_pitchers($salaries) {
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