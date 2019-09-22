<?php
session_start();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Pet Supply Portal</title>
    <link rel="stylesheet" href="main.css">
</head>

<!-- the body section -->
<body>
<main>
<header>
<img src="../images/logo4menu.png" alt="logo"/>
<hr>
<h1 style="font-family:'Fjalla One'; font-size:30px; font-weight:bolder; text-align:center;">Employee Portal <br/>(version 2.0.0)</h1></header>

<section style="margin-left:15%;">
<!--<img src="../images/kisspng-sphynx-cat-silhouette-kitten-clip-art-5b19eed26ce6e5.4225785115284261944461.png" style="float:left; clear:left;">-->
<ul style="list-style:none; text-align:center;">
<li>
<h2>Training (Retail / Pet Nutrition and Care)</h2>
<a href="http://www.petstorepro.com" target="_blank">Access Pet Store Pro Training Program</a><br/>
<a href="../learningSystem/login.php" target="_blank">Pet Supply Employee Training</a>
<p></p>
</li>
<li>
<h2>HR System / Payroll / Employee Information </h2>
<a href="../payroll/index.php" target="_blank">Employee Clock-In and Clock-Out</a><br/>
<a href="../payroll/admin/login.php" target="_blank">Manager HR Tasks</a>
<p></p>
</li>
<li>
<h2>View Store Event Calendar</h2>
<a href="../storeBookingCalendar/index.php" target="_blank">Schedule a Food Demo Rep or a Vendor Training</a>
<p></p>
</li>
<li>
<h2>Inventory Management Application</h2>
<a href="../php_stock/" target="_blank">Access Order Info</a>
<p></p>
</li>
<li>
<h2>Our Company Homepage</h2>
<a href="http://www.petsupplyoc.com" target="_blank">View The Company Webiste</a>
<p></p>
</li>
</ul>
</section>
<!--<img src="../images/img-3016_1_orig.png">-->
</main>
<?php include "../inc/footer.php" ?>
</body>
</html>
