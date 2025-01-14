<?php

/**
 * Backend Class for use in all Yoast plugins
 * Version 0.2
 */

if (!class_exists('Escalate_GA_Plugin_Admin')) {
	class Escalate_GA_Plugin_Admin {

		var $feed		= 'http://www.escalateseo.comfeed/';
		var $hook 		= '';
		var $filename	= '';
		var $longname	= '';
		var $shortname	= '';
		var $ozhicon	= '';
		var $optionname = '';
		var $homepage	= '';
		var $accesslvl	= 'edit_users';
		
		function __construct() {
		}
		
		function add_ozh_adminmenu_icon( $hook ) {
			if ($hook == $this->hook) 
				return $this->plugin_url.$this->ozhicon;
			return $hook;
		}
		
		function config_page_styles() {
			if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
				wp_enqueue_style('dashboard');
				wp_enqueue_style('thickbox');
				wp_enqueue_style('global');
				wp_enqueue_style('wp-admin');
				wp_enqueue_style('ga-admin-css', $this->plugin_url . 'yst_plugin_tools.css');
			}
		}

		function register_settings_page() {
			add_options_page($this->longname, $this->shortname, $this->accesslvl, $this->hook, array(&$this,'config_page'));
		}
		
		function plugin_options_url() {
			return admin_url( 'options-general.php?page='.$this->hook );
		}
		
		/**
		 * Add a link to the settings page to the plugins list
		 */
		function add_action_link( $links, $file ) {
			static $this_plugin;
			if( empty($this_plugin) ) $this_plugin = $this->filename;
			if ( $file == $this_plugin ) {
				$settings_link = '<a href="' . $this->plugin_options_url() . '">' . __('Settings') . '</a>';
				array_unshift( $links, $settings_link );
			}
			return $links;
		}
		
		function config_page() {
			
		}
		
		function config_page_scripts() {
			if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
				wp_enqueue_script('postbox');
				wp_enqueue_script('dashboard');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('media-upload');
			}
		}

		/**
		 * Create a Checkbox input field
		 */
		function checkbox($id) {
			$options = get_option( $this->optionname );
			return '<input type="checkbox" id="'.$id.'" name="'.$id.'"'. checked($options[$id],true,false).'/>';
		}

		/**
		 * Create a Text input field
		 */
		function textinput($id) {
			$options = get_option( $this->optionname );
			return '<input class="text" type="text" id="'.$id.'" name="'.$id.'" size="30" value="'.$options[$id].'"/>';
		}

		/**
		 * Create a dropdown field
		 */
		function select($id, $options, $multiple = false) {
			$opt = get_option($this->optionname);
			$output = '<select class="select" name="'.$id.'" id="'.$id.'">';
			foreach ($options as $val => $name) {
				$sel = '';
				if ($opt[$id] == $val)
					$sel = ' selected="selected"';
				if ($name == '')
					$name = $val;
				$output .= '<option value="'.$val.'"'.$sel.'>'.$name.'</option>';
			}
			$output .= '</select>';
			return $output;
		}
		
		/**
		 * Create a potbox widget
		 */
		function postbox($id, $title, $content) {
		?>
			<div id="<?php echo $id; ?>" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php echo $title; ?></span></h3>
				<div class="inside">
					<?php echo $content; ?>
				</div>
			</div>
		<?php
		}	


		/**
		 * Create a form table from an array of rows
		 */
		function form_table($rows) {
			$content = '<table class="form-table">';
			$i = 1;
			foreach ($rows as $row) {
				$class = '';
				if ($i > 1) {
					$class .= 'yst_row';
				}
				if ($i % 2 == 0) {
					$class .= ' even';
				}
				$content .= '<tr id="'.$row['id'].'_row" class="'.$class.'"><th valign="top" scrope="row">';
				if (isset($row['id']) && $row['id'] != '')
					$content .= '<label for="'.$row['id'].'">'.$row['label'].':</label>';
				else
					$content .= $row['label'];
				$content .= '</th><td valign="top">';
				$content .= $row['content'];
				$content .= '</td></tr>'; 
				if ( isset($row['desc']) && !empty($row['desc']) ) {
					$content .= '<tr class="'.$class.'"><td colspan="2" class="yst_desc"><small>'.$row['desc'].'</small></td></tr>';
				}
					
				$i++;
			}
			$content .= '</table>';
			return $content;
		}

		/**
		 * Create a "plugin like" box.
		 */
		function plugin_like($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>'.__('Why not do any or all of the following:','ystplugin').'</p>';
			$content .= '<ul>';
			$content .= '<li><a href="'.$this->homepage.'">'.__('Link to it so other folks can find out about it.','ystplugin').'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Give it a good rating on WordPress.org.','ystplugin').'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Let other people know that it works with your WordPress setup.','ystplugin').'</a></li>';
			$content .= '</ul>';
			$this->postbox($hook.'like', 'Like this plugin?', $content);
		}	
		
		/**
		 * Info box with link to the bug tracker.
		 */
		function plugin_support($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>If you\'ve found a bug in this plugin, please submit it in the <a href="http://www.yoast.com/mantis/bug_report_page.php">Yoast Bug Tracker</a> with a clear description.</p>';
			$this->postbox($this->hook.'support', __('Found a bug?','ystplugin'), $content);
		}

		/**
		 * Box with latest news from Yoast.com
		 */


		function text_limit( $text, $limit, $finish = ' [&hellip;]') {
			if( strlen( $text ) > $limit ) {
		    	$text = substr( $text, 0, $limit );
				$text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
				$text .= $finish;
			}
			return $text;
		}

		function db_widget() {
			$options = get_option('yoastdbwidget');
			if (isset($_POST['yoast_removedbwidget'])) {
				$options['removedbwidget'] = true;
				update_option('yoastdbwidget',$options);
			}			
			if ($options['removedbwidget']) {
				_e("If you reload, this widget will be gone and never appear again, unless you decide to delete the database option 'yoastdbwidget'.");
				return;
			}
			require_once( ABSPATH . WPINC .'/rss.php' );
			if ( $rss = fetch_rss( $this->feed ) ) {
				echo '<div class="rss-widget">';
				echo '<a href="http://www.escalateseo.com" title="'.__('Go to Yoast.com').'"><img src="'.$this->plugin_url.'images/yoast-logo-rss.png" class="alignright" alt="Yoast"/></a>';			
				echo '<ul>';
				$rss->items = array_slice( $rss->items, 0, 3 );
				foreach ( (array) $rss->items as $item ) {
					echo '<li>';
					echo '<a class="rsswidget" href="'.clean_url( $item['link'], $protocolls=null, 'display' ).'">'. htmlentities($item['title']) .'</a> ';
					echo '<span class="rss-date">'. date('F j, Y', strtotime($item['pubdate'])) .'</span>';
					echo '<div class="rssSummary">'. $this->text_limit($item['summary'],250) .'</div>';
					echo '</li>';
				}
				echo '</ul>';
				echo '<div style="border-top: 1px solid #ddd; padding-top: 10px; text-align:center;">';
				echo '<a href="http://feeds2.feedburner.com/joostdevalk"><img src="'.get_bloginfo('wpurl').'/wp-includes/images/rss.png" alt=""/> '.__('Subscribe with RSS').'</a>';
				echo ' &nbsp; &nbsp; &nbsp; ';
				echo '<a href="http://www.escalateseo.comemail-blog-updates/"><img src="'.$this->plugin_url.'images/email_sub.png" alt=""/> '.__('Subscribe by email').'</a>';
				echo '<form class="alignright" method="post"><input type="hidden" name="yoast_removedbwidget" value="true"/><input title="'.__('Remove this widget from all users dashboards').'" type="submit" value="X"/></form>';
				echo '</div>';
				echo '</div>';
			}
		}

		function widget_setup() {
			$options = get_option('yoastdbwidget');
			if (!$options['removedbwidget'])
		    	wp_add_dashboard_widget( 'yoast_db_widget' , __('The Latest news from Yoast') , array(&$this, 'db_widget'));
		}
	}
}

?>