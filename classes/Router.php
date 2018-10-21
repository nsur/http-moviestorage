<?php
class Router {
	private  $routes;

	public function __construct() {
		$this->routes = include(ROOT.'/config/routes.php');
	}

	public function init() {
		$url = $this->getUrl();
		$controllerFile = ROOT.'/controller.php';
		if(file_exists($controllerFile)) {
			include $controllerFile;
			$controllerObject = new Controller();
			foreach($this->routes as $urlPattern => $action) {
				if(preg_match("/^$urlPattern$/", $url, $matches)) {
					$actionName = $action.'Action';
					$parameters = !empty($matches[1]) ? array('id' => $matches[1]) : array();
					call_user_func_array(array($controllerObject, $actionName), $parameters);
					return true;
				}
			}
			$controllerObject->redirect('/404', true);
		}
	}

	private function getUrl() {
		if(!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
		return '';
	}
}