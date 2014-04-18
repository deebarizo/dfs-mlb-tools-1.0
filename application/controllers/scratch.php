<?php 

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