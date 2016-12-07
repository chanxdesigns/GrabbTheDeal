<?php

namespace App\Custom\Helpers;

class Helpers
{
	public static function unique_arr($array, $key)
	{
		$key_array = array();
		$temp_array = array();
		$i = 0;

		foreach ($array as $val) {
			//dd($val);
			if (!in_array($val[$key], $key_array)) {
				array_push($key_array,$val[$key]);
				array_push($temp_array,$val);
			}
			$i++;
		}

		return $temp_array;
	}
}
