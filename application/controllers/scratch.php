<?php

$projections[$player_id]['bb_steamer'] = $this->calculations->stat_projection_fd($bb, $games, $pa, $era_mod['bb'], 'bb');
$projections[$player_id]['hbp_steamer'] = $hbp / $games;
$projections[$player_id]['singles_steamer'] = $this->calculations->stat_projection_fd($singles, $games, $pa,  $era_mod['singles'], 'singles');
$projections[$player_id]['doubles_steamer'] = $this->calculations->stat_projection_fd($doubles, $games, $pa,  $era_mod['doubles'], 'doubles');
$projections[$player_id]['triples_steamer'] = $this->calculations->stat_projection_fd($triples, $games, $pa,  $era_mod['triples'], 'triples');
$projections[$player_id]['hr_steamer'] = $this->calculations->stat_projection_fd($hr, $games, $pa,  $era_mod['hr'], 'hr');

$projections[$player_id]['rbi_steamer'] = $this->calculations->stat_projection_fd($rbi, $games, $pa,  $era_mod['rbi'], 'rbi');
$projections[$player_id]['runs_steamer'] = $this->calculations->stat_projection_fd($runs, $games, $pa,  $era_mod['runs'], 'runs');

$projections[$player_id]['sb_steamer'] = ($sb / $games) * 2;

$projections[$player_id]['outs_steamer'] = $this->calculations->stat_projection_fd($outs, $games, $pa,  $era_mod['outs'], 'outs');

$projections[$player_id]['bb_steamer'] = ($bb / $pa) * 4.25; // http://espn.go.com/fantasy/baseball/story/_/page/mlbdk2k13_lineuppositions/jose-altuve-erick-aybar-giancarlo-stanton-see-fantasy-values-affected-most-lineup-position
$projections[$player_id]['hbp_steamer'] = ($hbp / $pa) * 4.25;
$projections[$player_id]['singles_steamer'] = ($singles / $pa) * 4.25;
$projections[$player_id]['doubles_steamer'] = ($doubles / $pa) * 4.25 * 2;
$projections[$player_id]['triples_steamer'] = ($triples / $pa) * 4.25 * 3;
$projections[$player_id]['hr_steamer'] = ($hr / $pa) * 4.25 * 4;

$projections[$player_id]['rbi_steamer'] = ($rbi / $pa) * 4.25;
$projections[$player_id]['runs_steamer'] = ($runs / $pa) * 4.25;

$projections[$player_id]['sb_steamer'] = ($sb / $pa) * 4.25 * 2;

$projections[$player_id]['outs_steamer'] = ($outs / $pa) * 4.25 * -0.25;