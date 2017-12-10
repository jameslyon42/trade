<?php

namespace App;

class PriceHistoryService 
{
	
	protected static $base_url = 'https://www.alphavantage.co/';

	public static function getDailyPriceHistory($symbol, $outputsize = 'compact') {
		$url = self::$base_url . 
			   'query?function=TIME_SERIES_DAILY' . 
			   '&symbol=' . $symbol .
			   '&outputsize=' . $outputsize . 
			   '&apikey=' . env('ALPHA_VANTAGE_API_KEY');

		$json_dump = file_get_contents($url);

		$data = json_decode($json_dump, true);

		return $data['Time Series (Daily)'];
	}
}
