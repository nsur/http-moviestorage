<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/style.css" />
	<script src="/js/jquery-1.12.4.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<title>MovieStorage</title>
</head>
<body>
<header>
	<nav class="navbar navbar-default header">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nb_collapse" aria-expanded="false">
					<span class="sr-only">Switch navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">MovieStorage</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="/movie/edit">Add Movie</a></li>
				<li><a href="/upload">Upload Movies</a></li>
			</ul>
		</div>
	</nav>
</header>
<section class="site-content">
	<div class="container content">
		<div class="<?php echo !empty($_SESSION['message']) ? (empty($_SESSION['errors']) ? 'alert alert-success' : 'alert alert-danger') : '' ?>" role="alert"><?php echo !empty($_SESSION['message']) ? $_SESSION['message'] : ''?></div>
		<?php session_destroy(); ?>