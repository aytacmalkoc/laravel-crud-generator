<?php

if (!function_exists('controller_path'))
{
    function controller_path($path = ''): string
    {
        return app_path("Http/Controllers/$path");
    }
}

if (!function_exists('request_path'))
{
    function request_path($path = ''): string
    {
        return app_path("Http/Requests/$path");
    }
}

if (!function_exists('model_path'))
{
    function model_path($path = ''): string
    {
        return app_path("Models/$path");
    }
}

if (!function_exists('observer_path'))
{
    function observer_path($path = ''): string
    {
        return app_path("Observers/$path");
    }
}

if (!function_exists('observer_path'))
{
    function observer_path($path = ''): string
    {
        return app_path("Observers/$path");
    }
}
