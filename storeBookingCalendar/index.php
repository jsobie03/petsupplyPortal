<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<style>
html *
{
   font-family: Arial !important;
}
h1 {
	font-family:"Abril Fatface" !important;
	font-size:60px;
	text-align:center;	
}
h3 {
	font-family:"Abril Fatface" !important;
	font-size:30px;
	text-align:center;	
}
table.calendar {
	border-left: 1px solid #999;
}
tr.calendar-row {
	min-height:140px;
	height:140px;
}
td.calendar-day {
	min-height: 80px;
	height:80px;
	font-size: 11px;
	position: relative;
	vertical-align: top;
}
* html div.calendar-day {
	height: 80px;
}
td.calendar-day:hover {
	background: #eceff5;
}
td.calendar-day-np {
	background: #eee;
	min-height: 80px;
}
* html div.calendar-day-np {
	height: 140px;
}
td.calendar-day-head {
	background: #ccc;
	font-weight: bold;
	text-align: center;
	width: 120px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-top: 1px solid #999;
	border-right: 1px solid #999;
}
div.day-number {
	background: #999;
	padding: 5px;
	color: #fff;
	font-weight: bold;
	float: right;
	margin: -5px -5px 0 0;
	width: 20px;
	text-align: center;
}
td.calendar-day, td.calendar-day-np {
	width: 120px;
	height:140px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-right: 1px solid #999;
}
</style>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Scheduler for Vendor Training and Demo Reps</title>
<link href="jquery-ui.css" rel="stylesheet">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<!--<script src="lang/datepicker-fi.js"></script>-->
<script>
    $(function() {
	<!--$.datepicker.setDefaults($.datepicker.regional['fi']);-->
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
	  regional: "fi",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });  </script>
</head>

<body>

<h1>Demo and Training Scheduler</h1>
<table style="margin:0 auto; background:rgba(204,204,204,1);" border="1" cellpadding="5" width="800">
	<tr>
		<td valign="top">
		<form action="book.php" method="post">
			<h3>Schedule a Demo Rep or a Vendor Training!</h3>
			<p><input checked="checked" name="item" type="radio" value="Training" />Training 
			| <input name="item" type="radio" value="Demo" />Demo Sample Rep
            | <input name="item" type="radio" value="Meeting" />Store Meeting
			<table style="width: 100%">
				<tr>
					<td>Brand Name:</td>
					<td> <input maxlength="50" name="brandname" required="" type="text" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
                	<td>Representative Name:</td>
                    <td> <input maxlength="50" name="repname" required="" type="text" /></td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
 					<td>Phone:</td>
					<td>
			<input maxlength="20" name="phone" required="" type="text" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Start Time:</td>
					<td>
			<input id="from" name="start_day" required="" type="text" /></td>
					<td>-</td>
					<td><input id="to" name="end_day" required="" type="text" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td> <select name="start_hour">
            <option selected="selected">9</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
            <option>01</option>
			<option>02</option>
			<option>03</option>
			<option>04</option>
            <option>05</option>
			<option>06</option>
			<option>07</option>
            <option>08</option>
			<option>09</option>
			</select>:<select name="start_minute">
			<option selected="selected">00</option>
			<option>30</option>
			</select></td>
					<td>&nbsp;</td>
					<td><select name="end_hour">
			<option selected="selected">9</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
            <option>01</option>
			<option>02</option>
			<option>03</option>
			<option>04</option>
            <option>05</option>
			<option>06</option>
			<option>07</option>
            <option>08</option>
			<option>09</option>
			</select>:<select name="end_minute">
			<option>00</option>
			<option selected="selected">30</option>
			</select></td>
				</tr>
			</table>
			<!--<p>
			<img id="captchaimg" src="captcha_code_file.php?rand=?php echo rand(); ?>" /><br>
			<input id="captcha" name="captcha" required="" type="text" /></p>-->
			<input name="book" type="submit" value="Book" />
		</form>
		</td>
		<td valign="top">
		<h3>Cancel Appointment</h3>
		<form action="cancel.php" method="post">
			<p></p>
			ID: <input name="id" required="" type="text" /><br />
			<!--<p>
			<img id="captchaimg2" src="captcha_code_file2.php?rand=<?php echo rand(); ?>" /><br>
			<input id="captcha2" name="captcha2" required="" type="text" /></p>-->
			<p><input name="cancel" type="submit" value="Cancel" /></p>
		</form>
		</td>
	</tr>
</table>
<a href="../employees/viewEmployees.php">Return To Menu</a>
<?php
/* draws a calendar */
function draw_calendar($month,$year){

	include 'config.php';

	// Create connection
	$conn = mysqli_connect($servername, $username, $password,  $dbname);

	// Check connection
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}

	/* draw table */
	$calendar = '<table style="margin:0 auto;" cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			$current_epoch = mktime(0,0,0,$month,$list_day,$year);
			
			$sql = "SELECT * FROM $tablename WHERE $current_epoch BETWEEN start_day AND end_day";
						
			$result = mysqli_query($conn, $sql);
    		
    		if (mysqli_num_rows($result) > 0) {
    			// output data of each row
    			while($row = mysqli_fetch_assoc($result)) {
					if($row["canceled"] == 1) $calendar .= "<font color=\"grey\"><s>";
    				$calendar .= "<b>" . "BookingID: " . $row["id"] . "<br>" . $row["item"] . "</b>" . "<br>" . $row["repname"] . " from " . $row["brandname"] . "<br>";
    				if($current_epoch == $row["start_day"] AND $current_epoch != $row["end_day"]) {
    					$calendar .= "Start Time: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br><hr><br>";
    				}
    				if($current_epoch == $row["start_day"] AND $current_epoch == $row["end_day"]) {
    					$calendar .= "Start Time: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br>";
    				}
    				if($current_epoch == $row["end_day"]) {
    					$calendar .= "End Time: " . sprintf("%02d:%02d", $row["end_time"]/60/60, ($row["end_time"]%(60*60)/60)) . "<br><hr><br>";
    				}
    				if($current_epoch != $row["start_day"] AND $current_epoch != $row["end_day"]) {
	    				$calendar .= "Booking: 24h<br><hr><br>";
	    			}
					if($row["canceled"] == 1) $calendar .= "</s></font>";
    			}
			} else {
    			$calendar .= "No bookings";
			}
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	mysqli_close($conn);
	
	/* all done, return result */
	return $calendar;
}

include 'config.php';

$d = new DateTime(date("Y-m-d"));
echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
echo draw_calendar($d->format('m'),$d->format('Y'));

$d->modify( 'first day of next month' );
echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
echo draw_calendar($d->format('m'),$d->format('Y'));

$d->modify( 'first day of next month' );
echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
echo draw_calendar($d->format('m'),$d->format('Y'));

?>

</body>

</html>
