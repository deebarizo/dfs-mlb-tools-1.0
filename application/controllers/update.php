<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');

		date_default_timezone_set('America/Chicago');

		$this->today_year = date('Y');
	}

	public function fd() {
		$data['page_type'] = 'Update';
		$data['page_title'] = 'Update - DFS MLB Tools';
		$data['subhead'] = 'Update (FD Salaries)';

		$today_year = $this->today_year;

		$this->form_validation->set_rules('url', 'URL', 'required|trim');

		$this->form_validation->set_error_delimiters('<br /><span style="color:red" class="error">', '</span>');

		if ($this->form_validation->run() == FALSE) { // validation hasn't been passed
			$data['message'] = 'Form validation error.';
		} else {
			$form_data = array(
							'url' => set_value('url')
						);

			$this->load->model('scraping_model');
			$data['message'] = $this->scraping_model->scrape_fd_salaries($form_data, $today_year);
		}

		$this->load->view('templates/header', $data);
		$this->load->view('update_fd', $data);
		$this->load->view('templates/footer');
	}
}