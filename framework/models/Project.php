<?php

class Project
{
	private $projectID;
	private $archive;
	private $archiveName;
	private $economistName;

	function __construct()
	{ }

	private function getProjectID()
	{
		$this->projectID = Session::get("projectID");

		return $this->projectID;
	}

	private function getProjectPath()
	{
		$projectID = $this->getProjectID();

		return PROJECTS_DIR . $projectID . '/';
	}

	private function getArchivePath()
	{
		return $this->getProjectPath() . $this->archiveName;
	}

	private function getEconomistPath()
	{
		return $this->getProjectPath() . 'economist.xlsx';
	}

	// SAVE DATA

	function saveData($temp_detail)
	{
		//d($detail);

		$detail = [];
		foreach ($temp_detail as $key => $field) {
			$detail[strtounder($key)] = $field;
		}

		$detailID = (string)$detail['id'];

		if ($detail['type'] === 'assembly') {
			$detailID = (int)substr($detailID, 5);
			$assemblyDB = DB::queryOne("SELECT * FROM assembly WHERE project_id = {$this->getProjectID()} AND assembly_id = $detailID", [], PDO::FETCH_NAMED);

			foreach ($assemblyDB as $key => $field) {
				if ($key !== 'assembly_id' && $key !== 'project_id' && $key !== 'name' && $key !== 'category' && $key !== 'detail_name') {
					if (strpos($key, 'all') !== false) {
						$keySingle = strstr($key, '_all', true);
						$keySingleValue = $assemblyDB['amount'] * $detail[$keySingle];
						DB::query("UPDATE assembly SET $key = '$keySingleValue' WHERE assembly_id = {$assemblyDB['assembly_id']} AND project_id = {$this->getProjectID()}");
						continue;
					}
					DB::query("UPDATE assembly SET $key = '{$detail[$key]}' WHERE assembly_id = {$assemblyDB['assembly_id']} AND project_id = {$this->getProjectID()}");
				}
			}

			return;
		}

		$assemblyDB = [];
		$assemblySeams = [];
		$detailDB = DB::queryOne("SELECT * FROM detail WHERE project_id = {$this->getProjectID()} AND detail_id = $detailID", [], PDO::FETCH_NAMED);
		$detailHoles = DB::query("SELECT * FROM hole WHERE detail_id =  $detailID", [], PDO::FETCH_NAMED);

		if (!$detailDB) {
			$detailID = (int)substr($detailID, 5);

			$assemblyDB = DB::queryOne("SELECT * FROM assembly WHERE project_id = {$this->getProjectID()} AND assembly_id = $detailID", [], PDO::FETCH_NAMED);
			$assemblySeams = DB::query("SELECT * FROM seam WHERE assembly_id =  $detailID", [], PDO::FETCH_NAMED);
		}


		foreach ($detailHoles as $index => $detailHole) {
			foreach ($detailHole as $key => $field) {
				if ($key !== 'hole_id' && $key !== 'detail_id') {
					if (strpos($key, 'all') !== false) {
						$keySingle = strstr($key, '_all', true);
						$keySingleValue = $detailDB['amount'] * $detail[$keySingle . ($index + 1)];
						DB::query("UPDATE hole SET $key = '$keySingleValue' WHERE hole_id = {$detailHole['hole_id']}");
						continue;
					}
					DB::query("UPDATE hole SET $key = '{$detail[$key . ($index + 1)]}' WHERE hole_id = {$detailHole['hole_id']}");
				}
			}
		}

		foreach ($assemblySeams as $index => $assemblySeam) {
			foreach ($assemblySeam as $key => $field) {
				if ($key !== 'assembly_id' && $key !== 'seam_id') {
					if (strpos($key, 'all') !== false) {
						$keySingle = strstr($key, '_all', true);
						$keySingleValue = $assemblyDB['amount'] * $detail[$keySingle . ($index + 1)];
						DB::query("UPDATE seam SET $key = '$keySingleValue' WHERE seam_id = {$assemblySeam['seam_id']}");
						continue;
					}
					DB::query("UPDATE seam SET $key = '{$detail[$key . ($index + 1)]}' WHERE seam_id = {$assemblySeam['seam_id']}");
				}
			}
		}

		foreach ($assemblyDB as $key => $field) {
			if ($key !== 'assembly_id' && $key !== 'project_id' && $key !== 'name' && $key !== 'category' && $key !== 'detail_name') {
				if (strpos($key, 'all') !== false) {
					$keySingle = strstr($key, '_all', true);
					$keySingleValue = $assemblyDB['amount'] * $detail[$keySingle];
					DB::query("UPDATE assembly SET $key = '$keySingleValue' WHERE assembly_id = {$assemblyDB['assembly_id']} AND project_id = {$this->getProjectID()}");
					continue;
				}
				DB::query("UPDATE assembly SET $key = '{$detail[$key]}' WHERE assembly_id = {$assemblyDB['assembly_id']} AND project_id = {$this->getProjectID()}");
			}
		}

		foreach ($detailDB as $key => $field) {
			if ($key !== 'detail_id' && $key !== 'project_id' && $key !== 'category' && $key !== 'name') {
				if (strpos($key, 'all') !== false) {
					$keySingle = strstr($key, '_all', true);
					$keySingleValue = $detailDB['amount'] * $detail[$keySingle];
					DB::query("UPDATE detail SET $key = '$keySingleValue' WHERE detail_id = {$detailDB['detail_id']} AND project_id = {$this->getProjectID()}");
					continue;
				}
				DB::query("UPDATE detail SET $key = '{$detail[$key]}' WHERE detail_id = {$detailDB['detail_id']} AND project_id = {$this->getProjectID()}");
			}
		}

		//d($detail);
	}


