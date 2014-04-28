<?php

		for ($i = 0; $i < $num_lineups; $i++) { 
			for ($n = 0; $n < 9; $n++) { 
				$rotowire_lineups['batters'][$i]['name'] = $html->find('div[class*=dlineups-pitchers]')->parent()->prev('div[class*=dlineups-half')->prev('div[class*=dlineups-half')->find('div a:eq('.$n.')')->text();

				$rotowire_lineups['batters'][$i]['team'] = $team;

				$raw_data= $html->find('div[class*=dlineups-pitchers]')->parent()->prev('div[class*=dlineups-half')->prev('div[class*=dlineups-half')->find('div:eq('.$n.') a')->text();

				$rotowire_lineups['batters'][$i]['batting_order'] = $n;
			}			
		}