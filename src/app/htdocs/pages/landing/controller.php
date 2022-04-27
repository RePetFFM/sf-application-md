<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "./app/PortfolioDataProvider.php";

// create a new portfolio data provider instance
$portfolioDataProvide = new PortfolioDataProvider();

// load json data into the data provider
$portfolioJsonFiles = array();
$portfolioJsonFiles["intro"] = "../data/intro.json";
$portfolioJsonFiles["portfolio"] = "../data/profile.json";
$portfolioDataProvide->LoadData($portfolioJsonFiles);

$dataProviderAttributes = (object) array("salutation");
$dataProviderMethod = "Intro";
$data = $portfolioDataProvide->{$dataProviderMethod}($dataProviderAttributes);
$introSalute = nl2br(implode("", $data));

$dataProviderAttributes = (object) array("preamble","my-usefull-skill","extra-profile","end");
$dataProviderMethod = "Intro";
$data = $portfolioDataProvide->{$dataProviderMethod}($dataProviderAttributes);
$intro = nl2br(implode("", $data));

$fulleName = $portfolioDataProvide->PortfolioProfile(array("fullname"))["fullname"];

$personInfo = $portfolioDataProvide->PortfolioProfile(array("workTitle","address")); // ,"phone","mail","threemaID"

$personInfo = implode("<br>",$personInfo);



// begin: skill soft
$dataProviderAttributes = (object) array();
$dataProviderAttributes->get = "list";
$dataProviderAttributes->show = "soft";

$data = $portfolioDataProvide->Skills($dataProviderAttributes);
$skillSoft = nl2br(implode("\n", $data));



// begin: skill programming
$dataProviderAttributes = (object) array();
$dataProviderAttributes->get = "list";
$dataProviderAttributes->show = "programming";

$data = $portfolioDataProvide->Skills($dataProviderAttributes);
$skillProgramming = nl2br(implode("\n", $data));



// begin: software

$softwareTypes = array();
$softwareTypes['OS'] = "Betriebsysteme";
$softwareTypes['development tool'] = "Entwickler-Tools";
$softwareTypes['Office'] = "Office";
$softwareTypes['Media'] = "Media";
$softwareTypes['3D Tools'] = "3D Tools";


$softwareTools = "";

foreach($softwareTypes as $key => $val)
{
    $dataProviderAttributes = (object) array();
    // $dataProviderAttributes->status = "active";
    $dataProviderAttributes->type = $key;
    
    $data = $portfolioDataProvide->Software($dataProviderAttributes);
    $softwareTools .= "<h5>{$val}</h5>";
    $softwareTools .= "<p>".nl2br(implode(", ", $data))."</p>";
}



// begin: lebenslauf
$dataProviderAttributes = (object) array();
$dataProviderAttributes->branche = "lebenslauf";
$dataProviderAttributes->sortby = "start";

$data = $portfolioDataProvide->PortfolioTimeline($dataProviderAttributes);
ksort($data);

$lebenslauf = "<table class='ll-table'>";

foreach($data as $event)
{
    $show = isset($event->attributes->show) ? $event->attributes->show : true;

    $newRow = "<tr class='ll-row'>";
    if($show)
    {
        $newRow .= "<td class='ll-year'>{$event->start} - {$event->end}</<td>";
        $newRow .= "<td>{$event->title}</<td>";
    }
    $lebenslauf .= $newRow;
}

$lebenslauf .= "</table>";


// begin: kontakt
$contactSheet = array();
$contactSheet['Telefon'] = 'phone';
$contactSheet['E-Mail'] = 'mail';
$contactSheet['Threema ID'] = 'threemaID';

$data = $portfolioDataProvide->PortfolioProfile($contactSheet);

// transform data to html format
$html = "";
foreach($contactSheet as $key => $val)
{
    $contactVal = $data[$val];
    $html .= "<p>{$key}: <strong>{$contactVal}</strong></p>";
}

$kontakt = $html;

include __DIR__."/view.php";