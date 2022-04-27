<?php
require('./fpdf184/fpdf.php');

class PDFLayout extends FPDF
{
    private $arrPages = null;

    private $arrPageLayout = array();

    private $arrDataProvider = array();

    private $arrElementMethodMapping = [
        "text"=>"ElementText",
        "multiline"=>"ElementMultiline",
        "line"=>"ElementLine",
        "rect"=>"ElementRect",
        "image"=>"ElementImage",
        "labeledText"=>"ElementLabledText",
        "timeline"=>"ElementTimeline",
        "keyvalue"=>"ElementKeyvalue"
    ];

    function LoadPages($file)
    {
        $string = file_get_contents($file);
        $pages = json_decode($string);

        

        foreach($pages->pages as $page)
        {
            $this->arrPages[$page->id] = $page;
            $this->LoadLayout($page->layoutFile, $page->id);
        }
    }


    function LoadLayout($file,$pageID)
    {
        $string = file_get_contents($file);
        $this->arrPageLayout[$pageID] = json_decode($string);
    }


    function addDataProvider($dataProvider)
    {
        $this->arrDataProvider[] = $dataProvider;
    }



    function DrawLayoutGrid()
    {
        $lineLength = 2;    // mm
        $lineSpacing = 10;  // mm
        $hMax = 210; // mm
        $vMax = 290; // mm
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(100,100,100);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(50,50,50);
        for($v=0; $v<=$vMax; $v+=$lineSpacing)
        {
            for($h=0; $h<=$hMax; $h+=$lineSpacing)
            {
                $this->Line($h,$v,$h+$lineLength,$v);
                $this->Line($h,$v,$h,$v+$lineLength);

                $this->Text($h+0.5, $v+2, "{$h} , {$v}");
            }
        }
        
    }

    function DrawColorBars()
    {
        $barSize = 5;    // mm
        $barSpacing = 2;  // mm
        $hMax = 210; // mm
        $vMax = 290; // mm
        $grayScaleTotalSteps = 25;

        $this->SetFillColor(0,0,0);
        $this->SetDrawColor(100,100,100);
        $this->SetFont('Arial','',12);
        $this->SetTextColor(50,50,50);

        $x = 10;
        for($v=0; $v<$grayScaleTotalSteps; $v++)
        {
            $grayscaleColorValue = ceil((255 / $grayScaleTotalSteps) * $v);
            $y = ($barSize+$barSpacing) * $v;
            $this->SetFillColor($grayscaleColorValue ,$grayscaleColorValue ,$grayscaleColorValue );
            $this->Rect($x,$y+10,$barSize*2,$barSize,'F');
            $this->Text($x+($barSize*2)+2, $y+14, "{$grayscaleColorValue}");
        }

        $x = 40;
        for($v=0; $v<$grayScaleTotalSteps; $v++)
        {
            $grayscaleColorValue = ceil((255 / $grayScaleTotalSteps) * $v);
            $y = ($barSize+$barSpacing) * $v;
            $this->SetFillColor($grayscaleColorValue ,0 ,0 );
            $this->Rect($x,$y+10,$barSize*2,$barSize,'F');
            $this->Text($x+($barSize*2)+2, $y+14, "{$grayscaleColorValue}");
        }

        $x = 70;
        for($v=0; $v<$grayScaleTotalSteps; $v++)
        {
            $grayscaleColorValue = ceil((255 / $grayScaleTotalSteps) * $v);
            $y = ($barSize+$barSpacing) * $v;
            $this->SetFillColor(0, $grayscaleColorValue ,0 );
            $this->Rect($x,$y+10,$barSize*2,$barSize,'F');
            $this->Text($x+($barSize*2)+2, $y+14, "{$grayscaleColorValue}");
        }

        $x = 100;
        for($v=0; $v<$grayScaleTotalSteps; $v++)
        {
            $grayscaleColorValue = ceil((255 / $grayScaleTotalSteps) * $v);
            $y = ($barSize+$barSpacing) * $v;
            $this->SetFillColor(0 , 0, $grayscaleColorValue );
            $this->Rect($x,$y+10,$barSize*2,$barSize,'F');
            $this->Text($x+($barSize*2)+2, $y+14, "{$grayscaleColorValue}");
        }

        $x = 130;
        for($v=0; $v<$grayScaleTotalSteps; $v++)
        {
            $redColorValue = random_int(0,255);
            $greenColorValue = random_int(0,255);
            $blueColorValue = random_int(0,255);
            $y = ($barSize+$barSpacing) * $v;
            $this->SetFillColor($redColorValue , $greenColorValue, $blueColorValue );
            $this->Rect($x,$y+10,$barSize*2,$barSize,'F');
            $this->Text($x+($barSize*2)+2, $y+14, "{$redColorValue} , {$greenColorValue} , {$blueColorValue}");
        }
    }

    

