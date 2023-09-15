<?php

class CompetitionResult extends ParamHandler
{
    public function __construct($dataCars, $dataAttempts)
    {
        $dataCars = json_decode(file_get_contents($dataCars), true);
        $dataAttempts = json_decode(file_get_contents($dataAttempts), true);
        $this->dataCars = $dataCars;
        $this->dataAttempts = $dataAttempts;
    }

    public function addResultsId(): void
    {
        foreach ($this->dataAttempts['data'] as $results) {
            $this->resultsId[$results['id']][] = $results['result'];
        }
    }

    public function arrivals(): array
    {
        foreach ($this->dataAttempts['data'] as $results) {
            if (isset($this->dataCars['data'][$results['id']])) {
                if (!inMultiArray($this->dataCars['data'][$results['id']], $this->data)) {
                    $this->data[$results['id']] = $this->dataCars['data'][$results['id']];
                }
                if (inMultiArray($this->data[$results['id']], $this->data)) {
                        $this->data[$results['id']]['result1'] = $this->resultsId[$results['id']][0];
                        $this->data[$results['id']]['result2'] = $this->resultsId[$results['id']][1];
                        $this->data[$results['id']]['result3'] = $this->resultsId[$results['id']][2];
                        $this->data[$results['id']]['result4'] = $this->resultsId[$results['id']][3];
                        $this->data[$results['id']]['result'] = $this->sumResult(
                            $this->data[$results['id']]['result1'],
                            $this->data[$results['id']]['result2'],
                            $this->data[$results['id']]['result3'],
                            $this->data[$results['id']]['result4']
                        );
                        $this->data[$results['id']]['resultToString'] = $this->sumResult(
                            $this->data[$results['id']]['result1'],
                            $this->data[$results['id']]['result2'],
                            $this->data[$results['id']]['result3'],
                            $this->data[$results['id']]['result4'],
                            true
                        );

                }
            }
        }
        unset($this->dataCars);
        unset($this->dataAttempts);
        unset($this->resultsId);
//        $keys = array_column($this->data, 'result');
//        array_multisort($keys, SORT_DESC, $this->data);
        usort($this->data, 'cmp');
        return $this->data;
    }

    public function sumResult($num1, $num2, $num3, $num4, $type = false): string
    {
        if ($type === false) {
            return $num1 + $num2 + $num3 + $num4;
        } else {
            return "{$num4}{$num3}{$num2}{$num1}";
        }
    }

    public function arrayToCsvDownload($array, $filename = "export.csv", $delimiter=","): void
    {
        ob_start();
        $keys = array_keys( (array) $array[0] );
        $data = [];
        $data[] = implode($delimiter, $keys);
        foreach ($array as $item) {
            $values = array_values((array) $item);
            $data[] = implode($delimiter, $values);
        }
        ob_flush();
        $csvData = join("\n", $data);
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        header('Content-Type: application/csv; charset=UTF-8');
        echo "\xEF\xBB\xBF";
        die($csvData);
    }
}
