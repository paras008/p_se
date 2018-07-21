<?php

	$symbol = $_POST['symbol'];
	$interval = $time = $_POST['time'];
	if ($interval == 'today') {
		$interval = '1min';
	}
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=".$interval."&apikey=MTVSJ3KWHS922R2L"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 
	curl_close($ch);

	$data = json_decode($output, true);
	$data_only = array_reverse($data['Time Series ('.$time.')']);
	$todays_day = date('d');
	$arr = [];
	$arr1 = [];
	$count = 0;
	foreach ($data_only as $key => $value) {
		$k = explode(" ", $key);
		$k2 = explode("-", $k[0]);
		$k1 = explode(":", $k[1]);
		if ($time == 'today' && $k2[2] != $todays_day) {
			continue;
		}
		$d=mktime($k1[0], $k1[1], $k1[2], $k2[1], $k2[2], $k2[0]);
		$one = date('Y/m/d H:i:s',$d);
		$two = (float) $value['4. close'];
		array_push($arr, [$one, $two]);
		// if ($count == 50 && ($time != '1min') ) { break; } else { $count += 1; }
	}
	// print_r(json_encode($arr));
	echo "<pre>";
	print_r(json_encode($arr));
	echo "<br>";
	echo "</pre>";
	die();
	exit();

?>