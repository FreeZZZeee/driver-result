<?php

abstract class ParamHandler
{
    protected array $dataCars;
    protected array $dataAttempts;
    protected array $resultsId;
    public array $data = [];

    public function __construct()
    {
    }

    public static function getInstance(string $fileName, string $fileName1): ParamHandler|Exception
    {
        if (preg_match("/\.json$/i", $fileName) && preg_match("/\.json$/i", $fileName1))
        {
            return new CompetitionResult($fileName, $fileName1);
        }

        return new \Exception("Должен быть json файл");
    }

    abstract function arrivals(): array;
    abstract function addResultsId(): void;
    abstract function sumResult($num1, $num2, $num3, $num4): string;
    abstract function arrayToCsvDownload($array, $filename = "export.csv", $delimiter=","): void;
}