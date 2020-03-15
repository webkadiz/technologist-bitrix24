<?php

use pl\core\{Config, Controller, Session, Request, Logger, Response, Router};
use pl\util\Util;
use app\components\{Project, RestApi};

class TechnologistController extends Controller
{
	function __construct() {
		parent::__construct();
		
		if(PL_DEV)
			$this->resolveCORS();
	}

	function resolveCORS()
	{
		header('Access-Control-Allow-Origin: *');
	}

	function indexAction()
	{

		$auth_id = Request::get('AUTH_ID');
		Session::set('auth_id', $auth_id);

		$this->renderPartial();

	}

	function installAction()
	{
		$res = RestApi::makeRequest('placement.bind', [
			'auth' => Session::get('auth_id'),
			'PLACEMENT' => 'SONET_GROUP_DETAIL_TAB',
			'HANDLER' => Request::getServer('request_scheme') . '://' . Request::getServer('server_name') . Config::get('project_handle_url'),
			'TITLE' => Config::get('app_title')
		]);

		Logger::logVarDump($res);
		Session::unset('auth_id');

		$this->sendJSON($res);

	}


	function indexProjectAction() {

		$place_opt = Request::getJSON('PLACEMENT_OPTIONS');

		Session::set('projectID', $place_opt['GROUP_ID']);
		$this->setViewPath(Router::getController() . '/project');

		$this->renderPartial();

	}

	function createProjectAction() {

		$archive = $_FILES['project'];


		$project = new Project();
		$project->create($archive);


		$this->sendJSON([
			'result' => 'проект успешно создан'
		]);

	}

	function getProjectAction() {

		$project = new Project();
		$library = $project->getLibrary();

		$this->sendJSON($library);

	}

	function saveProjectAction() {

		$project = new Project();

		$detail = Request::getJSON('detail');
		$project->saveData($detail);

		$this->sendJSON(['result' => 'данные успешно сохранены']);

	}

	function removeProjectAction() {

		$project = new Project();
		$project->remove();

		$this->sendJSON(['result' => 'проект успешно удален']);

	}

	function loadEconomistAction() {

		$economist = $_FILES['economist'];

		$project = new Project();
		$project->loadEconomist($economist);

		$this->sendJSON(['result' => 'нормы экономиста успешно загружены']);

	}

	function computeMaterialsAction() {

		$project = new Project();
		$materials = $project->getMaterials();

		$this->sendJSON([
			'data' => $materials,
			'result' => 'материалы успешно загружены'
		]);

	}

	function computeLaborCostsAction() {

		$project = new Project();
		$laborCosts = $project->getLaborCosts();

		$this->sendJSON([
			'data' => $laborCosts,
			'result' => 'трудозатраты успешно загружены'
		]);

	}

	function getFieldsAction()
	{

		$fields = require PL_BASE_DIR . '/data/fields-for-cards.php';

		$this->sendJSON($fields);

	}
}
