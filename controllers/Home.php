<?php

namespace Controller;

defined("ROOTPATH") OR exit('Доступ запрещен!');

class Home
{
    use MainController;
    public function index(): void
    {
        $result = \ParamHandler::getInstance("../data_cars.json", "../data_attempts.json");
        $result->addResultsId();
        $data['res'] = $result->arrivals();

        if (array_key_exists('export_csv', $_POST)) {
            $result->arrayToCsvDownload($data['res']);
        }

        if (array_key_exists('refresh', $_POST)) {
            redirect();
        }

        $this->view('home', $data);
    }
}