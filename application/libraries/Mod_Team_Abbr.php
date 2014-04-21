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
		    case 'CHI-N':
		        return 'CHC';
		    case 'AZ':
		        return 'ARI';
		    case 'LA':
		        return 'LOS';
		    case 'ANA':
		        return 'LAA';
		    case 'SF':
		        return 'SFG';
		    case 'SD':
		        return 'SDP';
		    case 'KC':
		        return 'KAN';
		}

		return $team;
	}
}