	// GET LIBRARY


	function getLibrary()
	{
		$library = [];

		$detailList = DB::query("SELECT * FROM detail WHERE project_id={$this->getProjectID()}");

		foreach ($detailList as $detailItem) {

			$detailItemFinal = $this->modifyDetail($detailItem, 'detail');

			$detailItemFinal = $this->addHoles($detailItemFinal, $detailItem['detail_id']);


			$library[] = $detailItemFinal;
		}



		$assemblyList = DB::query("SELECT * FROM assembly WHERE project_id={$this->getProjectID()}");
		$assemblyItemFinal = [];


		foreach ($assemblyList as $assemblyItem) {

			if ($assemblyItem['name']) {
				if ($assemblyItemFinal) $library[] = $assemblyItemFinal;
				$assemblyItemFinal = $this->modifyDetail($assemblyItem, 'assembly');
				continue;
			}

			$detailItem = DB::queryOne("SELECT * FROM detail WHERE project_id={$this->getProjectID()} AND name='{$assemblyItem['detail_name']}'");

			foreach ($detailItem as $detailItemKey => $detailItemValue) {
				if ($detailItemKey === 'category') continue;
				if (array_key_exists($detailItemKey, $assemblyItem)) $detailItem[$detailItemKey] = $assemblyItem[$detailItemKey];
			}

			foreach ($assemblyItem as $assemblyItemKey => $assemblyItemValue) {
				if (!array_key_exists($assemblyItemKey, $detailItem)) $detailItem[$assemblyItemKey] = $assemblyItemValue;
			}

			$detailItemFinal = $this->modifyDetail($detailItem, 'detail');
			//$detailItemFinal = $this->addHoles($detailItemFinal, $detailItem['detail_id']);
			$detailItemFinal = $this->addSeams($detailItemFinal, $assemblyItem['assembly_id']);

			$assemblyItemFinal['children'][] = $detailItemFinal;
		}


		$hardwareList = DB::query("SELECT name, gost, amount, weight, weight_thousand, note FROM hardware WHERE project_id={$this->getProjectID()}", [], PDO::FETCH_NUM);

		$hardware = [];

		if (count($hardwareList)) {
			$hardware['id'] = '-100';
			$hardware['type'] = 'hardware';
			$hardware['component'] = 'ContentHardware';
			$hardware['name'] = 'метизы';
			$hardware['category'] = 'метизы';
			$hardware['children'] = $hardwareList;
			$library[] = $hardware;
		}


		return $library;
	}