    function MakePages()
    {
        $pages = $this->arrPages;
        foreach($pages as $pageID => $page)
        {
            $this->AddPage($page->orientation, $page->format);
            $this->RenderLayoutForPage($pageID);
        }
    }

    function RenderLayoutForPage($pageID)
    {
        // text multiline line rect image
        $funcs = $this->arrElementMethodMapping;

        $pageLayout = $this->arrPageLayout[$pageID];

        foreach($pageLayout->elements as $el)
        {
            
            $funcName = isset($funcs[$el->type]) ? $funcs[$el->type] : null;
            if($funcName!=null)
            {
                $this->{$funcName}($el);
            }
            
        }
    }

    function ElementText($elementData)
    {
        $ed = $elementData;

        $data = $this->ParseDataProvider($ed);
        $color = explode(",",$ed->textColor);
        $str = isset($ed->data) ? $ed->data : "";
        $str = $data!==null ? $data : $str;

        $separator = isset($ed->separator) ? $ed->separator : "";

        if(is_array($str))
        {
            $str = implode($separator ,$str);
        }
        $this->SetFont('Arial','',$ed->fontSize);
        $this->SetTextColor($color[0],$color[1],$color[2]);
        $this->SetFillColor($color[0],$color[1],$color[2]);
        $this->Text($ed->x,$ed->y, $str);
        $this->Ln();
    }

    function ElementMultiline($elementData)
    {
        $ed = $elementData;
        $data = $this->ParseDataProvider($ed);
        $str = isset($ed->data) ? $ed->data : "";
        $str = $data!==null ? $data : $str;

        $separator = isset($ed->separator) ? $ed->separator : "";

        if(is_array($str))
        {
            $str = implode($separator ,$str);
        }
        $str = utf8_decode($str);
        $color = explode(",",$ed->textColor);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','',$ed->fontSize);
        $this->SetTextColor($color[0],$color[1],$color[2]);
        $this->SetXY($ed->x,$ed->y);
        $this->MultiCell($ed->width, $ed->height, $str, 0, 'L');
        $this->Ln();
    }

    function ElementLine($elementData)
    {
        $ed = $elementData;
        $color = explode(",",$ed->lineColor);
        $this->SetLineWidth($ed->lineWidth);
        $this->SetDrawColor($color[0],$color[1],$color[2]);
        $this->Line($ed->x,$ed->y,$ed->x2,$ed->y2);
    }

    function ElementRect($elementData)
    {
        $ed = $elementData;
        $lineColor = explode(",",$ed->lineColor);
        $fillColor = explode(",",$ed->fillColor);

        $this->SetLineWidth($ed->lineWidth);
        $this->SetDrawColor($lineColor[0],$lineColor[1],$lineColor[2]);
        $this->SetFillColor($fillColor[0],$fillColor[1],$fillColor[2]);
        
        $this->Rect($ed->x,$ed->y,$ed->width,$ed->height,$ed->style);
    }

    function ElementImage($elementData)
    {
        $el = $elementData;
        $file = $el->file;
        $this->Image($file, $el->x, $el->y, $el->width, $el->height);
    }


