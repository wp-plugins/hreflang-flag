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

// class for admin plugin features
if (!class_exists("hreflangFlagAdmin")) {
  class hreflangFlagAdmin extends hreflangFlag {
      var $plugin_path;
      var $plugin_url;

      var $default_back_pos;
      function add_js() {
	$options = get_option('hreflangFlag_config');
	if (is_readable($input['flags_path'].$input['test'])) {
	  list($width, $height) = getimagesize($options['flags_path'].$options['test']);
	  $defpadsize = ($width+3).'px';
	} else {
	  $defpadsize = $options['padding-size'];
	}
	?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		function hreflangFlag_config_update() {
			var default_back_pos = new Array();
			<?php foreach($this->default_back_pos as $k => $v) {
				echo "default_back_pos['$k'] = '$v';";
			} ?>
			var defpadsize = '<?php echo $defpadsize; ?>';

			var pos=$("input[name='hreflangFlag_config[position]']:checked").val();
			var otherpos=(pos==='left')?'right':'left';
			var style=$("input[name='hreflangFlag_config[style]']:checked").val();
			$("span[id='left-right']").html(pos);
			if (style == "auto") {
				$("input[name='hreflangFlag_config[background-position]']").val(default_back_pos[pos]);
				$("input[name='hreflangFlag_config[padding-size]']").val(defpadsize);
			}

			$("a[id='test_flag']").css( "background-position", $("input[name='hreflangFlag_config[background-position]']").val());
			$("a[id='test_flag']").css( "padding-"+pos, $("input[name='hreflangFlag_config[padding-size]']").val());
			$("a[id='test_flag']").css( "padding-"+otherpos, "0px");
		}
		$("input[name='hreflangFlag_config[position]']").click(function(){
			hreflangFlag_config_update();
		});
		$("input[name='hreflangFlag_config[style]']").click(function(){
			hreflangFlag_config_update();
		});
		$("input[name='hreflangFlag_config[background-position]']").focus(function(){
			$("#style-custom-radio").attr("checked", "checked");
		});
		$("input[name='hreflangFlag_config[padding-size]']").focus(function(){
			$("#style-custom-radio").attr("checked", "checked");
		});
		hreflangFlag_config_update();
	});
//]]>
</script>
<?php
      }

      function options_page() {
	//add_filter('admin_head', array(&$this,'add_js'));
	$this->add_js();
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>hreflang Flag Options</h2>
		The proposed flags mostly comes from <a href="http://www.famfamfam.com">http://www.famfamfam.com</a>, some more from <a href="http://blog.johncrepezzi.com/archives/104">John Crepezzi's blog</a> and I added one... For details check the <a href="<?php echo $this->plugin_url; ?>flags/LICENSE">icon's license file</a>. But the configuration allows you to use any other set of icons you want, simply update the URL and path bellow (the path is for hreflang Flag to do some checks on the images, it's only used for the configuration). And then complete your flag configuration.
		<form action="options.php" method="post">
		<?php settings_fields('hreflangFlag_group'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
<?php
      }
      
      function settings_section($args) {
      	// can test $args['id'] or register different sections for different texts

      }

      function setting_string_fn($args) {
	$options = get_option($args['o']);
	echo "<input id='plugin_text_string' name='{$args['o']}[{$args['f']}]' size='40' type='text' value='{$options[$args['f']]}' /> ";
	if (isset($args['t'])) echo $args['t'];
      }

      function setting_position_fn($args) {
	$options = get_option($args['o']);
	echo "<label title='left'><input type='radio' name='{$args['o']}[position]' value='left'";
	if ($options['position'] === 'left') {
	  echo " checked='checked'";
	}
	echo "' /> Left </label>\n";
	echo "<label title='right'><input type='radio' name='{$args['o']}[position]' value='right'";
	if ($options['position'] === 'right') {
	  echo " checked='checked'";
	}
	echo " /> Right </label><br />\n";
	echo "<label title='style-auto'><input type='radio' name='{$args['o']}[style]' value='auto'";
	if ($options['style'] === 'auto') {
	  echo " checked='checked'";
	}
	echo ' /> ' . __('Automatic style') . " </label><br />\n";
	echo "<label title='style-custom'><input type='radio' name='{$args['o']}[style]' value='custom' id='style-custom-radio'";
	if ($options['style'] === 'custom') {
	  echo " checked='checked'";
	}
	echo ' /> ' . __('Custom Style') . " </label><br />\n";
	echo '<label title="background-position">background-position: <input type="text" name="'.$args['o'].'[background-position]" value="' . $options['background-position'] . '" /></label><br />'. "\n";
	echo '<label title="padding-left-right">padding-<span id="left-right">left/right</span>: <input type="text" name="'.$args['o'].'[padding-size]" value="' . $options['padding-size'] .  '" /></label><br />'. "\n";

      }

      function flag_section($args) {
	$options = get_option('hreflangFlag_config');
	echo '<p>hreflangFlags uses CSS to add flags to links, see <a href="http://www.w3.org/TR/css3-selectors/#attribute-selectors">W3C CSS3 Attribute selectors description</a> for more details on how it\'s defined.</p>';
	$flags = get_option('hreflangFlag');
	$flags[] = array( 'code' => '');
	$matches = array( '', '|', '~', '^', '$', '*' );
	foreach($flags as $i => $flag) {
	  $match=isset($flag['match'])?$flag['match']:'';
	  echo 'hreflang ';
	  foreach($matches as $m) {
	    echo '<label title="select match kind"><input type="radio" name="hreflangFlag['.$i.'][match]" value="'.$m.'"';
	    if ($m === $match) echo " checked='checked'";
	    echo ' />'.$m."= </label>";
	  }
	  echo ' <label title="match string"><input type="text" name="hreflangFlag['.$i.'][code]" value="'.$flag[code].'" class="small-text" /></label>';

	  echo ' <label title="image file">Image: <input type="text" name="hreflangFlag['.$i.'][img]" value="'.$flag[img].'" /></label>';
	  if (isset($flag[img])) {
	    echo ' <img src="'.$options['flags_url'].$flag[img].'" />';
	  } else {
	    echo " Fill this to add a new flag and save changes.";
	  }
	  echo "<br />\n";
	}
	echo "<p>You can also remove a flag by clearing either the match string or the image file.</p>";
	echo "<p>The order flags apear in the above table will be the order used in the css, so the last match is applied.</p>";
      }

      function admin_menu() {
	add_options_page('hreflang Flag Options', 'hreflag Flag', 'manage_options', __FILE__, array(&$this,'options_page'));
      }

      // Register our settings. Add the settings section, and settings fields
      function admin_init(){
	register_setting('hreflangFlag_group', 'hreflangFlag_config', array(&$this,'validate_config') );
	add_settings_section('config_section', 'Main Settings', array(&$this,'settings_section'), __FILE__);
	add_settings_field('flags_base_url', 'Flags base URL', array(&$this,'setting_string_fn'), __FILE__, 'config_section', array('o' => 'hreflangFlag_config', 'f' => 'flags_url'));
	add_settings_field('flags_base_dir', 'Flags base directory', array(&$this,'setting_string_fn'), __FILE__, 'config_section', array('o' => 'hreflangFlag_config', 'f' => 'flags_path', 't' => 'This directory must correspond to the URL above.'));
	add_settings_field('position', 'Flag icon position', array(&$this,'setting_position_fn'), __FILE__, 'config_section', array('o' => 'hreflangFlag_config'));
	$options = get_option('hreflangFlag_config');
	add_settings_field('test_flag', 'Test flag', array(&$this,'setting_string_fn'), __FILE__, 'config_section', array('o' => 'hreflangFlag_config', 'f' => 'test', 't' => "<br>Some text a <a id='test_flag' href='#' style='background:url({$options['flags_url']}{$options['test']}) {$options['background-position']} no-repeat; padding-{$options['position']}: {$options['padding-size']};'>sample Link</a> some more text."));
	add_settings_field('css_selector', 'CSS Selector', array(&$this,'setting_string_fn'), __FILE__, 'config_section', array('o' => 'hreflangFlag_config', 'f' => 'css_selector', 't' => 'Comma separated list of css selector (each will be used before the "a" tag in the css definition).<br />Exemple: ".entry" will show flags only inside post/page entry nowhere else.'));

	register_setting('hreflangFlag_group', 'hreflangFlag', array(&$this,'validate_flags') );
	add_settings_section('flag_section', 'Flag Settings', array(&$this,'flag_section'), __FILE__);
      }

      function validate_config($input) {
        $tmp = get_option('hreflangFlag_config');
        if(!is_dir($input['flags_path'])) {
	  //echo "Error: the directory does not exist";
	  $input['flags_path'] = $tmp['flags_path'];
	}
	if ($input['style'] !== 'custom') $input['style'] = 'auto';
	if ($input['style'] === 'auto') {
		$input['background-position'] = $this->default_back_pos[$input['position']];
		if (is_readable($input['flags_path'].$input['test'])) {
			list($width, $height) = getimagesize($input['flags_path'].$input['test']);
			$input['padding-size'] = ($width+3).'px';
		}
	}
	return $input;
      }

      function validate_flags($input) {
      	$output = Array();
        foreach($input as $f)
	{
	  if (($f['code'] !== '') && ($f['img'] !== '')) {
	    $output[]=$f;
	  }
	}
	return $output;
      }

      // Define default option settings
      function add_defaults_options() {
        $tmp = get_option('hreflangFlag_config');
	if (!is_array($tmp)) {
    	  $arr = array(	'flags_url' 	=> $this->plugin_url.'flags/',
	  		'flags_path' 	=> $this->plugin_path.'flags/',
			'position' 	=> 'left',
			'test'		=> 'fam.png' );
	  update_option('hreflangFlag_config', $this->validate_config($arr));
	}
        $tmp = get_option('hreflangFlag');
	if (!is_array($tmp)) {
    	  $arr = array();
	  $arr[] = array( 'code' => 'fr', 'img' => 'fr.png');
	  $arr[] = array( 'code' => 'en', 'img' => 'en.png', 'match' => '|');
	  $arr[] = array( 'code' => 'en-US', 'img' => 'us.png');
	  $arr[] = array( 'code' => 'en-GB', 'img' => 'gb.png');
	  update_option('hreflangFlag', $this->validate_flags($arr));
	}
      }


      function init () {
	/* Don't forget to call common init */
      	parent::init();
	add_action('admin_menu', array(&$this,'admin_menu'));
	add_action('admin_init', array(&$this,'admin_init'));
      }

      function load() {
	// Pre-2.6 compatibility
	if ( ! defined( 'WP_CONTENT_URL' ) )
	      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if ( ! defined( 'WP_CONTENT_DIR' ) )
	      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if ( ! defined( 'WP_PLUGIN_URL' ) )
	      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
	if ( ! defined( 'WP_PLUGIN_DIR' ) )
	      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

	/* Define the plugin path */
	$plugin_base_path	   = basename( dirname(__FILE__) );
	$this->plugin_path 	   = trailingslashit(str_replace('\\', '/', WP_PLUGIN_DIR.'/'.$plugin_base_path));
	$this->plugin_url  	   = trailingslashit(WP_PLUGIN_URL.'/'.$plugin_base_path);
        $this->default_back_pos['left']="0px 40%";
        $this->default_back_pos['right']="99% 40%";
	
      	parent::load();
	/* Add Admin action handlers */
	register_activation_hook($this->plugin_file, array(&$this,'add_defaults_options'));
      }
 
  } //End Class hreflangFlagPublic

  $hf_hreflangFlagAdmin= new hreflangFlagAdmin();
  $hf_hreflangFlagAdmin->load();
}

// Useful dev links:
// http://codex.wordpress.org/Adding_Administration_Menus
// http://codex.wordpress.org/Settings_API
// http://www.presscoders.com/wordpress-settings-api-explained/
?>
