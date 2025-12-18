<?php

use Origamiez\Engine\Helpers\FormatHelper;

function origamiez_get_format_icon($format)
{
    return FormatHelper::get_format_icon($format);
}

function origamiez_get_breadcrumb()
{
    do_action('origamiez_print_breadcrumb');
}
