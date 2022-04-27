<?php

include __DIR__."/Portfolio.php";

class PortfolioDataProvider extends Portfolio
{

    function PortfolioProfile($attributes)
    {
        $result = null;

        $portfolio = $this->getPortfolioData("portfolio");

        foreach($attributes as $requestedSection)
        {
            $result[$requestedSection] = $portfolio->profile->{$requestedSection};
        }
        
        return $result;
    }


    function Intro($attributes)
    {
        $result = array();

        $intro = $this->getPortfolioData("intro");

        foreach($attributes as $requestedSection)
        {
            $result[$requestedSection] = $intro->sections->{$requestedSection};
        }
        
        return $result;
    }

    function PortfolioTimeline($attributes)
    {
        $result = array();

        $portfolio = $this->getPortfolioData("portfolio");

        $timelineData = $portfolio->{$attributes->branche};

        $sortBy = $attributes->sortby;

        foreach($timelineData as $event)
        {
            $sortData = $event->{$sortBy};

            $result[$sortData] = $event; 
        }

        return $result;
    }

    function Skills($attributes)
    {
        $result = null;
        $portfolio = $this->getPortfolioData("portfolio");

        $get = $attributes->get;

        switch($get)
        {
            case 'title':
                $requestedSection = $attributes->show;
                $result = $portfolio->skills->{$requestedSection}->title;
                break;

            case 'list':
                $requestedSection = $attributes->show;
                $result = $portfolio->skills->{$requestedSection}->items;
                break;

            default:
                break;
        }

        return $result;
    }

    function Software($attributes)
    {
        $result = null;
        $portfolio = $this->getPortfolioData("portfolio");

        $statusRequset = isset($attributes->status) ? $attributes->status : null;

        $result = array();

        $typeRequset = isset($attributes->type) ? $attributes->type : null;

        foreach($portfolio->softwares as $software)
        {
            $name = $software->name;
            if($statusRequset!=null)
            {
                $name = $software->status==$statusRequset ? $software->name : null;
            }

            $matchType = true;

            if($typeRequset!=null)
            {
                $matchType = $software->type==$typeRequset ? true : false;
            }
            

            if($name!=null && $matchType)
            {
                $result[] = $name;
            }
            
        }

        return $result;
    }
}

?>