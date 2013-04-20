<?php
/**
Module Created By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/
**/

// Version 1.0 (May.23.12) - Module Created
class VAStatsData extends CodonData {
	
	public function monthly_flight_stats($month, $year) {
        	$query = "SELECT * FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = '".DB::escape($month)."' AND YEAR(submitdate) = '".DB::escape($year)."' AND accepted = 1";
		$results = DB::get_results($query);
		return DB::num_rows($results);
    }
	
	public function monthly_hours_stats($month, $year) {
		$query = "SELECT SUM(flighttime) AS hours FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND accepted = 1";
		$result = DB::get_row($query);
		return $result->hours;
	}
	
	public function monthly_miles_stats($month, $year) {
		$query = "SELECT SUM(distance) AS distance FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND accepted = 1";
		$result = DB::get_row($query);
		return $result->distance;
	}
	
	public function monthly_fuelused_stats($month, $year) {
		$query = "SELECT SUM(fuelused) AS fuelused FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND accepted = 1";
		$result = DB::get_row($query);
		return $result->fuelused;
	}
	
	public function monthly_pax_stats($month, $year) {
		$query = "SELECT SUM(`load`) AS passengers FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND accepted = 1";
		$result = DB::get_row($query);
		return $result->passengers;
	}
	
	public function monthly_new_pilots($month, $year) {
		$query = "SELECT * FROM " . TABLE_PREFIX . "pilots WHERE MONTH(joindate) = ".DB::escape($month)." AND YEAR(joindate) = ".DB::escape($year)." AND confirmed = 1 AND retired = 0";
		$results = DB::get_results($query);
		return DB::num_rows($results);
	}
	
	public function monthly_avg_landing_rate($month, $year) {
		$query = "SELECT AVG(landingrate) AS rate FROM " . TABLE_PREFIX . "pireps WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND landingrate != 0 AND accepted = 1";
		$result = DB::get_row($query);
		return $result->rate;
	}
	
	public function monthly_awards_count($month, $year) {
		$query = "SELECT * FROM " . TABLE_PREFIX . "awardsgranted WHERE MONTH(dateissued) = ".DB::escape($month)." AND YEAR(dateissued) = ".DB::escape($year);
		$results = DB::get_results($query);
		return DB::num_rows($results);
	}
	
	public function monthly_pilot_distance($month, $year) {
		$query = "SELECT f.*, SUM(f.distance) as distance, p.* 
				  FROM " . TABLE_PREFIX . "pireps f
                  LEFT JOIN " . TABLE_PREFIX . "pilots p ON p.pilotid = f.pilotid
				  WHERE MONTH(f.submitdate) = ".DB::escape($month)." AND YEAR(f.submitdate) = ".DB::escape($year)." AND f.accepted = 1 AND p.retired = 0
				  GROUP BY f.pilotid
				  ORDER BY distance DESC
				  LIMIT 5";		
	
		$results = DB::get_results($query);
		return $results;
	}
	
	public function monthly_pilot_flighttime($month, $year) {
		$query = "SELECT f.*, SUM(f.flighttime) as time, p.* 
				  FROM " . TABLE_PREFIX . "pireps f
                  LEFT JOIN " . TABLE_PREFIX . "pilots p ON p.pilotid = f.pilotid
                  WHERE MONTH(f.submitdate) = ".DB::escape($month)." AND YEAR(f.submitdate) = ".DB::escape($year)." AND f.accepted = 1 AND p.retired = 0
                  GROUP BY f.pilotid
				  ORDER BY time DESC
                  LIMIT 5";
				  
		$results = DB::get_results($query);
		return $results;
	}
	
	public function monthly_pilot_flights($month, $year) {
	    $query = "SELECT f.*, p.*, COUNT(*) AS flights
				  FROM " . TABLE_PREFIX . "pireps f
				  LEFT JOIN " . TABLE_PREFIX . "pilots p ON p.pilotid = f.pilotid
				  WHERE MONTH(f.submitdate) = ".DB::escape($month)." AND YEAR(f.submitdate) = ".DB::escape($year)." AND f.accepted = 1 AND p.retired = 0
				  GROUP BY f.pilotid
				  ORDER BY flights DESC
				  LIMIT 5";
		
		$results = DB::get_results($query);
		return $results;
	}
	
	public function monthly_awards($month, $year) {
		$query = "SELECT l.*, UNIX_TIMESTAMP(l.dateissued) as dateissued, p.*, e.*
				  FROM " . TABLE_PREFIX . "awardsgranted l
				  LEFT JOIN " . TABLE_PREFIX . "awards p ON p.awardid = l.awardid
				  LEFT JOIN " . TABLE_PREFIX . "pilots e ON e.pilotid = l.pilotid WHERE e.retired = 0 AND MONTH(l.dateissued) = ".DB::escape($month)." AND YEAR(l.dateissued) = ".DB::escape($year)."
				  ORDER BY dateissued ASC";
		$results = DB::get_results($query);
		return $results;
	}
	
	public static function get_greased_month_landing($month, $year) {
		$query = "SELECT p.*, UNIX_TIMESTAMP(p.submitdate) as submitdate,
		          u.pilotid, u.firstname, u.lastname, u.email, u.rank,
				  a.id AS aircraftid, a.name as aircraft, a.registration,
				  dep.name as depname, dep.lat AS deplat, dep.lng AS deplng,
				  arr.name as arrname, arr.lat AS arrlat, arr.lng AS arrlng						
				  FROM " . TABLE_PREFIX . "pireps p
				  LEFT JOIN " . TABLE_PREFIX . "aircraft a ON a.id = p.aircraft
				  LEFT JOIN " . TABLE_PREFIX . "airports AS dep ON dep.icao = p.depicao
				  LEFT JOIN " . TABLE_PREFIX . "airports AS arr ON arr.icao = p.arricao 
				  LEFT JOIN " . TABLE_PREFIX . "pilots u ON u.pilotid = p.pilotid
				  WHERE MONTH(submitdate) = ".DB::escape($month)." AND YEAR(submitdate) = ".DB::escape($year)." AND p.landingrate != 0 AND p.accepted = 1 AND u.retired = 0
				  ORDER BY p.landingrate DESC
				  LIMIT 5";
		$results = DB::get_results($query);
		return $results;
	}
}
