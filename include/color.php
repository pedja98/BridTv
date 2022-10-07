<?php
function getColorStyle(int $duration)
{
    if ($duration <= 60) {
        return "tr-red";
    } elseif ($duration > 60 && $duration <= 120) {
        return "tr-blue";
    } elseif ($duration > 120) {
        return "tr-green";
    }
}
