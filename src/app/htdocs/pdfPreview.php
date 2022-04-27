<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('./app/PDFLayout.php');
require('./app/PortfolioDataProvider.php');

if($_POST['intro']!='' && $_POST['profile']!='')
{
    // create a new portfolio data provider instance
    $portfolioDataProvide = new PortfolioDataProvider();

    // load json data into the data provider
    $portfolioJson = array();
    $portfolioJson["intro"] = $_POST['intro'];
    $portfolioJson["portfolio"] = $_POST['profile'];

    if(json_encode($portfolioJson["intro"])!=null && json_encode($portfolioJson["portfolio"])!=null)
    {
        $portfolioDataProvide->SetData($portfolioJson);

        // render pdf with layout description json file
        $pdf = new PDFLayout('P','mm');
        $pdf->LoadPages('./pdf_layout/bewerbung/pages.json');
        $pdf->addDataProvider($portfolioDataProvide);
        $pdf->MakePages();
        $pdf->Output();
    }
    
}

?>