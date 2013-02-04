<?php

/*
  Plugin Name: CM E-Mail Blacklist
  Plugin URI: http://www.cminds.com/plugins/email-blacklist
  Description: Block users from certain domains from registering in your blog
  Author: CreativeMinds
  Version: 1.0
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

//Define constants
define('CMEB_PATH', WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)));
define('CMEB_URL', plugins_url('', __FILE__));

//Init the plugin
require_once CMEB_PATH . '/lib/CMEB.php';
register_activation_hook(__FILE__, array('CMEB', 'install'));
register_uninstall_hook(__FILE__, array('CMEB', 'uninstall'));
CMEB::init();
?>