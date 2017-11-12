<?php

function page_title(string $title)
{
    return ($title ? $title . ' ¤ ' : '') . config('app.name');
}

function page_active(string $route_name)
{
    return Route::is($route_name) ? 'is-active' : '';
}
