<?php
class scraping_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->helper('phpquery');

		$this->load->database();

		$this->load->library('mod_name');
	}

	public function scrape_rotowire_lineups($date) {
		$html = phpQuery::newDocumentFileHTML('http://www.rotowire.com/baseball/daily_lineups.htm');

		$result = $html->find('div[class*=dlineups-pitchers] a');
		$num_teams = count($result);

		for ($i = 0; $i < $num_teams; $i++) { 
			$rotowire_lineups['pitchers'][$i]['name'] = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->text();
			
			$raw_data = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->parent()->text();
			$team = preg_replace('/(\w+)(.*)/', '$1', $raw_data);
			$team = $this->mod_name->from_rotowire_lineup_to_fd($team);
			$rotowire_lineups['pitchers'][$i]['team'] = $team;

			$raw_data = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->next('span')->text();
			$hand = preg_replace('/(.*)(\()(\w+)(\))/', '$3', $raw_data);
			$rotowire_lineups['pitchers'][$i]['hand'] = $hand;

			for ($n = 0; $n < 9; $n++) { 
				if (($i % 2) == 0) { // even (away team)
					$name = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->parent()->parent()->parent()->prev('div[class*=dlineups-half')->prev('div[class*=dlineups-half')->find('div a:eq('.$n.')')->text();
					if ($name != '') {
						$rotowire_lineups['batters'][$i.($n+1)]['name'] = $name;

						$rotowire_lineups['batters'][$i.($n+1)]['team'] = $team;

						$hand = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->parent()->parent()->parent()->prev('div[class*=dlineups-half')->prev('div[class*=dlineups-half')->find('div span:eq('.$n.')')->text();
						$rotowire_lineups['batters'][$i.($n+1)]['hand'] = preg_replace('/(.*)(\()(\w+)(\))/', '$3', $hand);
					} else {
						break;
					}
				} else { // odd (home team)
					$name = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->parent()->parent()->parent()->prev('div[class*=dlineups-half')->find('div a:eq('.$n.')')->text();
					if ($name != '') {
						$rotowire_lineups['batters'][$i.($n+1)]['name'] = $name;

						$rotowire_lineups['batters'][$i.($n+1)]['team'] = $team;

						$hand = $html->find('div[class*=dlineups-pitchers] a:eq('.$i.')')->parent()->parent()->parent()->prev('div[class*=dlineups-half')->find('div span:eq('.$n.')')->text();
						$rotowire_lineups['batters'][$i.($n+1)]['hand'] = preg_replace('/(.*)(\()(\w+)(\))/', '$3', $hand);
					} else {
						break;
					}
				}

				$rotowire_lineups['batters'][$i.($n+1)]['batting_order'] = $n + 1;
			}		
		}

		# echo '<pre>';
		# var_dump($rotowire_lineups);
		# echo '</pre>'; exit();

		return $rotowire_lineups;
	}

	public function scrape_fd_salaries($form_data, $today_year) {
		$url = $form_data['url'];
		$time = $form_data['league_time'];

		$html = phpQuery::newDocumentFileHTML($url);

		$h1_tag_with_date = $html->find('span[class=sport-icon]')->parent()->text();

		$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w$)/", "$2", $h1_tag_with_date);

		if ($month_and_day == $h1_tag_with_date) {
			$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w\s\(\w+\))/", "$2", $h1_tag_with_date);
		}

		if ($month_and_day == $h1_tag_with_date) {
			$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w\s\(Early Only\))/", "$2", $h1_tag_with_date);
		}

		if ($month_and_day == $h1_tag_with_date) {
			$month_and_day = preg_replace("/(.+)(\w\w\w\s\d+)(\w\w\s\(Late Afternoon\))/", "$2", $h1_tag_with_date);
		}

		$date = date('Y-m-d', strtotime($month_and_day.', '.$today_year));

		$sql = 'SELECT `date`, `time` FROM `league` WHERE `date` = :date AND `time` = :time';
		$s = $this->db->conn_id->prepare($sql);
		$s->bindValue(':date', $date);
		$s->bindValue(':time', $time);
		$s->execute(); 	

		$result = $s->fetchAll(PDO::FETCH_COLUMN);	

		if (empty($result)) {
			$sql = 'INSERT INTO `league`(`date`, `time`) VALUES (:date, :time)';
			$s = $this->db->conn_id->prepare($sql);
			$s->bindValue(':date', $date);
			$s->bindValue(':time', $time);
			$s->execute(); 

			$league_id = $this->db->conn_id->lastInsertId();

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
												`league_id`) 
						VALUES (:name, 
								:team, 
								:position,
								:salary,
								:opponent,
								:num_games,
								:fppg,
								:league_id)'; 
				$s = $this->db->conn_id->prepare($sql);
				$s->bindValue(':name', $value['name']);
				$s->bindValue(':team', $value['team']);
				$s->bindValue(':position', $value['position']);
				$s->bindValue(':salary', $value['salary']);
				$s->bindValue(':opponent', $value['opponent']);
				$s->bindValue(':num_games', $value['num_games']);
				$s->bindValue(':fppg', $value['fppg']);
				$s->bindValue(':league_id', $league_id);
				$s->execute(); 
			}				

			return 'Success: The FD salaries for this date were scraped.';
		} else {
			return 'Error: The FD salaries for this date are already in the database.';
		}	
	}
}