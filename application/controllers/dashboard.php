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
		$this->projections_model->generate_fd_projections($date);
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