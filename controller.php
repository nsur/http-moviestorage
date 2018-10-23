<?php
class Controller {
	private $successMessage = 'Done!';

	private $message = '';

	private $errors = false;

	public function indexAction() {
		try {
			$this->getView()->index();
		} catch(Exception $e) {
			$this->message = $e->getMessage();
			$this->redirect("/");
		}
	}
	public function editAction($id = 0) {
		try {
			$this->getView()->edit($id);
		} catch(Exception $e) {
			$this->message = $e->getMessage();
			$this->redirect("/movie/edit/$id");
		}
	}
	public function showAction($id) {
		try {
			$this->getView()->show($id);
		} catch(Exception $e) {
			$this->message = $e->getMessage();
			$this->redirect("/movie/show/$id");
		}
	}
	public function deleteAction($id) {
		try {
			$this->getModel()->deleteMovie($id);
		} catch(Exception $e) {
			$this->message = $e->getMessage();
		}
		$this->redirect("/");
	}
	public function saveRequestAction() {
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		try {
			$id = $this->getModel()->saveMovie();
		} catch(Exception $e) {
			$this->message = $e->getMessage();
		}
		$this->redirect("/movie/edit/$id");
	}
	public function uploadAction() {
		$this->getView()->upload();
	}
	public function uploadRequestAction() {
		try {
			$this->getModel()->uploadMovies();
		} catch(Exception $e) {
			$this->message = $e->getMessage();
		}
		$this->redirect("/");
	}
	public function aboutAction() {
		$this->getView()->about();
	}
	public function notFoundAction() {
		$this->getView()->notFound();
	}
	public function getView() {
		return new View();
	}
	public function getModel() {
		return new Model();
	}
	public function redirect($path, $clearMessage = false) {
		$message = !empty($this->message) ? $this->message : $this->successMessage;
		$message = !empty($clearMessage) ? '' : $message;
		$_SESSION['message'] = $message;
		$_SESSION['errors'] = !empty($this->message);
		header("Location: $path");
	}
}