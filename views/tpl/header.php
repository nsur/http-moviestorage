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
	<nav class="navbar navbar-default navbar-fixed-top header">
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
			<div class="collapse navbar-collapse" id="nb_collapse">
				<ul class="nav navbar-nav">
					<li><a href="/movie/edit">Add Movie</a></li>
					<li><a href="/upload">Upload Movies</a></li>
					<li><a href="/about">About</a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<form name="search-form" action="/" method="get" class="searchForm card card-sm">
						<div class="card-body row no-gutters align-items-center">
							<div class="form-group col-md-10">
								<input type="search" name="s" value="<?php echo $_GET['s'] ?>" class="form-control" placeholder="Search movies by title or stars">
							</div>
							<div class="form-group col-md-2">
								<button type="submit" class="btn btn-secondary">Search</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</nav>
</header>
<section class="site-content">
	<div class="container content">
		<div class="<?php echo !empty($_SESSION['message']) ? (empty($_SESSION['errors']) ? 'alert alert-success' : 'alert alert-danger') : '' ?>" role="alert"><?php echo !empty($_SESSION['message']) ? $_SESSION['message'] : ''?></div>
		<?php session_destroy(); ?>