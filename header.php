

<?php
/** Creates the header for the Latham Farms website where you can navigate to
*each neccesary part of the website
*
*/
echo'

<html>
<head>
    <meta charset="UTF-8">
    <title>Latham Fire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="dragging.css">
    <script src="jquery-ui-1.11.4/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="common.css">
	</head>
   <body>  
   
    <nav role="navigation" class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="#" class="navbar-brand"></a>
    </div>
    <!-- Collection of nav links and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="query.php">Trucks</a></li>
            <li><a href="addFirefighter.php">Add Firefighter</a></li>
			<li><a href="displayFirefighter.php">Display Firefighters</a></li>
			<li><a href="active.php">Present Firefighters</a></li>
			
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
    </nav> ';
