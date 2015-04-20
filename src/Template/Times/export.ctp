<?php
echo "Datum;User;Customer;Task;Note;Start;Stop;Pause;Dauer\n";
foreach ($times as $time) {
	$line = $time['start']->format('Y-m-d') . ';';
	$line .= $time->user['name'] . ';';
	$line .= $time->customer['name'] . ';';
	$line .= str_replace(';', ',', $time['task']) . ';';
	$line .= str_replace(';', ',', $time['note']) . ';';
	$line .= $time['start']->format('Y-m-d H:i:s') . ';';
	$line .= $time['stop']->format('Y-m-d H:i:s') . ';';
	$line .= str_replace('.', ',', $time['break']) . ';'; //punkt nach komma wegen excel

	if (!$time['stop']) {
		$time['stop'] = new \Cake\I18n\Time(); // date('Y-m-d H:i:s');
	}
	$time['startsec'] = $time['start']->timestamp;
	$time['stopsec'] = $time['stop']->timestamp;

	$diff = ($time['stopsec'] - $time['startsec']) / 3600 - $time['break'];

	$line .= str_replace('.', ',', round($diff, 4)); //punkt nach komma wegen excel

	echo str_replace(["\r\n", "\r", "\n"], '', $line) . "\n";
}
?>