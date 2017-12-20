<?php
// src/Blogger/BlogBundle/Twig/Extensions/DateExtension.php

namespace AppBundle\Twig\Extensions;

class DateExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('created_ago', array($this, 'createdAgo')),        
            );
    }

    public function createdAgo(\DateTime $dateTime)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        $date = $dateTime->getTimestamp();
        $text_return = '<span>'.date("d",$date).'</span>';
        $text_return .= '<strong>'.strftime("%B",$date).'</strong>';
        $text_return .= '<em>'.date("Y",$date).'</em>';
        return $text_return;
    }
}