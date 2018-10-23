<?php
class View {
	public function index($search = '') {
		$search = !empty($_GET['s']) ? $_GET['s'] : '';
		$this->movies = $this->getModel()->getAllMovies($search);
		include ROOT.'/views/tpl/index.php';
	}
	public function edit($id) {
		$this->movie = $this->getModel()->getMovieById($id);
		$this->yearsRange = range(1900, date('Y'));
		$this->formats = $this->getModel()->getFormats();
		include ROOT.'/views/tpl/edit.php';

	}
	public function show($id) {
		$this->movie = $this->getModel()->getMovieById($id);
		include ROOT.'/views/tpl/show.php';
	}
	public function upload() {
		$sampleContent = file_get_contents(ROOT.'/sample_movies.txt');
		$this->sample = !empty($sampleContent) ? '<pre>'.$sampleContent.'</pre>' : '';
		include ROOT.'/views/tpl/upload.php';
	}
	public function about() {
		include ROOT.'/views/tpl/about.php';
	}
	public function notFound() {
		include ROOT.'/views/tpl/404.php';
	}
	public function getModel() {
		return new Model();
	}
} 