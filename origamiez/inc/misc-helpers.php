<?php

use Origamiez\Engine\Config\AllowedTagsConfig;
use Origamiez\Engine\Helpers\MetadataHelper;

function origamiez_get_metadata_prefix($echo = true)
{
    return MetadataHelper::get_metadata_prefix($echo);
}

function origamiez_return_10()
{
    return 10;
}

function origamiez_return_15()
{
    return 15;
}

function origamiez_return_20()
{
    return 20;
}

function origamiez_return_30()
{
    return 30;
}

function origamiez_return_60()
{
    return 60;
}

function origamiez_get_allowed_tags()
{
    return AllowedTagsConfig::get_allowed_tags();
}