	private function modifyDetail($detail, $type)
	{
		$detailFinal = [];

		foreach ($detail as $fieldName => $fieldValue) {
			if (is_numeric($fieldName)) continue;

			$fieldNameFinal = strtocamel($fieldName);

			if ($fieldName === 'detail_id') $fieldNameFinal = 'id';
			if ($fieldName === 'detail_name' && !$detail['name']) $fieldNameFinal = 'name';
			if ($fieldName === 'assembly_id') {
				$fieldNameFinal = 'id';
				$fieldValue = '10000' . $fieldValue;
			}
			if ($fieldName === 'project_id' || $fieldName === 'link') continue;

			$detailFinal[$fieldNameFinal] = $fieldValue;
		}

		$detailFinal['type'] = $type;

		if ($type === 'gg') {
			$detailFinal['component'] = 'asd';
		} else {
			$detailFinal['component'] = 'ContentCommon';
		}


		return $detailFinal;
	}

	private function addHoles($detail, $detailID)
	{
		$holes = DB::query("SELECT * FROM hole WHERE detail_id = $detailID");

		foreach ($holes as $holeIndex => $hole) {
			foreach ($hole as $holeKey => $holeValue) {
				if (is_numeric($holeKey)) continue;
				if ($holeKey === 'hole_id' || $holeKey === 'detail_id') continue;

				$holeKey = strtocamel($holeKey . ($holeIndex + 1));
				$detail[$holeKey] = $holeValue;
			}
		}

		return $detail;
	}

	private function addSeams($assembly, $assemblyID)
	{
		$seams = DB::query("SELECT * FROM seam WHERE assembly_id = $assemblyID");

		foreach ($seams as $seamIndex => $seam) {
			foreach ($seam as $seamKey => $seamValue) {
				if (is_numeric($seamKey)) continue;
				if ($seamKey === 'seam_id' || $seamKey === 'assembly_id') continue;

				$seamKey = strtocamel($seamKey . ($seamIndex + 1));
				$assembly[$seamKey] = $seamValue;
			}
		}

		return $assembly;
	}

	// GET MATERIALS

	function getMaterials()
	{
		$detailList = DB::query("SELECT * FROM detail WHERE project_id = {$this->getProjectID()}");

		$materialUniqueList = [];


		foreach ($detailList as $detailItem) {
			$steel = $detailItem['steel'];
			$stuff = $detailItem['stuff'];
			$thickness = $detailItem['thickness'];
			$key = $steel . $stuff . $thickness;

			$materialUniqueList[$key][] = $detailItem;
		}

		ksort($materialUniqueList);
		$materials = [];
		$counter = 0;

		foreach ($materialUniqueList as $materialUniqueKey => $materialList) {
			$materials[$counter][] = $materialList[0]['stuff'];
			$materials[$counter][] = $materialList[0]['steel'];
			$materials[$counter][] = $materialList[0]['thickness'];

			$materialWeight = 0;
			$materialRefusal = $this->getEconomistRefusal($materialList[0]['stuff']);
			$materialRefusal = $this->neutralizeEconomistRefusal($materialRefusal);

			foreach ($materialList as $materialItem) {
				$materialWeight += $materialItem['weight_all'];
			}

			$materialWeight = round($materialWeight, 2);
			$materialWeightRefusal = round($materialWeight + $materialWeight * $materialRefusal, 2);
			if ($materialRefusal === false) {
				$materialWeightRefusal = 0;
			}

			$materials[$counter][] = $materialWeight;
			$materials[$counter][] = $materialWeightRefusal;

			$counter++;
		}

		return $materials;
	}


	// GET LABOR

