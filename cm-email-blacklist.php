<?php

/*
  Plugin Name: CM E-Mail Registration Blacklist
  Plugin URI: http://plugins.cminds.com/cm-email-registration-blacklist-plugin-for-wordpress/
  Description: Block users from certain domains from registering in your site
  Author: CreativeMindsSolutions
  Version: 1.2.3
 */

/*

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
if (version_compare('5.3', phpversion(), '>')) {
    die('We are sorry, but you need to have at least PHP 5.3 to run this plugin (currently installed version: '.phpversion().') - please upgrade or contact your system administrator.');
}
//Define constants
/**
 * Define Plugin Version
 *
 * @since 1.0
 */
if( !defined('CMEB_VERSION') )
{
    define('CMEB_VERSION', '1.2.2');
}

/**
 * Define Plugin name
 *
 * @since 1.0
 */
if( !defined('CMEB_NAME') )
{
    define('CMEB_NAME', 'CM E-Mail Registration Blacklist');
}

/**
 * Define Plugin canonical name
 *
 * @since 1.0
 */
if( !defined('CMEB_CANONICAL_NAME') )
{
    define('CMEB_CANONICAL_NAME', 'CM E-Mail Registration Blacklist');
}

/**
 * Define Plugin license name
 *
 * @since 1.0
 */
if( !defined('CMEB_LICENSE_NAME') )
{
    define('CMEB_LICENSE_NAME', 'CM E-Mail Registration Blacklist');
}

/**
 * Define Plugin File Name
 *
 * @since 1.0
 */
if( !defined('CMEB_PLUGIN_FILE') )
{
    define('CMEB_PLUGIN_FILE', __FILE__);
}

/**
 * Define Plugin release notes url
 *
 * @since 1.0
 */
if( !defined('CMEB_RELEASE_NOTES') )
{
    define('CMEB_RELEASE_NOTES', 'https://tooltip.cminds.com/');
}

if( !defined('CMEB_PATH') )
{
    define('CMEB_PATH', WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)));
}
if( !defined('CMEB_URL') )
{
    define('CMEB_URL', plugins_url('', __FILE__));
}
//Init the plugin
require_once CMEB_PATH.'/lib/CMEB.php';
register_activation_hook(__FILE__, array('CMEB', 'install'));
register_uninstall_hook(__FILE__, array('CMEB', 'uninstall'));
CMEB::init();
