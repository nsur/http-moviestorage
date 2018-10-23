<?php require_once(ROOT.'/views/tpl/header.php'); ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<form name="upload_request" action="/upload_request" method="post" enctype="multipart/form-data" class="uploadForm">
				<div class="form-group">
					<input type="file" name="file" class="form-control" aria-describedby="chooseFile" placeholder="Choose file">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
		<?php if(!empty($this->sample)) {?>
			<div class="col-md-12 col-xs-12">
				<h4>File Import Example</h4>
				<?php echo $this->sample; ?>
			</div>
		<?php }?>
	</div>
<?php require_once(ROOT.'/views/tpl/footer.php'); ?>