	function getLaborCosts()
	{
		$economistExcel = new ExcelAdapter($this->getProjectPath() . 'economist.xlsx');
		$economistTable = $economistExcel->getSystemSheet();

		$laborCosts = [];

		$materialList = [
			'профиль лстк' => [
				'rolling' => ['length', 'G4'],
				'drilling' => ['holeCircle', 'G5', 'holeOval', 'G6']
			],
			'оц' => [],
			'лист' => [
				'cutting' => ['amount', 'G12'],
				'drilling' => ['holeCircle', 'G16', 'holeOval', 'G6'],
				'painting' => ['square', 'G24', 'square', 'G26']
			],
			'сборка' => [
				'welding' => ['seam', 'G37'],
				'assembly' => ['amount', 'G43']
			],
			'уголок' => [
				'drilling' => ['holeCircle', 'G23', 'holeOval', 'G6'],
				'painting' => ['square', 'G25', 'square', 'G26']
			],
			'двутавр' => [
				'cutting' => ['length', 'G22'],
				'drilling' => ['holeCircle', 'G17', 'holeOval', 'G6'],
				'painting' => ['square', 'G24', 'square', 'G26']
			],
			'швеллер' => [
				'cutting' => ['length', 'G22'],
				'drilling' => ['holeCircle', 'G16', 'holeOval', 'G6'],
				'painting' => ['square', 'G24', 'square', 'G26']
			],
			'труба кв.' => [
				'drilling' => ['holeCircle', 'G50', 'holeOval', 'G6'],
				'painting' => ['square', 'G52', 'square', 'G53']
			],
			'профиль(кв.)' => [
				'drilling' => ['holeCircle', 'G56', 'holeOval', 'G6'],
				'painting' => ['square', 'G58', 'square', 'G59']
			],
			'профиль(пр.)' => [
				'drilling' => ['holeCircle', 'G62', 'holeOval', 'G6'],
				'painting' => ['square', 'G64', 'square', 'G65']
			],
		];

		$operationList = ['rolling', 'cutting', 'drilling', 'welding', 'assembly', 'painting'];

		foreach ($materialList as $materialKey => $materialItem) {
			$laborTotal = 0;
			$laborCosts[$materialKey]['type'] = $materialKey;
			$laborCosts[$materialKey]['length'] = round($this->getSumLength($materialKey) / 1000, 2);
			$laborCosts[$materialKey]['amount'] = $this->getSumAmount($materialKey);
			$laborCosts[$materialKey]['seam'] = $this->getSumSeam($materialKey);
			$laborCosts[$materialKey]['holeCircle'] = $this->getSumHoleCircle($materialKey);
			$laborCosts[$materialKey]['holeOval'] = $this->getSumHoleOval($materialKey);
			$laborCosts[$materialKey]['square'] = $this->getSumSquare($materialKey);

			foreach ($operationList as $operationItem) {
				$value = 0;

				if (key_exists($operationItem, $materialItem)) {
					$field = $laborCosts[$materialKey][$materialItem[$operationItem][0]];
					$cell = $economistTable->getCell($materialItem[$operationItem][1]);
					$field2 = 0;
					$cell2 = 0;

					if ($operationItem === 'painting') {
						$field2 = $laborCosts[$materialKey][$materialItem[$operationItem][2]];
						$cell2 = $economistTable->getCell($materialItem[$operationItem][3]);
					}

					if ($this->notZero($field, $cell)) {
						$value = round($field / $cell, 2);
					}

					if ($this->notZero($field2, $cell2)) {
						$value += round($field2 / $cell2, 2);
					}
				}

				$laborCosts[$materialKey]['labor' . ucfirst($operationItem)] = $value;
			}


			foreach ($laborCosts[$materialKey] as $laborCostsKey => $laborCostsItem) {
				if (strpos($laborCostsKey, 'labor') === 0) $laborTotal += $laborCostsItem;
			}

			$laborCosts[$materialKey]['laborTotal'] = round($laborTotal, 2);

			if (count($laborCosts[$materialKey]) === count(array_filter($laborCosts[$materialKey], function ($item, $key) {
				if ($key === 'type') return true;
				return (int)$item === 0;
			}, ARRAY_FILTER_USE_BOTH))) {
				unset($laborCosts[$materialKey]);
			}
		}



		$laborHours = 0;
		$laborDays = 0;

		foreach ($laborCosts as $laborCostsCol) {
			$laborHours += $laborCostsCol['laborTotal'];
		}

		$laborHours = round($laborHours, 2);

		foreach ($laborCosts as $laborCostsCol) {
			$laborDays += $laborCostsCol['laborTotal'];
		}

		$laborDays = round($laborDays / 8, 2);

		return [
			'laborCosts' => $laborCosts,
			'laborHours' => $laborHours,
			'laborDays' => $laborDays,
		];
	}

