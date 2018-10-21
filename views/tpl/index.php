<?php require_once(ROOT.'/views/tpl/header.php'); ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<form name="search-form" action="/" method="get" class="searchForm card card-sm">
				<div class="card-body row no-gutters align-items-center">
					<div class="col-md-10">
						<input type="search" name="s" value="<?php echo $_GET['s'] ?>" class="form-control" placeholder="Search movies by title or stars">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-secondary">Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<ul class="list-group">
				<?php foreach($this->movies as $m) {?>
					<li class="list-group-item">
						<h4><?php echo $m['title'] ?></h4>
						<p>Year: <?php echo $m['release_year'] ?>, Format: <?php echo $m['format_name'] ?></p>
						<p>Stars: <?php echo implode(', ', $m['stars']) ?></p>
						<a href="/movie/show/<?php echo $m['id'] ?>" class="btn btn-primary">Show</a>
						<a href="/movie/edit/<?php echo $m['id'] ?>" class="btn btn-primary">Edit</a>
						<a href="/movie/delete/<?php echo $m['id'] ?>" class="btn btn-primary">Delete</a>
					</li>
				<?php }?>
			</ul>
		</div>
	</div>
<?php require_once(ROOT.'/views/tpl/footer.php'); ?>