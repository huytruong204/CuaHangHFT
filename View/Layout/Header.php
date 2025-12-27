<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Food</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/global.css" rel="stylesheet">
	<link href="assets/css/index.css" rel="stylesheet">
	<link href="assets/css/shop.css" rel="stylesheet">
    <link href="assets/css/contact.css" rel="stylesheet">
	<link href="assets/css/auth.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
	<script src="assets/js/jquery-2.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/ekko-lightbox.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/js/codebase/dhtmlxcalendar.css"/>
	<script src="assets/js/codebase/dhtmlxcalendar.js"></script>
	<script>
		var myCalendar;
		function doOnLoad() {
			myCalendar = new dhtmlXCalendarObject(["cal_1","cal_2", "cal_3"]);
		}
	</script>

  </head>
<body onLoad="doOnLoad();">
<div class="main clearfix">
 <div class="main_1 clearfix">
  <section id="menu" class="clearfix cd-secondary-nav">
	<nav class="navbar nav_t">
		<div class="container-fluid">
		    <div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php?page=Home"> <i class="fa fa-cutlery"></i> HFT <br> </a>
			</div>
			<?php MenuComponent::Index();?>
			<!-- Brand and toggle get grouped for better mobile display -->
			<!-- Collect the nav links, forms, and other content for toggling -->