	private function getSumLength($category)
	{
		if ($category === 'профиль лстк')
			return round(DB::queryOne("SELECT SUM(length) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category' AND name NOT LIKE 'Оц%'"), 2);

		elseif ($category === 'оц')
			return round(DB::queryOne("SELECT SUM(length) FROM detail WHERE project_id={$this->getProjectID()} AND category='профиль лстк' AND name LIKE 'Оц%'"), 2);

		else return round(DB::queryOne("SELECT SUM(length) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'"), 2);
	}

	private function getSumAmount($category)
	{
		if ($category === 'сборка') {
			return DB::queryOne("SELECT SUM(amount) FROM assembly WHERE detail_name IS NULL AND project_id={$this->getProjectID()}");
		}

		if ($category === 'профиль лстк')
			return round(DB::queryOne("SELECT SUM(amount) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category' AND name NOT LIKE 'Оц%'"), 2);

		elseif ($category === 'оц')
			return round(DB::queryOne("SELECT SUM(amount) FROM detail WHERE project_id={$this->getProjectID()} AND category='профиль лстк' AND name LIKE 'Оц%'"), 2);

		else return round(DB::queryOne("SELECT SUM(amount) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'"), 2);
	}

	private function getSumSquare($category)
	{
		if ($category === 'профиль лстк')
			return round(DB::queryOne("SELECT SUM(square_all) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category' AND name NOT LIKE 'Оц%'"), 2);

		elseif ($category === 'оц')
			return round(DB::queryOne("SELECT SUM(square_all) FROM detail WHERE project_id={$this->getProjectID()} AND category='профиль лстк' AND name LIKE 'Оц%'"), 2);

		else return round(DB::queryOne("SELECT SUM(square_all) FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'"), 2);
	}

	private function getSumHoleCircle($category)
	{
		if ($category === 'профиль лстк')
			$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category' AND name NOT LIKE 'Оц%'");

		elseif ($category === 'оц')
			$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='профиль лстк' AND name LIKE 'Оц%'");

		else $detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'");
		$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'");

		$sumHoleCircle = 0;

		foreach ($detailList as $detailID) {
			$sumHoleCircle += DB::queryOne("SELECT SUM(hole_amount_all) as sumHoleCircle FROM hole WHERE detail_id={$detailID[0]} AND hole_diameter != 0");
		}

		return round($sumHoleCircle, 2);
	}

	private function getSumHoleOval($category)
	{
		if ($category === 'профиль лстк')
			$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category' AND name NOT LIKE 'Оц%'");

		elseif ($category === 'оц')
			$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='профиль лстк' AND name LIKE 'Оц%'");

		else $detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'");
		$detailList = DB::query("SELECT detail_id FROM detail WHERE project_id={$this->getProjectID()} AND category='$category'");

		$sumHoleOval = 0;

		foreach ($detailList as $detailID) {
			$sumHoleOval += DB::queryOne("SELECT SUM(hole_amount_all) as sumHoleOval FROM hole WHERE detail_id={$detailID[0]} AND hole_oval_x != 0");
		}

		return round($sumHoleOval, 2);
	}

