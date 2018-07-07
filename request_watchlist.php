<?php

	$interval = '60min';

	foreach ($data_watchlist as $smbl => $smbl_val) {
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$smbl."&interval=".$interval."&apikey=MTVSJ3KWHS922R2L"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);
		$output_decode = json_decode($output, true);
		$fixed_date = date('Y-m-22 00:30:00');
		$first_output = current($output_decode['Time Series (60min)']);
		$se_last_value[$smbl] = $first_output['4. close'];
		$volume = 0;
		foreach ($output_decode['Time Series (60min)'] as $key1 => $value1) {
			$volume = $volume + $value1['5. volume'];
			if ($key1 == $fixed_date) { break; }
		}
		$se_last_volume[$smbl] = number_format($volume);
	}

?>