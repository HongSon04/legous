<?php

function view(string $data)
{
    $url = str_replace(".", "/", $data);
    require "../WD18315/app/view/{$url}.php";
}

?>