	private function getSumSeam($category)
	{
		if ($category === 'сборка') {
			$assemblyListID = DB::query("SELECT assembly_id FROM assembly WHERE project_id={$this->getProjectID()}", [], PDO::FETCH_NUM);

			$sumSeamLength = 0;

			foreach ($assemblyListID as $assemblyID) {
				$sumSeamLength += DB::queryOne("SELECT SUM(seam_length_all) FROM seam WHERE assembly_id = $assemblyID[0]");
			}

			return round($sumSeamLength, 2);
		} else return 0;
	}

	function notZero(...$vars)
	{
		return count($vars) === count(array_filter($vars, function ($item) {
			return (int)$item !== 0;
		}));
	}





	// CREATE PROJECT

	function create($archive)
	{
		$this->archive = $archive;

		$this->checkArchive();
		$this->initProject();
		$this->parseArchive();
		$this->loadProjectData();
	}

	private function checkArchive()
	{
		if (!preg_match('~\.zip|\.rar$~', $this->archive['name'])) {
			d('неверное расширение у файла');
			exit;
		};

		

		if ($this->archive['size'] > 1024 * 1024 * 30) {
			d('файл слишком большого размера');
			exit;
		}

		return '';
	}


	private function initProject()
	{

		$this->archiveName = basename($this->archive['name']);

		$projectName =  filename($this->archive['name']); // имя проекта это имя архива

		DB::query("INSERT INTO project(project_id, project_name) VALUES({$this->getProjectID()}, '$projectName')");

		if (is_dir($this->getProjectPath())) {
			d('директория с проектом уже существует');
			exit;
		}

		mkdir($this->getProjectPath());

		if (move_uploaded_file($this->archive['tmp_name'], $this->getArchivePath())) {
			return '';
		} else {
			d('не удалось загрузить архив');
			exit;
		}
	}

	private function parseArchive()
	{

		$zip = zip_open($this->getArchivePath()); // открывает zip

		if ($zip) {

			$counter = 0;

			while ($zipEntry = zip_read($zip)) {
				$ext = ext(zip_entry_name($zipEntry)); // расширение файла
				$filename = filename(zip_entry_name($zipEntry)); // имя файла без расширения
				$pdf = substr($filename, 0, 4); // числовой идентификатор pdf файла
				$filesize = zip_entry_filesize($zipEntry); // размер файла в байтах
				$filepath = null;

				if ($ext !== 'pdf' && $ext !== 'xlsx') continue;

				if (zip_entry_open($zip, $zipEntry)) {
					$content = zip_entry_read($zipEntry, $filesize);

					if ($ext === 'pdf') {
						$filepath = $this->getProjectPath() . $pdf . '.' . $ext;
					} elseif ($ext === 'xlsx') {
						if (strpos($filename, 'detail') !== false) {
							$filepath = $this->getProjectPath() . 'detail.xlsx';
						} elseif (strpos($filename, 'assembly') !== false) {
							$filepath = $this->getProjectPath() . 'assembly.xlsx';
						} elseif (strpos($filename, 'fixing') !== false) {
							$filepath = $this->getProjectPath() . 'fixing.xlsx';
						}


						$counter++;
					}

					if ($filepath)
						file_put_contents($filepath, $content);

					zip_entry_close($zipEntry);
				}
			}

			zip_close($zip);
		} else {
			d("не получилось открыть архив проекта");
		}
	}

	private function loadProjectData()
	{

		$detailExcel = new ExcelAdapter($this->getExcelFilename('detail'));
		$detailSheet = $detailExcel->getSheet();

		$this->loadProjectTable('detail', $detailSheet);

		$assemblyExcel = new ExcelAdapter($this->getExcelFilename('assembly'));
		$assemblySheet = $assemblyExcel->getSheet();

		$this->loadProjectTable('assembly', $assemblySheet);

		$hardwareExcel = new ExcelAdapter($this->getExcelFilename('fixing'));
		$hardwareSheet = $hardwareExcel->getSheet();

		$this->loadProjectTable('hardware', $hardwareSheet);
	}

	private function getExcelFilename($filename)
	{
		return $this->getProjectPath() . $filename . '.xlsx';
	}

