<?php
/**
Module Created By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2017
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/
**/

// Version 1.0 (May.23.12) - Module Created
// Version 1.1 (December 16, 2016) - Updated for a clean URL and correct template extension
// Version 1.1.1 (Cleaned Up code, fixed static errors)
class vStatsCenter extends CodonModule {
	
	public $title = 'vStatsCenter';
	
	public function index($month, $year)
	{
		//require login
		if (!Auth::LoggedIn()) {
		    $this->set('message', 'You must be logged in to view this page!');
		    $this->show('core_error');
		    return;
		}
		
		//set up the data
		$start = StatsData::GetStartDate();
        	$this->set('startmonth', date('m', strtotime($start->submitdate)));
        	$this->set('startyear', date('Y', strtotime($start->submitdate)));
        	$this->set('today', getdate());
		//set the dates
		$this->set('month', intval($month));
        	$this->set('year', intval($year));
		//get the following data
		$this->set('flightcount', VAStatsData::monthly_flight_stats($month, $year));
		$this->set('flighthours', VAStatsData::monthly_hours_stats($month, $year));
		$this->set('flightmiles', VAStatsData::monthly_miles_stats($month, $year));
		$this->set('flightfuel', VAStatsData::monthly_fuelused_stats($month, $year));
		$this->set('greasedland', VAStatsData::get_greased_month_landing($month, $year));
		$this->set('passengers', VAStatsData::monthly_pax_stats($month, $year));
		$this->set('avglanding', VAStatsData::monthly_avg_landing_rate($month, $year));
		$this->set('newpilots', VAStatsData::monthly_new_pilots($month, $year));
		$this->set('awards', VAStatsData::monthly_awards($month, $year));
		$this->set('numawards', VAStatsData::monthly_awards_count($month, $year));
		$this->set('topdistance', VAStatsData::monthly_pilot_distance($month, $year));
		$this->set('topflight', VAStatsData::monthly_pilot_flighttime($month, $year));
		$this->set('numflights', VAStatsData::monthly_pilot_flights($month, $year));
		
		//render page
		$this->show('vStatsCenter/index');
	}

}
