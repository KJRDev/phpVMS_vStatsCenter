/**
Module Created By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/
**/

// Version 1.0 (May.23.12) - Module Created

===============

HOW TO USE THIS MODULE:

A simple nav. to the module page...

LEAVE THE $month and $year VARIABLES ALONE OR THE LINK WON'T FUNCTION PROPERLY!

<?php
$month = date(n);
$year = date(Y);
?>
<a href="<?php echo url('/vStatsCenter/index?month='.$month.'&year='.$year.'') ?>">vStatsCenter</a>