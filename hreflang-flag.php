<?php
/*
Plugin Name: hreflang Flag
Plugin URI: http://silicone.homelinux.org/projects/hreflang-flag
Description: Add a flag icon to link corresponding to the hreflang attribute.
Version: 1.1
Author: Julien Viard de Galbert
Author URI: http://silicone.homelinux.org/
License: GPL2+
*/
/*  Copyright (C) 2010  Julien Viard de Galbert <julien@silicone.homelinux.org>

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// class for common plugin features
if (!class_exists("hreflangFlag")) {
  class hreflangFlag {
      var $plugin_file;
 
      // not using constructors (as PHP4 and 5 are different)
      // using explicit load for entry point and init for actual construction
      function load () {
        $this->plugin_file = __FILE__;
      	add_action('init', array(&$this,'init'));
      }

      function init () {
      	// need to be called by parrent (in public/admin)
      }

  } //End Class hreflangFlag
}

if ( is_admin() ){
  // admin actions
  require('hreflang-flag-admin.inc.php');
} else {
  // non-admin enqueues, actions, and filters
  require('hreflang-flag-public.inc.php');
}
?>
