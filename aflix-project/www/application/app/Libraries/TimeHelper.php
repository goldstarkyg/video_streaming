<?php namespace HelloVideo\Libraries;

class TimeHelper{

	public static function convert_seconds_to_HMS($seconds){
		if($seconds != 0){
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$seconds = $seconds % 60;

			if($hours != 0){
				return $hours.':'.$minutes.':'.sprintf( '%02d', $seconds );
			} else {
				return $minutes.':'.sprintf( '%02d', $seconds );
			}
		}
	}

	public static function collapse($time)
	{
		if(!empty($time)){
			$time = explode(':', $time);

			if(count($time) == 3){
				return ($time[0] * 3600) + ($time[1] * 60) + $time[2];
			}
		}

	}

}