	private function loadProjectTable($table, $sheet)
	{
		$detailCols = DB::cols($table);
		$assemblyAmount = 1;

		foreach ($sheet as $row) {

			$queryStr = '';
			$rowFinal = $this->modifyRow($row, $table);

			if ($this->checkRow($rowFinal, $table) === 'detail' || $this->checkRow($rowFinal, $table) === 'hardware') {
				if (key_exists('detail_name', $rowFinal)) {
					if ($rowFinal['name'] !== null) {
						$assemblyAmount = $rowFinal['amount'];
					} else {
						$rowFinal['amount'] *= $assemblyAmount;
					}
				}

				if (key_exists('scheme', $rowFinal)) {
					$rowFinal['scheme'] = '/projects/' . $this->getProjectID() . '/' . substr($rowFinal['scheme'], 0, 4) . '.pdf';
				}

				foreach ($detailCols as $detailCol) {
					$detailField = $detailCol['Field'];
					$detailType = $detailCol['Type'];

					if (array_key_exists($detailField, $rowFinal)) {
						if ($rowFinal[$detailField] === null) {
							$queryStr .= "$detailField=NULL,";
						} elseif (preg_match('/varchar/', $detailType))
							$queryStr .= "$detailField='{$rowFinal[$detailField]}',";
						else
							$queryStr .= "$detailField={$rowFinal[$detailField]},";
					}
				}


				if ($table === 'detail') {
					$stuff = $rowFinal['category'] === 'профиль лстк' ? 'штрипса' : $rowFinal['category'];
					$queryStr .= "stuff='$stuff',";

					$thickness = NULL;

					if (preg_match("~[0-9]+\.[0-9]+~", $rowFinal['profile'], $matches)) {
						$thickness = $matches[0];
					}

					if (mb_stripos($rowFinal['profile'], $rowFinal['category']) !== false) {
						$thickness = mb_substr($rowFinal['profile'], mb_strlen($rowFinal['category']));
					}

					if (is_numeric($rowFinal['profile'][1]) && $rowFinal['profile'][0] === '-')
						$thickness = mb_strstr($rowFinal['profile'], " ", true);

					if (is_null($thickness)) $queryStr .= "thickness=NULL,";
					else $queryStr .= "thickness='$thickness',";
				}



				$queryStr .= "project_id={$this->getProjectID()}";
				DB::query("INSERT INTO $table SET $queryStr");


				if ($table === 'detail') {
					$hole = array_filter($rowFinal, function ($key) {
						return strpos($key, 'hole') === 0;
					}, ARRAY_FILTER_USE_KEY);
					$this->loadProjectHole($hole);
				}

				if ($table === 'assembly') {
					$seam = array_filter($rowFinal, function ($key) {
						return strpos($key, 'seam') === 0;
					}, ARRAY_FILTER_USE_KEY);
					$this->loadProjectSeam($seam);
				}
			} elseif ($this->checkRow($rowFinal, $table) === 'hole') {
				$hole = array_filter($rowFinal, function ($key) {
					return strpos($key, 'hole') === 0;
				}, ARRAY_FILTER_USE_KEY);
				$this->loadProjectHole($hole);
			} elseif ($this->checkRow($rowFinal, $table) === 'seam') {
				$seam = array_filter($rowFinal, function ($key) {
					return strpos($key, 'seam') === 0;
				}, ARRAY_FILTER_USE_KEY);
				$this->loadProjectSeam($seam);
			}
		}
	}

	private function modifyRow($row, $table)
	{
		if ($table === 'detail') $excelAlias = Config::get('excelDetailAlias');
		elseif ($table === 'assembly') $excelAlias = Config::get('excelAssemblyAlias');
		elseif ($table === 'economist') $excelAlias = Config::get('excelEconomistAlias');
		elseif ($table === 'hardware') $excelAlias = Config::get('excelHardwareAlias');

		$resultRow = [];

		$toLower = ['category'];

		foreach ($excelAlias as $index => $alias) {
			if (in_array($alias, $toLower)) $row[$index] = mb_strtolower($row[$index]);

			$resultRow[$alias] = $row[$index];
		}

		return $resultRow;
	}

