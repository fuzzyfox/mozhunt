<?php
	
	function ordinal_suffix($number)
	{
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if (($number %100) >= 11 && ($number%100) <= 13)
		{
			$abbreviation = $number. 'th';
		}
		else
		{
			$abbreviation = $number. $ends[$number % 10];
		}
		return $abbreviation;
	}
	
/* End of file MH_number_helper.php */
/* Location: application/helpers/MH_number_helper.php */