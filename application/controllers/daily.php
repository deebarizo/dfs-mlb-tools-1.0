<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->database();

		$sql = 'SELECT DISTINCT `date` FROM `fstats_fd` ORDER BY `date` DESC LIMIT 1';
		$s = $this->db->conn_id->prepare($sql);
		$s->execute(); 

		$result = $s->fetchAll(PDO::FETCH_COLUMN);
		$this->latest_date_in_db = $result[0];
	}

	public function fd($date = 'empty') {
		if ($date == 'empty')	{
			$date = $this->latest_date_in_db;
		}

		$data['page_type'] = 'Daily';
		$data['page_title'] = 'Daily - '.$date.' - DFS MLB Tools';
		$data['subhead'] = 'Daily FD - '.$date;

		$sql = 'SELECT * FROM `fstats_fd` WHERE `date` = :date';
		$s = $this->db->conn_id->prepare($sql);
		$s->bindValue(':date', $date);
		$s->execute(); 

		$fstats_fd = $s->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($fstats_fd)) {
			$data['fstats_fd'] = $fstats_fd;
		} else {
			$data['error'] = "The FD salaries are missing.";
		}		

		$this->load->view('templates/header', $data);
		$this->load->view('daily_fd', $data);
		$this->load->view('templates/footer');
	}
}