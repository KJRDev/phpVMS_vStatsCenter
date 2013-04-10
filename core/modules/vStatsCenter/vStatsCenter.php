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
class vStatsCenter extends CodonModule {
	
	public $title = 'vStatsCenter';
	
	public function index()
	{
		//Whenever your pages are public, you could be running into a risk of bots exessively running this page.
		//This page has tons of queries to run to return the real-time stats, if I were you, I would require login first as it's already done for you.
		 if (!Auth::LoggedIn()) {
            $this->set('message', 'You must be logged in to view this page!');
            $this->render('core_error.tpl');
            return;
        }
		
		$month = $_GET['month'];
		$year = $_GET['year'];
		
		$start = StatsData::GetStartDate();
        $this->set('startmonth', date('m', strtotime($start->submitdate)));
        $this->set('startyear', date('Y', strtotime($start->submitdate)));
        $this->set('today', getdate());
		
		$this->set('month', $month);
        $this->set('year', $year);
		
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
		
		$this->render('vStatsCenter/index.tpl');
	}

}
