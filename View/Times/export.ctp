<?php
echo "Datum;User;Customer;Task;Note;Start;Stop;Pause;Dauer\n";
foreach ($times as $time) {
	$line = substr($time['Time']['start'], 0, 10) . ';';
	$line .= $time['User']['name'] . ';';
	$line .= $time['Customer']['name'] . ';';
	$line .= str_replace(';', ',', $time['Time']['task']) . ';';
	$line .= str_replace(';', ',', $time['Time']['note']) . ';';
	$line .= $time['Time']['start'] . ';';
	$line .= $time['Time']['stop'] . ';';
	$line .= str_replace('.', ',', $time['Time']['break']) . ';'; //punkt nach komma wegen excel

	if ($time['Time']['stop'] == '0000-00-00 00:00:00') {
		$time['Time']['stop'] = date('Y-m-d H:i:s');
	}
	$time['Time']['startsec'] = strtotime($time['Time']['start']);
	$time['Time']['stopsec'] = strtotime($time['Time']['stop']);

	$diff = ($time['Time']['stopsec'] - $time['Time']['startsec']) / 3600 - $time['Time']['break'];

	$line .= str_replace('.', ',', round($diff, 4)); //punkt nach komma wegen excel

	echo str_replace(["\r\n", "\r", "\n"], '', $line) . "\n";
}
?>