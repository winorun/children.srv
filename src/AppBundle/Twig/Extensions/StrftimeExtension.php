<?php
// src/Blogger/BlogBundle/Twig/Extensions/DateExtension.php

namespace AppBundle\Twig\Extensions;

class StrftimeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('strftime', array($this, 'strftime')),        
            );
    }

    public function strftime(\DateTime $dateTime, $format = '%d %B %Y')
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        $date = $dateTime->getTimestamp();
        return strftime($format,$date);
    }
}