	private function checkRow($row, $table)
	{
		if ($table === 'hardware') {
			if (is_numeric($row['amount']) && is_numeric($row['weight'])) return 'hardware';
			else return false;
		}


		if (is_numeric($row['length']) && is_numeric($row['width']) && is_numeric($row['height'])) return 'detail';

		if ($table === 'detail')
			if (is_numeric($row['hole_diameter']) || is_numeric($row['hole_oval_x'])) return 'hole';

		if ($table === 'assembly')
			if (is_numeric($row['seam_side']) && !is_null($row['seam_side']) && is_numeric($row['seam_length']) && !is_null($row['seam_length'])) return 'seam';


		return false;
	}

	private function loadProjectHole($hole)
	{
		$detailID = DB::queryOne("SELECT MAX(detail_id) FROM detail WHERE project_id = {$this->getProjectID()}");

		$queryStr = '';

		foreach ($hole as $holeKey => $holeValue) {
			if ($hole[$holeKey] === NULL) {
				$queryStr .= "$holeKey=NULL,";
			} else {
				$queryStr .= "$holeKey=$holeValue,";
			}
		}

		$queryStr .= "detail_id=$detailID";

		DB::query("INSERT INTO hole SET $queryStr");
	}

	private function loadProjectSeam($seam)
	{
		$assemblyID = DB::queryOne("SELECT MAX(assembly_id) FROM assembly WHERE project_id = {$this->getProjectID()}");

		$queryStr = '';

		foreach ($seam as $seamKey => $seamValue) {
			if ($seam[$seamKey] === NULL) {
				$queryStr .= "$seamKey=NULL,";
			} else {
				$queryStr .= "$seamKey=$seamValue,";
			}
		}

		$queryStr .= "assembly_id=$assemblyID";

		DB::query("INSERT INTO seam SET $queryStr");
	}

	// REMOVE PROJECT

	function remove()
	{
		DB::query("DELETE FROM project WHERE project_id={$this->getProjectID()}");

		rrmdir($this->getProjectPath());
	}

	// ECONOMIST 

	function loadEconomist($economistFile)
	{
		$economistFileExt = ext($economistFile['name']);
		$this->economistName = 'economist.' . $economistFileExt;

		if (move_uploaded_file($economistFile['tmp_name'], $this->getEconomistPath())) {

			$economistExcel = new ExcelAdapter($this->getEconomistPath());
			$economistTable = $economistExcel->getSheet();

			foreach ($economistTable as $economistIndex => $economistRow) {
				$economistRowFinal = $this->modifyRow($economistRow, 'economist');

				if ($this->checkRowEconomist($economistRowFinal, $economistIndex)) { }
			}
		} else {
			d('не удалось загрузить экономист');
			exit;
		}
	}



	private function checkRowEconomist($row, $index)
	{
		if (count($row) === count(array_filter($row, 'is_null'))) return false;

		if (is_numeric($row['work_rate_hour']) || $index > 2) return true;

		return false;
	}

	private function getEconomistRefusal($stuff)
	{
		$economistExcel = new ExcelAdapter($this->getEconomistPath());
		$economistTable = $economistExcel->getSheet();

		foreach ($economistTable as $economistIndex => $economistRow) {
			$index = key($economistTable);
			$economistRowFinal = $this->modifyRow($economistRow, 'economist');

			if ($this->checkRowEconomist($economistRowFinal, $economistIndex)) {
				if (strpos($stuff, $economistRowFinal['stuff']) !== false) return $economistRowFinal['refusal'];
			}
		}
	}

	private function neutralizeEconomistRefusal($refusal)
	{
		if (($percent = strstr($refusal, '%', true)) !== false) {
			if ((int)$percent !== 0) return round($percent / 100, 2);
			else return false;
		} else return false;
	}
}