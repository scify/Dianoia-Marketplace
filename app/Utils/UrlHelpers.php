<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


/**
 * Used on menu to identify that a given menu item is selected
 * @param string $urlPatternToMatch the menu item url
 * @return string A relevant CSS class
 */
function UrlMatchesMenuItem(string $urlPatternToMatch): string {
    return (Request::is($urlPatternToMatch) || strpos(Route::getCurrentRoute()->getName(), $urlPatternToMatch) !== false) ? "active" : "";
}

