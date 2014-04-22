<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mod_Name {
	public function from_fd_to_projections($name) {
		switch ($name) {
		    case 'Jorge De La Rosa':
	        	return 'Jorge de la Rosa';
		}		

		return $name;
	}

	public function from_projections_to_fd($name) {
		switch ($name) {
		    case 'Travis d\'Arnaud':
	        	return 'Travis D\'Arnaud';
		}		

		return $name;
	}

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