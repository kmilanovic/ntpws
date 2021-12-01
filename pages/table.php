<?php 

	$leagueTable = file_get_contents("https://api.footystats.org/league-tables?key=b42b53430800c32734c30c6965e6ff689ece089a51381a586f09d84d35cd3ffa&league_id=6135");
	$leagueTable = json_decode($leagueTable, true);
	$leagueTable = $leagueTable['data']['league_table'];

	$limit = 20;
	$counter = 0;
?>
<div class="container">
<h1 class="tableName">Premier League 2021/2022</h1>
<table id="table">
		<tr>
			<th>Position</th>
			<th>Club</th>
			<th>Played</th>
			<th>Won</th>
			<th>Drawn</th>
			<th>Lost</th>
			<th>GF</th>
			<th>GA</th>
			<th>GD</th>
			<th>Points</th>
		</tr>
		<?php foreach ($leagueTable as $key => $team): 
			$season_conceded_home = $team['seasonConceded_home'];
			$season_conceded_away = $team['seasonConceded_away'];
			$season_conceded = $season_conceded_home + $season_conceded_away; ?>
		<tr>
			<?php if($team['name'] == 'Arsenal FC'){
				echo '<td style="color:#f00000">'.$team['position'].'.</td>';
				echo '<td style="color:#f00000">'.$team['name'].'</td>';
				echo '<td style="color:#f00000">'.$team['matchesPlayed'].'</td>';
				echo '<td style="color:#f00000">'.$team['seasonWins_overall'].'</td>';
				echo '<td style="color:#f00000">'.$team['seasonDraws_overall'].'</td>';
				echo '<td style="color:#f00000">'.$team['seasonLosses_overall'].'</td>';
				echo '<td style="color:#f00000">'.$team['seasonGoals'].'</td>';
				echo '<td style="color:#f00000">'.$season_conceded.'</td>';
				echo '<td style="color:#f00000">'.$team['seasonGoalDifference'].'</td>';
				echo '<td style="color:#f00000">'.$team['points'].'</td>';
			} else{
				echo '<td>'.$team['position'].'.</td>';
				echo '<td>'.$team['name'].'</td>';
				echo '<td>'.$team['matchesPlayed'].'</td>';
				echo '<td>'.$team['seasonWins_overall'].'</td>';
				echo '<td>'.$team['seasonDraws_overall'].'</td>';
				echo '<td>'.$team['seasonLosses_overall'].'</td>';
				echo '<td>'.$team['seasonGoals'].'</td>';
				echo '<td>'.$season_conceded.'</td>';
				echo '<td>'.$team['seasonGoalDifference'].'</td>';
				echo '<td>'.$team['points'].'</td>';
			}
			?>
		</tr>
		<?php endforeach ?>
</table>
</div>
