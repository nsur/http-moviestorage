<?php require_once(ROOT.'/views/tpl/header.php'); ?>
<form name="upload_request" action="/upload_request" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<input type="file" name="file" class="form-control" aria-describedby="chooseFile" placeholder="Choose file">
		<small id="chooseFile" class="form-text text-muted">Select the file with movies list</small>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php require_once(ROOT.'/views/tpl/footer.php'); ?>