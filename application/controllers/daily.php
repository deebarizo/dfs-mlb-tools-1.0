<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function fd($date = 'empty', $time = 'empty') {
		if ($date == 'empty' AND $time == 'empty') {
			$data['page_type'] = 'Recent Daily FD Leagues';
			$data['page_title'] = 'Recent Daily FD Leagues';
			$data['subhead'] = 'Recent Daily FD Leagues';

			$sql = 'SELECT `date`, `time`
					FROM league
					ORDER BY `date` DESC, `time` DESC
					LIMIT 5';
			$s = $this->db->conn_id->prepare($sql);
			$s->bindValue(':date', $date);
			$s->bindValue(':time', $time);
			$s->execute(); 

			$data['league'] = $s->fetchAll(PDO::FETCH_ASSOC);

			foreach ($data['league'] as $key => &$value) {
				$value['capitalized_time'] = $this->capitalize_time($value['time']);
			}

			unset($value);

			# echo '<pre>';
			# var_dump($league);
			# echo '</pre>'; exit();

			$this->load->view('templates/header', $data);
			$this->load->view('daily_fd', $data);
			$this->load->view('templates/footer');

			return false;
		}

		$capitalized_time = $this->capitalize_time($time);

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

			$data['fstats_fd'] = $s->fetchAll(PDO::FETCH_ASSOC);

			$sql = 'SELECT * FROM `fstats_fd` WHERE `league_id` = :league_id AND top_play_index IS NOT NULL';
			$s = $this->db->conn_id->prepare($sql);
			$s->bindValue(':league_id', $league_id);
			$s->execute(); 	

			$data['top_plays'] = $s->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$data['error'] = "The FD salaries are missing.";
		}		

		$this->load->view('templates/header', $data);
		$this->load->view('daily_fd_salaries', $data);
		$this->load->view('templates/footer');
	}

	public function update_top_plays($league_id) {
		$top_plays = $this->input->post("topPlays");

		$sql = 'UPDATE `fstats_fd` SET `top_play_index` = NULL WHERE league_id = :league_id';
		$s = $this->db->conn_id->prepare($sql);
		$s->bindValue(':league_id', $league_id);
		$s->execute(); 	

		if ($top_plays != "empty") {
			foreach ($top_plays as $key => $value) {
				$sql = 'UPDATE fstats_fd 
						SET top_play_index = :top_play_index 
						WHERE league_id = :league_id
							AND name = :name
							AND salary = :salary';
				$s = $this->db->conn_id->prepare($sql);
				$s->bindValue(':top_play_index', $value['dataIndex']);
				$s->bindValue(':league_id', $league_id);
				$s->bindValue(':name', $value['name']);
				$s->bindValue(':salary', $value['salary']);
				$s->execute(); 				
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
		}
	}
}