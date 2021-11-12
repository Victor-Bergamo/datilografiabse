<?php

$sections = [];
$lastSection;

function startHtml($section)
{
    global $sections, $lastSection;

    $sections[$section] = $section;
    $lastSection = $section;
    ob_start();
}

function endHtml()
{
    global $sections, $lastSection;

    $html = ob_get_clean();
    $sections[$lastSection] = $html;
}

function insert($section)
{
    global $sections;

    if (!empty($sections[$section])) {
        return $sections[$section];
    }

    return null;
}
