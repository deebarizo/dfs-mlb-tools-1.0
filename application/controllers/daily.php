<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function fd($date = 'empty', $time = 'empty') {
		if ($date == 'empty' AND $time == 'empty') {
			echo 'bob';

			return false;
		}

		switch ($time) {
			case 'all-day':
				$capitalized_time = 'All Day';
				break;
			case 'early':
				$capitalized_time = 'Early';
				break;
			case 'late':
				$capitalized_time = 'Late';
				break;
		}

		$data['page_type'] = 'Daily';
		$data['page_title'] = 'Daily - '.$date.' - DFS MLB Tools';
		$data['subhead'] = 'Daily FD - '.$date.' - '.$capitalized_time;

		$sql = 'SELECT `id` FROM `league` WHERE `date` = :date AND `time` = :time';
		$s = $this->db->conn_id->prepare($sql);
		$s->bindValue(':date', $date);
		$s->bindValue(':time', $time);
		$s->execute(); 

		$result = $s->fetchAll(PDO::FETCH_COLUMN, 0);

		if (!empty($result)) {
			$league_id = $result[0];

			$sql = 'SELECT * FROM `fstats_fd` WHERE `league_id` = :league_id';
			$s = $this->db->conn_id->prepare($sql);
			$s->bindValue(':league_id', $league_id);
			$s->execute(); 	

			$fstats_fd = $s->fetchAll(PDO::FETCH_ASSOC);

			$data['fstats_fd'] = $fstats_fd;
		} else {
			$data['error'] = "The FD salaries are missing.";
		}		

		$this->load->view('templates/header', $data);
		$this->load->view('daily_fd_salaries', $data);
		$this->load->view('templates/footer');
	}
}