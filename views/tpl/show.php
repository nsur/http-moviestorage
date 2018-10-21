<?php require_once(ROOT.'/views/tpl/header.php'); ?>
	<h4><?php echo $this->movie['title'] ?></h4>
	<p>Year: <?php echo $this->movie['release_year'] ?>, Format: <?php echo $this->movie['format_name'] ?></p>
	<p>Stars: <?php echo implode(', ', $this->movie['stars']) ?></p>
	<a href="/" class="btn btn-primary">Return</a>
	<a href="/movie/edit/<?php echo $this->movie['id'] ?>" class="btn btn-primary">Edit</a>
	<a href="/movie/delete/<?php echo $this->movie['id'] ?>" class="btn btn-primary">Delete</a>
<?php require_once(ROOT.'/views/tpl/footer.php'); ?>