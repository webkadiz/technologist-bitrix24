<?php

use pl\core\{Config, Controller, Session, Request, Logger, Response};
use pl\util\Util;
use app\components\{Project, RestApi};

class TechnologistController extends Controller
{

	function resolveCORS()
	{
		header('Access-Control-Allow-Origin: *');
	}

	function indexAction()
	{
		$this->resolveCORS();

		$auth_id = Request::get('AUTH_ID');
		Session::set('auth_id', $auth_id);

		$this->renderPartial();
	}

	function installAction()
	{
		$this->resolveCORS();

		$res = RestApi::makeRequest('placement.bind', [
			'auth' => Session::get('auth_id'),
			'PLACEMENT' => 'SONET_GROUP_DETAIL_TAB',
			'HANDLER' => Request::getServer('request_scheme') . '://' . Request::getServer('server_name') . '/technologist/project/index',
			'TITLE' => Config::get('app_title')
		]);
		
		Logger::logVarDump($res);
		Session::unset('auth_id');

		$this->sendJSON($res);
	}


	function projectAction($action = null, $compute = null)
	{
		$this->resolveCORS();

		if ($action === 'get' && $compute === null) {
			$project = new Project();
			$library = $project->getLibrary();

			$this->sendJSON($library);
		} elseif ($action === 'create' && $compute === null) {

			$archive = $_FILES['project'];


			$project = new Project();
			$project->create($archive);


			$this->sendJSON([
				'result' => 'проект успешно создан'
			]);
		} elseif ($action === 'index' && $compute === null) {
			//$place_opt = Request::getJSON('PLACEMENT_OPTIONS');

			//Session::set('projectID', $place_opt['GROUP_ID']);

			$this->renderPartial(['title' => 'hello wolrd']);
		} elseif ($action === 'remove' && $compute === null) {
			$project = new Project();
			$project->remove();

			$this->sendJSON(['result' => 'проект успешно удален']);
		} elseif ($action === 'save' && $compute === null) {
			$project = new Project();

			$detail = Request::getJSON('detail');
			$project->saveData($detail);

			Response::sendJSON(['result' => 'данные успешно сохранены']);
		} elseif ($action === 'load-economist' && $compute === null) {
			$economist = $_FILES['economist'];

			$project = new Project();
			$project->loadEconomist($economist);

			$this->sendJSON(['result' => 'нормы экономиста успешно загружены']);
		} elseif ($action === 'compute' && $compute === 'materials') {
			$project = new Project();
			$materials = $project->getMaterials();

			$this->sendJSON([
				'data' => $materials,
				'result' => 'материалы успешно загружены'
			]);
		} elseif ($action === 'compute' && $compute === 'labor-costs') {
			$project = new Project();
			$laborCosts = $project->getLaborCosts();

			$this->sendJSON([
				'data' => $laborCosts,
				'result' => 'трудозатраты успешно загружены'
			]);
		}
	}

	function apiGetFieldsAction()
	{
		$this->resolveCORS();

		$fields = require PL_BASE_DIR . '/data/fields-for-cards.php';

		$this->sendJSON($fields);
	}
}
