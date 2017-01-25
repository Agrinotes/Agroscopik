<?php
namespace AppBundle\Services;

class ConvertCsvToArray {

    public function __construct()
    {
    }

    public function convert($filename, $delimiter = ';')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();
        $debug = 0;
        $line=0;

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 8000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                } else {
                    if($debug){var_dump($line.' '.count($row));};
                    $data[] = array_combine(range(1,count($header)), array_slice($row,0,count($header)));
                }
                $line++;
            }
            fclose($handle);
        }

        return $data;
    }

}