    // Simple table
    function ElementLabledText($elementData)
    {
        $ed = $elementData;

        $labels = $ed->labels;

        $currentX = 0;

        $data = $this->ParseDataProvider($ed);
        
        $color = explode(",",$ed->textColor);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','',$ed->fontSize);
        $this->SetTextColor($color[0],$color[1],$color[2]);

        $this->SetXY($ed->x, $ed->y);
        $currentX = $ed->x;

        $values = array();

        foreach($data as $value)
        {
            $values[] = $value;
        }

        $idx = 0;
 
        foreach($labels as $label)
        {
            $this->Text($currentX,$ed->y, $label);
            $currentX += $this->GetStringWidth($label)+2;
            $this->Text($currentX,$ed->y, $values[$idx]);
            $currentX += $this->GetStringWidth($values[$idx])+7;
            $idx++;
        }
    
        $this->Ln();
    }

    function ElementTimeline($elementData)
    {
        $ed = $elementData;

        $data = $this->ParseDataProvider($ed);
        $color = explode(",",$ed->textColor);

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(186,210,240);

        $this->SetFont('Arial','',$ed->fontSize);
        $this->SetTextColor($color[0],$color[1],$color[2]);
        $this->SetFillColor($color[0],$color[1],$color[2]);

        $this->SetXY($ed->x, $ed->y);

        $lastY = $ed->y;

        ksort($data);

        $dateWidth = 30;

        foreach($data as $event)
        {
            $show = isset($event->attributes->show) ? $event->attributes->show : true;

            if($show)
            {
                $this->SetXY($ed->x, $lastY);
                $this->MultiCell($dateWidth,5, $event->start.'-'.$event->end, 0, 'R');
                $this->SetXY($ed->x+$dateWidth, $lastY);
                $this->MultiCell(80,5, utf8_decode($event->title), 0, 'L');
                $this->Ln(2);
                $this->Line($ed->x+$dateWidth,$lastY,$ed->x+$dateWidth,$this->GetY()-1);
                $lastY = $this->GetY();
            }
        }

        $lastY = $this->GetY();
    }

    function ElementKeyvalue($elementData)
    {
        $ed = $elementData;

        $data = $this->ParseDataProvider($ed);
        $color = explode(",",$ed->textColor);
        $labelColor = explode(",",$ed->labelColor);

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(186,210,240);

        $this->SetFont('Arial','',$ed->fontSize);
        $this->SetTextColor($color[0],$color[1],$color[2]);
        $this->SetFillColor($color[0],$color[1],$color[2]);

        $this->SetXY($ed->x, $ed->y);

        $lastY = $ed->y;

        $dateWidth = 40;


        $labels = $ed->labels;

        $values = array();

        foreach($data as $value)
        {
            $values[] = $value;
        }

        $idx = 0;
 
        foreach($labels as $label)
        {
            $this->SetXY($ed->x, $lastY);
            $this->SetTextColor($labelColor[0],$labelColor[1],$labelColor[2]);
            $this->MultiCell($dateWidth,5, utf8_decode($label), 0, 'R');
            $this->SetXY($ed->x+$dateWidth, $lastY);
            $this->SetTextColor($color[0],$color[1],$color[2]);
            $this->MultiCell(100,5, utf8_decode($values[$idx]), 0, 'L');
            $this->Ln(0);

            $lastY = $this->GetY();
            $idx++;
        }
    
        $this->Ln();        
    }

    function ParseDataProvider($elementData)
    {
        $ed = $elementData;
        $tmpResult = null;
        if(isset($ed->dataProvider))
        {
            $dataProviderMethod = $ed->dataProvider;
            if($dataProviderMethod!='')
            {
                $dataProviderAttributes = isset($ed->dataProviderAttributes) ? $ed->dataProviderAttributes : null;
                foreach($this->arrDataProvider as $dataProvider)
                {
                    if(method_exists($dataProvider,$dataProviderMethod))
                    {
                        $tmpResult = $dataProvider->{$dataProviderMethod}($dataProviderAttributes);
                    } else {
                        echo "dataprovider method does not exist: ".$dataProviderMethod;
                    }
                }
            }
            
        }
        return $tmpResult;
    }
}
?>