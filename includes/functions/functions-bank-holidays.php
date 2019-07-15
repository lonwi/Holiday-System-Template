<?php

function get_bank_holiday(){
	$bankholidays = get_bank_holidays();
	$current_date = date("Y-m-d");
	if(!$bankholidays)return false;
	foreach($bankholidays as $bankholiday){
		if($current_date < $bankholiday['date']){
			$result = $bankholiday;
			break;
		}
	}
	return $result;
}

function get_bank_holidays(){
	$url = 'https://www.gov.uk/bank-holidays/england-and-wales.json';
	$bankholidays = wp_remote_get($url);
	if(!$bankholidays)return false;
	$bankholidays = json_decode($bankholidays['body'], true);
	$bankholidays = $bankholidays['events'];
	
	return $bankholidays;
}
