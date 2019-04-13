<?php

class TechnologistController extends Controller
{
	private $project_path;
	private $project_name;
	private $archive_path;

	function indexAction()
	{
		$auth_id = Request::get('AUTH_ID');
		Session::set('auth_id', $auth_id);

		d($_REQUEST);

		Response::render();
	}

	function installAction()
	{

		$res = rest_req('placement.bind', [
			'auth' => Session::get('auth_id'),
			'PLACEMENT' => 'SONET_GROUP_DETAIL_TAB',
			'HANDLER' => 'https://' . Request::getServer('server_name') . '/technologist/project/index',
			'TITLE' => 'ТЕХНОЛОГ'
		]);

		Logger::log($res);

		Response::sendJSON($res);
	}


	function projectAction($action = null, $compute = null)
	{

		if ($action === 'get' && $compute === null) {
			$project = new Project();
			$library = $project->getLibrary();


			Response::sendJSON($library);
		} elseif ($action === 'create' && $compute === null) {

			$archive = Request::getFile('project');

			$project = new Project();
			$project->create($archive);


			Response::sendJSON([
				'result' => 'проект успешно создан'
			]);
		} elseif ($action === 'index' && $compute === null) {
			$place_opt = Request::getJSON('PLACEMENT_OPTIONS');

			Session::set('projectID', $place_opt['GROUP_ID']);

			Response::render(['title' => 'hello wolrd']);
		} elseif ($action === 'remove' && $compute === null) {
			$project = new Project();
			$project->remove();

			Response::sendJSON(['result' => 'проект успешно удален']);
		} elseif ($action === 'save' && $compute === null) {
			$project = new Project();

			$detail = Request::getJSON('detail');
			$project->saveData($detail);

			Response::sendJSON(['result' => 'данные успешно сохранены']);
		} elseif ($action === 'load-economist' && $compute === null) {
			$economist = Request::getFile('economist');

			$project = new Project();
			$project->loadEconomist($economist);

			Response::sendJSON(['result' => 'нормы экономиста успешно загружены']);
		} elseif ($action === 'compute' && $compute === 'materials') {
			$project = new Project();
			$materials = $project->getMaterials();

			Response::sendJSON([
				'data' => $materials,
				'result' => 'материалы успешно загружены'
			]);
		} elseif ($action === 'compute' && $compute === 'labor-costs') {
			$project = new Project();
			$laborCosts = $project->getLaborCosts();

			Response::sendJSON([
				'data' => $laborCosts,
				'result' => 'трудозатраты успешно загружены'
			]);
		}
	}

	function configAction($config)
	{
		if ($config === 'fields') {
			$fields = Config::get('fields');

			Response::sendJSON($fields);
		}
	}
}
