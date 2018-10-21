<?php require_once(ROOT.'/views/tpl/header.php'); ?>
	<form name="save_request" action="/save_request" method="post" >
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" id="title" value="<?php echo !empty($this->movie['title']) ? $this->movie['title'] : '' ?>" class="form-control" placeholder="Title" />
		</div>
		<div class="form-group">
			<label for="release_year">Year</label>
			<select name="release_year" id="release_year" class="form-control">
				<?php foreach($this->yearsRange as $r) {?>
					<option value="<?php echo $r ?>"<?php echo !empty($this->movie['release_year']) && $this->movie['release_year'] == $r ? ' selected="selected"' : '' ?>><?php echo $r ?></option>
				<?php }?>
			</select>
		</div>
		<div class="form-group">
			<label for="format">Format</label>
			<select name="format" id="format" class="form-control">
				<?php foreach($this->formats as $f) {?>
					<option value="<?php echo $f['id'] ?>"<?php echo !empty($this->movie['format']) && $this->movie['format'] == $f['id'] ? ' selected="selected"' : '' ?>><?php echo $f['format'] ?></option>
				<?php }?>
			</select>
		</div>
		<div class="form-group">
			<label for="title">Stars</label>
			<input type="text" name="stars" id="stars" value="<?php echo !empty($this->movie['stars']) ? implode(',', $this->movie['stars']) : '' ?>" class="form-control" placeholder="Stars" />
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Submit</button>
			<input type="hidden" name="id" value="<?php echo !empty($this->movie['id']) ? $this->movie['id'] : '' ?>" class="form-control" />
		</div>
	</form>
<?php require_once(ROOT.'/views/tpl/footer.php'); ?>