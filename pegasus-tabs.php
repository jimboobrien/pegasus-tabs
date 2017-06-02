	<?php 
/*
Plugin Name: Pegasus Tabs Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: This allows you to create tabs on your website with just a shortcode.
Version:     1.0
Author:      Jim O'Brien
Author URI:  https://visionquestdevelopment.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

	/**
	 * Silence is golden; exit if accessed directly
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	function pegasus_tabs_menu_item() {
		add_menu_page("Tabs", "Tabs", "manage_options", "pegasus_tabs_plugin_options", "pegasus_tabs_plugin_settings_page", null, 99);
	}
	add_action("admin_menu", "pegasus_tabs_menu_item");
	
	
	function pegasus_tabs_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>Tabs</h1>
		
		
	    <?php /* ?>
		<form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		<?php */ ?>
		<p>Usage: <pre>[tabs][tab class="first" title="Home"]Vivamus suscipit tortor eget felis porttitor volutpat. [/tab][tab class="second" title="Profile"]Pellentesque in ipsum id orci porta dapibus. [/tab][/tabs]</pre> </p>
		
		</div>
	<?php
	}
	
	
	/**
	* Tabs Short Code
	*/
	if ( ! class_exists( 'TabsClass' ) ) {
	class TabsClass {

		protected $_tabs_divs;

		public function __construct($tabs_divs = '') {
			$this->_tabs_divs = $tabs_divs;
			add_shortcode( 'tabs', array( $this, 'tabs_wrap') );
			add_shortcode( 'tab', array( $this,'tab_block') );
		}

		function tabs_wrap ( $args, $content = null ) {
			$output = '<div class="octane-tabs"><ul class="octane-tabs-nav" >' . do_shortcode($content) . '</ul>';
			
			//$output .= '<div class="octane-tabs-content">';
			$output .= $this->_tabs_divs;
			//$output .= '</div>'; //end tabs content
			$output .= '</div>'; //end octane-tabs
		   return $output;
		}

		function tab_block( $args, $content = null ) {
			extract(shortcode_atts(array(  
				'id' => '',
				'title' => '', 
				'class' => '', 
			), $args));

			$output = '
				<li class="'.$class.'">
					<a href="#" >'.$title.'</a>
				</li>
			';

			$this->_tabs_divs.= '<div class="octane-tabs-content">' .$content. '</div>';

			return $output;
		}

	}
	new TabsClass;
	}
	
	
	function pegasus_tabs_plugin_admin_scripts() {
		
		wp_enqueue_style( 'pegasus-admin-css', get_stylesheet_uri() );

		ob_start();
		?>
			.pegasus-wrap pre {
				overflow: auto;
				font-family: monospace, monospace;
				font-size: 1em;
				display: block;
				padding: 9.5px;
				margin: 0 0 10px;
				font-size: 13px;
				line-height: 1.42857143;
				color: #333;
				word-break: break-all;
				word-wrap: break-word;
				background-color: #f5f5f5;
				border: 1px solid #ccc;
				border-radius: 4px;
			}

			.pegasus-wrap pre,
			.pegasus-wrap blockquote {
				border: 1px solid #999;
				page-break-inside: avoid;
			}

			.pegasus-wrap pre code {
				padding: 0;
				font-size: inherit;
				color: inherit;
				white-space: pre-wrap;
				background-color: transparent;
				border-radius: 0;
			}
		
		<?php
		wp_add_inline_style( 'pegasus-admin-css', ob_get_clean() );
	}
	add_action( 'admin_enqueue_scripts', 'pegasus_tabs_plugin_admin_scripts' );
	
		