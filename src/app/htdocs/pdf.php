<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('./app/PDFLayout.php');
require('./app/PortfolioDataProvider.php');

// create a new portfolio data provider instance
$portfolioDataProvide = new PortfolioDataProvider();

// load json data into the data provider
$portfolioJsonFiles = array();
$portfolioJsonFiles["intro"] = "../data/intro.json";
$portfolioJsonFiles["portfolio"] = "../data/profile.json";
$portfolioDataProvide->LoadData($portfolioJsonFiles);

// render pdf with layout description json file
$pdf = new PDFLayout('P','mm');
$pdf->LoadPages('./pdf_layout/bewerbung/pages.json');
$pdf->addDataProvider($portfolioDataProvide);
$pdf->MakePages();
$pdf->Output('I','Application.pdf');
?>