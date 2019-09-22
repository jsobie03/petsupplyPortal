<?php

	function GetUserIPAddress() {
		if (!empty($_SERVER["HTTP_CLIENT_IP"])) // check ip address from share internet
		{
			$useripaddress = $_SERVER["HTTP_CLIENT_IP"];
		} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) // to check if ip address is passed from proxy
		{              
			$useripaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else {
			$useripaddress = $_SERVER["REMOTE_ADDR"];
		}
		return $useripaddress;
	}

	function IsLogEmpty ( $useripaddress ) {
		$query = "SELECT Counter FROM " . MS_STATS_COUNTERLOG_TABLE . " WHERE IP_Address = '".$useripaddress."'";
		$rs = ew_Execute($query);
		if ($rs && !$rs->EOF) {
			$lognum = $rs->RecordCount();
		} else {
			$lognum = 0;
		}
		if ($lognum == 0) { return TRUE; }
		if ($lognum != 0) { return FALSE; }
	}

	function AddLog ( $useripaddress, $hostname ) {
		$today = date("Y-m-d H:i:s");
		$query = "INSERT INTO " . MS_STATS_COUNTERLOG_TABLE . " VALUES ('".$useripaddress."', '".$hostname."', '".$today."', '".$today."', 1)"; // first time ever! :)
		ew_Execute($query);
	}

	function UpdateCounterLog ( $useripaddress, $hostname ) {	
		$today = date("Y-m-d H:i:s");
		$z = GetCounterLog($useripaddress);
		$z++;
		$query = "UPDATE " . MS_STATS_COUNTERLOG_TABLE . " SET Counter = ".$z.", Last_Visit = '".$today."', Hostname = '".$hostname."' WHERE IP_Address LIKE '".$useripaddress."'";
		ew_Execute($query);
	}

	function GetCounterLog ( $useripaddress ) {
		$query = "SELECT Counter FROM " . MS_STATS_COUNTERLOG_TABLE . " WHERE IP_Address LIKE '".$useripaddress."'";
		$rscounter = ew_Execute($query);
		if ($rscounter && !$rscounter->EOF) {
			$counter_value = $rscounter->fields("Counter");
		} else {
			$counter_value = 0;
		}
		return $counter_value;
	}
	$user_ip = GetUserIPAddress(); // getenv("REMOTE_ADDR"); // <-- old way, don't use it!!!

	//$user_host = gethostname(); // <-- PHP >= 5.3.0 // php_uname('n');  // <-- PHP 4 >= 4.0.2, PHP 5  // getenv("REMOTE_HOST"); // <-- PHP < 4.0.2
	$user_host = "";
	if (version_compare(phpversion(), '5.3.5', '>=')) {
		$user_host = gethostname();
	} elseif (version_compare(phpversion(), '4.2.0', '>=')) {
		$user_host = php_uname('n');
	} else {
		$user_host = getenv('HOSTNAME'); 
		if(!$user_host) $user_host = trim(`hostname`); 
		if(!$user_host) $user_host = exec('echo $HOSTNAME');
		if(!$user_host) $user_host = preg_replace('#^\w+\s+(\w+).*$#', '$1', exec('uname -a'));
	}
	if ( IsLogEmpty($user_ip) == TRUE ) {
		AddLog($user_ip, $user_host);
	} else {
		UpdateCounterLog($user_ip, $user_host);
	}

	/* Get the Browser data */
	if ((@ereg("Nav", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Gold", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("X11", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Mozilla", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Netscape", $_SERVER["HTTP_USER_AGENT"])) AND (!@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) AND (!@ereg("Konqueror", $_SERVER["HTTP_USER_AGENT"])) AND (!@ereg("Yahoo", $_SERVER["HTTP_USER_AGENT"])) AND (!@ereg("Firefox", $_SERVER["HTTP_USER_AGENT"]))) $browser = "Netscape";
	elseif(@ereg("Firefox", $_SERVER["HTTP_USER_AGENT"])) $browser = "FireFox";
	elseif(@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) $browser = "MSIE";
	elseif(@ereg("Lynx", $_SERVER["HTTP_USER_AGENT"])) $browser = "Lynx";
	elseif(@ereg("Opera", $_SERVER["HTTP_USER_AGENT"])) $browser = "Opera";
	elseif(@ereg("WebTV", $_SERVER["HTTP_USER_AGENT"])) $browser = "WebTV";
	elseif(@ereg("Konqueror", $_SERVER["HTTP_USER_AGENT"])) $browser = "Konqueror";
	elseif((stristr("bot", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Google", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Slurp", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Scooter", $_SERVER["HTTP_USER_AGENT"])) || (stristr("Spider", $_SERVER["HTTP_USER_AGENT"])) || (stristr("Infoseek", $_SERVER["HTTP_USER_AGENT"]))) $browser = "Bot";
	else $browser = "Other";

	/* Get the Operating System data */
	if(@ereg("Win", $_SERVER["HTTP_USER_AGENT"])) $os = "Windows";
	elseif((@ereg("Mac", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("PPC", $_SERVER["HTTP_USER_AGENT"]))) $os = "Mac";
	elseif(@ereg("Linux", $_SERVER["HTTP_USER_AGENT"])) $os = "Linux";
	elseif(@ereg("FreeBSD", $_SERVER["HTTP_USER_AGENT"])) $os = "FreeBSD";
	elseif(@ereg("SunOS", $_SERVER["HTTP_USER_AGENT"])) $os = "SunOS";
	elseif(@ereg("IRIX", $_SERVER["HTTP_USER_AGENT"])) $os = "IRIX";
	elseif(@ereg("BeOS", $_SERVER["HTTP_USER_AGENT"])) $os = "BeOS";
	elseif(@ereg("OS/2", $_SERVER["HTTP_USER_AGENT"])) $os = "OS/2";
	elseif(@ereg("AIX", $_SERVER["HTTP_USER_AGENT"])) $os = "AIX";
	else $os = "Other";

	/* Save on the databases the obtained values */
	$rs = ew_Execute("UPDATE ". MS_STATS_COUNTER_TABLE . " SET Counter = Counter + 1 WHERE (Type = 'total' AND Variable = 'hits') OR (Variable = '".$browser."' AND Type = 'browser') OR (Variable = '".$os."' AND Type = 'os')");

	/* Start Detailed Statistics */
	$dot = date("d-m-Y-H");
	$now = explode ("-",$dot);
	$nowHour = $now[3];
	$nowYear = $now[2];
	$nowMonth = $now[1];
	$nowDate = $now[0];
	$sql = "SELECT Year FROM " . MS_STATS_YEAR_TABLE . " WHERE Year = ".$nowYear."";
	$resultyear = ew_Execute($sql);
	if ($resultyear && !$resultyear->EOF) {
		$RecCount = $resultyear->RecordCount();
	} else {
		$RecCount = 0;
	}
	if ($RecCount <= 0) {
		$sql = "INSERT INTO " . MS_STATS_YEAR_TABLE . " VALUES (".$nowYear.", 0)";
		$rs = ew_Execute($sql);
		for ($i = 1; $i <= 12; $i++) {
			$rs = ew_Execute("INSERT INTO " . MS_STATS_MONTH_TABLE . " VALUES (".$nowYear.", ".$i.", 0)");
			if ($i == 1) $TotalDay = 31;
			if ($i == 2) {
				if (date("L") == true) {
					$TotalDay = 29;
				} else {
					$TotalDay = 28;
				}
			}
			if ($i == 3) $TotalDay = 31;
			if ($i == 4) $TotalDay = 30;
			if ($i == 5) $TotalDay = 31;
			if ($i == 6) $TotalDay = 30;
			if ($i == 7) $TotalDay = 31;
			if ($i == 8) $TotalDay = 31;
			if ($i == 9) $TotalDay = 30;
			if ($i == 10) $TotalDay = 31;
			if ($i == 11) $TotalDay = 30;
			if ($i == 12) $TotalDay = 31;
			for ($k = 1; $k <= $TotalDay; $k++) {
				$rs = ew_Execute("INSERT INTO " . MS_STATS_DATE_TABLE . " VALUES (".$nowYear.", ".$i.", ".$k.", 0)");
			}
		}
	}
	$sql = "SELECT Hour FROM " . MS_STATS_HOUR_TABLE . " WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.")";
	$result = ew_Execute($sql);
	if ($result && !$result->EOF) {
		$numrows = $result->RecordCount();
	} else {
		$numrows = 0;
	}
	if ($numrows <= 0) {
		for ($i = 0; $i <= 23; $i++) {
			$rs = ew_Execute("INSERT INTO " . MS_STATS_HOUR_TABLE . " VALUES (".$nowYear.", ".$nowMonth.", ".$nowDate.", ".$i.", 0)");
		}
	}
	$rs = ew_Execute("UPDATE " . MS_STATS_YEAR_TABLE . " SET Hits = Hits + 1 WHERE Year = ".$nowYear."");
	$rs = ew_Execute("UPDATE " . MS_STATS_MONTH_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.")");
	$rs = ew_Execute("UPDATE " . MS_STATS_DATE_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.")");
	$rs = ew_Execute("UPDATE " . MS_STATS_HOUR_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.") AND (Hour = ".$nowHour.")");
?>
