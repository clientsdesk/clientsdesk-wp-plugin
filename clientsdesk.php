<?php
/**
 * @package  ClientsdeskPlugin
 */

/*
Plugin Name: Clientsdesk
Plugin URI: https://clientsdesk.net/plugins
Description: Plugin serving connection to Clientsdesk.net platform.
Version: 1.0
Author: Oleksii Baidan
Author URI: https://www.linkedin.com/in/oleksii-baidan-b53704107/
License: GPLv2 or later
Text Domain: clientsdesk
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');


/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
//TODO: Add link to documentation
function cld_error($message, $subtitle = '', $title = '') {
	$title = $title ?: __('Cliendesk &rsaquo; Error', 'cliendesk');
	$footer = '<a href="#">Link to docs</a>';
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
	wp_die($message, $title);
}

/**
 * Ensure compatible version of PHP is used
 */

if (version_compare('7.0', phpversion(), '>=')) {
	cld_error(__('You must be using PHP 7.0 or greater.', 'cliendesk'), __('Invalid PHP version', 'cliendesk'));
}

/**
 * Ensure dependencies are loaded
 */

if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
	cld_error(
		__('You must run <code>composer install</code> from the plugin directory.', 'cliendesk'),
		__('Autoloader not found.', 'cliendesk')
	);
}

// Require once the Composer Autoload
require_once $composer;

/**
 * The code that runs during plugin activation
 */
function activate_clientsdesk_plugin()
{
	Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_clientsdesk_plugin');
/**
 * The code that runs during plugin deactivation
 */
function deactivate_clientsdesk_plugin()
{
    Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_clientsdesk_plugin');

/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('Inc\\Init')) {
	Inc\Init::register_services();
}