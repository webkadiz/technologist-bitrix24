<?php

namespace app\components;


class ExcelAdapter
{
	private $excelPath;
	private $excelDescriptor;
	private $systemSheet;
	private $isLoaded;

	function __construct($excelPath)
	{
		$this->excelPath = $excelPath;

		$this->load();
	}

	private function load()
	{
		if (file_exists($this->excelPath)) {
			$this->excelDescriptor = \PHPExcel_IOFactory::load($this->excelPath);
			$this->isLoaded = true;
		} else {
			throw new \Exception($this->excelPath . " - такого файла не существует");
		}
	}

	function getSheet($index = 0)
	{
		if (!$this->isLoaded) return [];

		foreach ($this->excelDescriptor->getWorksheetIterator() as $worksheet) {
			$worksheets[] = $worksheet->toArray();
		}

		return $worksheets[$index];
	}

	function getSystemSheet($index = 0)
	{
		if (!$this->isLoaded) return clone $this;

		foreach ($this->excelDescriptor->getWorksheetIterator() as $worksheet) {
			$worksheets[] = $worksheet;
		}

		$clone = clone $this;

		$clone->systemSheet = $worksheets[$index];

		return $clone;
	}

	function getSheets()
	{
		if (!$this->isLoaded) return [];

		foreach ($this->excelDescriptor->getWorksheetIterator() as $worksheet) {
			$worksheets[] = $worksheet->toArray();
		}

		return $worksheets;
	}

	function getSystemSheets()
	{
		if (!$this->isLoaded) return [];

		foreach ($this->excelDescriptor->getWorksheetIterator() as $worksheet) {
			$worksheets[] = $worksheet;
		}

		return $worksheets;
	}

	function getCell($cell)
	{
		if (!$this->isLoaded) return false;

		if ($this->systemSheet) {
			return $this->systemSheet->getCell($cell)->getCalculatedValue();
		} else return false;
	}
}
