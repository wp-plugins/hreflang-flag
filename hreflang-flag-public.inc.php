<?php
/*
 This file is part of hreflang Flag Wordpress Plugin
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

// class for public plugin features
if (!class_exists("hreflangFlagPublic")) {
  class hreflangFlagPublic extends hreflangFlag {
      var $url_path;
      var $background_pos;
      var $padding;
      var $css_selector;
      var $flags;

      function wp_print_styles () { ?>
<style type="text/css">
<?php
	foreach ($this->flags as $flag) {
	  $match=isset($flag['match'])?$flag['match']:'';
	  foreach($this->css_selector as $selector) {
	    echo $selector.' a[hreflang'.$match.'="'.$flag['code'].'"] {background:url('.$this->url_path.$flag['img'].') '.$this->background_pos.' no-repeat; '.$this->padding."}\n";
	  }
	}
?>
</style>
<?php
      }

      function init () {
      	parent::init();
      	add_action('wp_print_styles', array(&$this,'wp_print_styles'));
	// load flag collection information
	$options = get_option('hreflangFlag_config');
	
	$this->url_path = $options['flags_url'];
	$this->background_pos = $options['background-position'];
	$this->padding = "padding-{$options['position']}: {$options['padding-size']};";
	// load css selector
	$this->css_selector = explode(',', $options['css_selector']);

	// load configured language flags
	$this->flags = get_option('hreflangFlag');
      }
 
  } //End Class hreflangFlagPublic

  $hf_hreflangFlagPublic= new hreflangFlagPublic();
  $hf_hreflangFlagPublic->load();
}
?>
