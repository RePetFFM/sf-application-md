<?php

class Portfolio 
{
    private $arrPortfolioData = null;

    private $arrErrors = array();

    function LoadData($files = array())
    {
        $this->arrErrors = array();
        foreach($files as $dataName => $file)
        {
            $fileCheckResult = is_file($file) ? true : $this->arrErrors[] = "not a file: {$file}";

            if($fileCheckResult===true)
            {
                $string = file_get_contents($file);
                $this->arrPortfolioData[$dataName] = json_decode($string);

                !$this->arrPortfolioData[$dataName] ? $this->arrErrors[] = "file json format error: {$file}" : true;
            }

        }
    }

    function SetData($arrData)
    {
        foreach($arrData as $dataName => $data)
        {
            $checkJson = json_decode($data);

            if($checkJson!==null)
            {
                $this->arrPortfolioData[$dataName] = json_decode($data);
            }

        }
    }

    function getPortfolioData($type)
    {
        return $this->arrPortfolioData[$type];
    }

    function DumpPortfolioData()
    {
        echo print_r($this->arrPortfolioData, true);
    }

    function DumpErrors()
    {
        echo print_r($this->arrErrors, true);
    }
}
?>