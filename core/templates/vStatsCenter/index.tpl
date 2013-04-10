<!-- 
/**
Module Created By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/
**/

// Version 1.0 (May.23.12) - Module Created
-->
<?php error_reporting(0);?>
<?php echo SITE_NAME;?> vStatsCenter

<?php $month_name = date( 'F', mktime(0, 0, 0, $month) ); ?>

<script type="text/javascript">
function submitForm() {
var list = document.navList.subMenu;
var page = list.options[ list.selectedIndex ].value;
if (page != "home")
window.location = page;
return false;
}
</script>
<h3>Select Month</h3>
<div align="left">
<form name="navList" onsubmit="return submitForm();">
<select name="subMenu">
<?php
while ($startyear <= $today[year]):
{
	$month_name = date( 'F', mktime(0, 0, 0, $startmonth) );
        echo '<option value="'.url('/vStatsCenter/index?month='.$startmonth.'&year='.$startyear.'').'">'.$month_name.' - '.$startyear.'</option>';

        if ($startmonth == $today[mon] && $startyear == $today[year])
        {
            break;
        }
        if ($startmonth == 12)
        {
            $startyear++;
            $startmonth = 01;
        }
        else
        {
            $startmonth++;
        }
}
endwhile;
?>
</select>
<input type="submit" value="View Month Stats" />
</form>

<h3 align="center">Stats For <?php echo $month_name;?> - <?php echo $year;?></h3>


<table align="center">
<thead>
<th colspan="9">Airline Stats</th>
<tr>
	
	<th>Flights Flown</th>
	<th>Flight Hours</th>
    <th>Total Pax.</th>
    <th>Avg. Landing Rate</th>
    <th>New Pilots</th>
    <th>Awards Issued</th>
    <th>Flight Miles</th>
    <th>Flight Fuel</th>

</tr>
</thead>
<tbody>
<tr>
	<td align="center"><?php echo $flightcount;?></td>
	<td align="center"><?php echo $flighthours;?></td>
    <td align="center"><?php echo $passengers;?></td>
    <td align="center"><?php echo round($avglanding);?>(FT/MIN)</td>
    <td align="center"><?php echo $newpilots;?></td>
    <td align="center"><?php echo $numawards;?></td>
    <td align="center"><?php echo $flightmiles;?>(NM)</td>
    <td align="center"><?php echo $flightfuel;?>(LBS)</td>
</tr>
</tbody>
</table>

<table align="center">
<thead>
<th colspan="4">Pilots Awards Granted</th>
<tr>
	<th>Pilot ID</th>
	<th>Pilot Name</th>
    <th>Award Granted</th>
    <th>Date</th>

</tr>
</thead>
<tbody>
<?php
foreach($awards as $awd)
{
?>
<tr>
	<td align="center"><a href="<?php echo url('/profile/view/'.$awd->pilotid);?>"><?php echo PilotData::GetPilotCode($awd->code, $awd->pilotid);?></a></td>
	<td align="center"><?php echo $awd->firstname . ' ' . $awd->lastname; ?></td>
    <td align="center"><?php echo $awd->name;?></td>
    <td align="center"><?php echo date("F j, Y", $awd->dateissued); ?></td>
</tr>
<?php
}
?>
</tbody>
</table>

<table align="center">
<thead>
<th colspan="6">Pilots Greased Landings</th>
<tr>
	<th>Rank</th>
	<th>Flight #</th>
	<th>Dep. - Arr.</th>
    <th>Landing Rate</th>
	<th>Pilot</th>
    <th>Date</th>

</tr>
</thead>
<tbody>
<?php
$ranklanding = 1;
foreach($greasedland as $flight)
{

?>
<tr>
	<td align="center"><?php echo $ranklanding;?></td>
	<td align="center"><a href="<?php echo url('/pireps/viewreport/'.$flight->pirepid);?>"><?php echo $flight->code.$flight->flightnum;?></a></td>
	<td align="center"><?php echo $flight->depicao . '-' .$flight->arricao;?></td>
	<td align="center"><?php echo $flight->landingrate;?></td>
    
    <td align="center"><?php echo $flight->firstname . ' ' . $flight->lastname;?></td>
    <td align="center"><?php echo date("F j, Y", $flight->submitdate); ?>
</tr>
<?php
$ranklanding = 1 + $ranklanding;
}
?>
</tbody>
</table>

<table align="center">
<thead>
<th colspan="4">Top Distance Pilots</th>
<tr>
	<th>Rank</th>
	<th>Pilot ID</th>
	<th>Pilot Name</th>
	<th>Total Distance</th>

</tr>
</thead>
<tbody>
<?php
$rankdis = 1;
foreach($topdistance as $dis)
{

?>
<tr>
	<td align="center"><?php echo $rankdis;?></td>
	<td align="center"><a href="<?php echo url('/profile/view/'.$dis->pilotid);?>"><?php echo PilotData::GetPilotCode($dis->code, $dis->pilotid);?></a></td>
	<td align="center"><?php echo $dis->firstname . ' ' . $dis->lastname; ?></td>
	<td align="center"><?php echo $dis->distance;?></td>
</tr>
<?php
$rankdis = 1 + $rankdis;
}
?>
</tbody>
</table>

<table align="center">
<thead>
<th colspan="4">Top Flight Time Pilots</th>
<tr>
	<th>Rank</th>
	<th>Pilot ID</th>
	<th>Pilot Name</th>
	<th>Total Time</th>

</tr>
</thead>
<tbody>
<?php
$ranktime = 1;
foreach($topflight as $ptime)
{
?>
<tr>
	<td align="center"><?php echo $ranktime;?></td>
	<td align="center"><a href="<?php echo url('/profile/view/'.$ptime->pilotid);?>"><?php echo PilotData::GetPilotCode($ptime->code, $ptime->pilotid);?></a></td>
	<td align="center"><?php echo $ptime->firstname . ' ' . $ptime->lastname; ?></td>
	<td align="center"><?php echo $ptime->time;?></td>
</tr>
<?php
$ranktime = 1 + $ranktime;
}
?>
</tbody>
</table>

<table align="center">
<thead>
<th colspan="4">Top Flights Pilots</th>
<tr>
	<th>Rank</th>
	<th>Pilot ID</th>
	<th>Pilot Name</th>
	<th>Total Flights</th>

</tr>
</thead>
<tbody>
<?php
$rankflights = 1;
foreach($numflights as $numflt)
{

?>
<tr>
	<td align="center"><?php echo $rankflights;?></td>
	<td align="center"><a href="<?php echo url('/profile/view/'.$numflt->pilotid);?>"><?php echo PilotData::GetPilotCode($numflt->code, $numflt->pilotid);?></a></td>
	<td align="center"><?php echo $numflt->firstname . ' ' . $numflt->lastname; ?></td>
	<td align="center"><?php echo $numflt->flights;?></td>
</tr>
<?php
$rankflights = 1 + $rankflights;
}
?>
</tbody>
</table>