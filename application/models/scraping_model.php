<?php
class scraping_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->database();
	}

	public function scrape_fd_salaries($form_data, $today_year) {
		$url = $form_data['url'];

		$this->load->helper('phpquery');

		$html = phpQuery::newDocumentFileHTML($url);

		$h1_tag_with_date = $html->find('span[class=sport-icon]')->parent()->text();

		$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w$)/", "$2", $h1_tag_with_date);

		if ($month_and_day == $h1_tag_with_date) {
			$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w\s\(\w+\))/", "$2", $h1_tag_with_date);
		}

		$date = date('Y-m-d', strtotime($month_and_day.', '.$today_year));

		$sql = 'SELECT `date` FROM `fstats_fd` WHERE `date` = :date';
		$s = $this->db->conn_id->prepare($sql);
		$s->bindValue(':date', $date);
		$s->execute(); 	

		$result = $s->fetchAll(PDO::FETCH_COLUMN);	

		if (empty($result)) {
			$result = $html->find('tr[data-role=player]');
			$num_players = count($result);

			for ($i = 0; $i < $num_players; $i++) { 
				$fstats_fd[$i]['name'] = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(1)')->text();
					$fstats_fd[$i]['name'] = preg_replace("/DL$/", "", $fstats_fd[$i]['name']);
					$fstats_fd[$i]['name'] = preg_replace("/P$/", "", $fstats_fd[$i]['name']);
				$fstats_fd[$i]['team'] = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(4)')->find('b')->text();
				$fstats_fd[$i]['position'] = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(0)')->text();
				
				$salary = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(5)')->text();
				$salary = preg_replace("/\\$/", "", $salary);
				$salary = preg_replace("/,/", "", $salary);
				$fstats_fd[$i]['salary'] = $salary; 

				$opponent = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(4)')->text();
				$opponent = preg_replace("/@/", "", $opponent);
				$opponent = preg_replace("/".$fstats_fd[$i]['team']."/", "", $opponent);
				$fstats_fd[$i]['opponent'] = $opponent; 

				$fstats_fd[$i]['num_games'] = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(3)')->text();
				$fstats_fd[$i]['fppg'] = $html->find('tr[data-role=player]:eq('.$i.')')->find('td:eq(2)')->text();
			}

			# echo '<pre>';
			# var_dump($h1_tag_with_date);
			# var_dump($month_and_day);
			# var_dump($date);
			# var_dump($fstats_fd);
			# echo '</pre>'; exit();	

			foreach ($fstats_fd as $key => $value) {
				$sql = 'INSERT INTO `fstats_fd`(`name`, 
												`team`, 
												`position`,
												`salary`,
												`opponent`,
												`num_games`,
												`fppg`,
												`date`) 
						VALUES (:name, 
								:team, 
								:position,
								:salary,
								:opponent,
								:num_games,
								:fppg,
								:date)'; 
				$s = $this->db->conn_id->prepare($sql);
				$s->bindValue(':name', $value['name']);
				$s->bindValue(':team', $value['team']);
				$s->bindValue(':position', $value['position']);
				$s->bindValue(':salary', $value['salary']);
				$s->bindValue(':opponent', $value['opponent']);
				$s->bindValue(':num_games', $value['num_games']);
				$s->bindValue(':fppg', $value['fppg']);
				$s->bindValue(':date', $date);
				$s->execute(); 
			}				

			return 'Success: The FD salaries for this date were scraped.';
		} else {
			return 'Error: The FD salaries for this date are already in the database.';
		}	
	}
}