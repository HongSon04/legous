<?php
function formatVND($amount)
{
    $formattedAmount = number_format($amount, 0, ',', '.');
    $formattedAmount .= ' đ';

    return $formattedAmount;
}
function formatViewsNumber($views)
{
    if ($views >= 1000000) {
        // Convert to millions
        $formattedViews = round($views / 1000000, 1) . 'm+';
    } elseif ($views >= 1000) {
        // Convert to thousands
        $formattedViews = round($views / 1000, 1) . 'k+';
    } else {
        // No conversion needed
        $formattedViews = $views . '+';
    }

    return $formattedViews;
}
?>