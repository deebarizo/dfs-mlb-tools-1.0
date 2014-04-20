<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mod_Team_Abbr {
	public function from_rotowire_lineup_to_fd($team) {
		switch ($team) {
		    case 'NY-N':
		        return 'NYM';
		    case 'NY-A':
		        return 'NYY';
		    case 'TB':
		        return 'TAM';
		    case 'CHI-A':
		        return 'CWS';
		    case 'AZ':
		        return 'ARI';
		    case 'LA':
		        return 'LOS';
		    case 'SF':
		        return 'SFG';
		    case 'SD':
		        return 'SDP';
		}

		return $team;
	}
}