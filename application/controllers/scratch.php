<?php

$projections[$player_id]['bb_zips'] = ($bb / $games) + (($bb / $games) * $era_mod['bb']);

$projections[$player_id]['singles_zips'] = ($singles / $games) + (($singles / $games) * $era_mod['singles']);
$projections[$player_id]['doubles_zips'] = (($doubles / $games) + (($doubles / $games) * $era_mod['doubles'])) * 2;
$projections[$player_id]['triples_zips'] = (($triples / $games) + (($triples / $games) * $era_mod['triples'])) * 3;
$projections[$player_id]['hr_zips'] = (($hr / $games) + (($hr / $games) * $era_mod['hr'])) * 4;

$projections[$player_id]['rbi_zips'] = ($rbi / $games) + (($rbi / $games) * $era_mod['rbi']);
$projections[$player_id]['runs_zips'] = ($runs / $games) + (($runs / $games) * $era_mod['runs']);

$projections[$player_id]['sb_zips'] = ($sb / $games) * 2;

$projections[$player_id]['outs_zips'] = (($outs / $games) + (($outs / $games) * $era_mod['outs'])) * -0.25;