<?php
/**
 * Plugin Name:       Side Menu (free version)
 * Plugin URI:        https://wordpress.org/plugins/side-menu/
 * Description:       PROVIDE ANY EXTRA CONTENT AND FUNCTIONALITY WITH SIDE MENU!
 * Version:           3.1.8
 * Author:            Wow-Company
 * Author URI:        https://wow-estore.com/author/admin/?author_downloads=true
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Declaration Wow-Company class
if ( ! class_exists( 'Wow_Company' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'asset/class-wow-company.php';
}
if ( ! class_exists( 'WOW_DATA' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'include/class/data.php';
}

// Declaration of the plugin class
if ( ! class_exists( 'Side_Menu_Class' ) ) {
	class Side_Menu_Class {
		function __construct() {
			$this->name       = 'Side Menu';
			$this->version    = '3.1.8';
			$this->pluginname = dirname( plugin_basename( __FILE__ ) );
			$this->plugindir  = plugin_dir_path( __FILE__ );
			$this->pluginurl  = plugin_dir_url( __FILE__ );
			// activate & diactivate
			register_activation_hook( __FILE__, array( $this, 'plugin_activate' ) );
			register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivate' ) );
			// admin pages
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
			// show on front end
			add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ) );
			add_action( 'wp_footer', array( $this, 'display' ) );
			// admin links
			add_filter( 'plugin_row_meta', array( $this, 'row_meta' ), 10, 4 );
			add_filter( 'plugin_action_links', array( $this, 'action_links' ), 10, 2 );
			// check asset folder
			add_filter( 'admin_init', array( $this, 'asset_folder' ) );

			add_action( 'admin_notices', array( $this, 'side_menu_notice' ) );
			add_action( 'admin_init', array( $this, 'dismiss_side_menu_notice' ) );

		}

		// Activate & diactivate
		function plugin_activate() {
			require_once plugin_dir_path( __FILE__ ) . 'include/activator.php';
		}

		function plugin_deactivate() {
			require_once plugin_dir_path( __FILE__ ) . 'include/deactivator.php';
		}

		// AdminPanel
		function add_menu_page() {
			add_submenu_page( 'wow-company', $this->name, $this->name, 'manage_options', $this->pluginname, array(
				$this,
				'plugin_admin'
			) );
		}

		function plugin_admin() {
			$name       = $this->name;
			$pluginname = $this->pluginname;
			$version    = $this->version;
			global $wow_company_plugin;
			$wow_company_plugin = true;
			include_once( 'admin/partials/main.php' );
			self:: plugin_admin_style_script();
		}

		function plugin_admin_style_script() {
			// plugin sctyle & script
			wp_enqueue_style( $this->pluginname . '-style', $this->pluginurl . 'admin/css/style.css', false, $this->version );
			wp_enqueue_script( $this->pluginname . '-script', $this->pluginurl . 'admin/js/script.js', array( 'jquery' ), $this->version );
			// icon style
			wp_enqueue_style( $this->pluginname . '-icon', $this->pluginurl . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
			// iconpicker
			wp_enqueue_script( $this->pluginname . '-fonticonpicker', $this->pluginurl . 'admin/fonticonpicker/fonticonpicker.min.js', array( 'jquery' ) );
			wp_enqueue_style( $this->pluginname . '-fonticonpicker', $this->pluginurl . 'admin/fonticonpicker/css/fonticonpicker.min.css' );
			wp_enqueue_style( $this->pluginname . '-fonticonpicker-darkgrey', $this->pluginurl . 'admin/fonticonpicker/fonticonpicker.darkgrey.min.css' );
			// wp style & script
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker-alpha', $this->pluginurl . 'admin/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ) );
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		// Show on Front end

		function display() {
			$options = get_option( 'style_side_menu' );
			global $wpdb;
			$table_menu = $wpdb->prefix . "sidemenu";
			$sSQL       = "select * from $table_menu ORDER BY menu_order ASC";
			$arrresult  = $wpdb->get_results( $sSQL );
			if ( count( $arrresult ) > 0 ) {
				echo '<div class="wp-side-menu">';
				foreach ( $arrresult as $key => $val ) {
					if ( $options['position'] == 'left' ) {
						include( 'public/partials/left.php' );
					} else {
						include( 'public/partials/right.php' );
					}
				}
				echo '</div>';
			}

			return;
		}

		function plugin_scripts() {
			wp_enqueue_script( $this->pluginname, plugin_dir_url( __FILE__ ) . 'public/js/side-menu.js', array( 'jquery' ), $this->version );
			wp_enqueue_style( $this->pluginname, plugin_dir_url( __FILE__ ) . 'public/css/style.css', array(), $this->version );
			$options = get_option( 'style_side_menu' );
			if ( $options['position'] == 'left' ) {
				wp_enqueue_style( $this->pluginname . '-css', plugin_dir_url( __FILE__ ) . 'public/css/left.css', array(), $this->version );
			} else {
				wp_enqueue_style( $this->pluginname . '-css', plugin_dir_url( __FILE__ ) . 'public/css/right.css', array(), $this->version );
			}

			wp_enqueue_style( $this->pluginname . '-font-awesome', $this->pluginurl . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );

		}


		// Admin links
		function row_meta( $meta, $plugin_file ) {
			if ( false === strpos( $plugin_file, basename( __FILE__ ) ) ) {
				return $meta;
			}
			$meta[] = '<a href="https://wow-estore.com/item/side-menu-pro/" target="_blank">Pro version</a>';

			return $meta;
		}

		function action_links( $actions, $plugin_file ) {
			if ( false === strpos( $plugin_file, basename( __FILE__ ) ) ) {
				return $actions;
			}
			$settings_link = '<a href="admin.php?page=' . esc_attr( $this->pluginname ) . '">Settings</a>';
			array_unshift( $actions, $settings_link );

			return $actions;
		}

		// check asset folder
		function asset_folder() {
			$path = plugin_dir_path( __FILE__ ) . 'asset';
			if ( ! is_writable( $path ) ) {
				echo "<div class='error' id='message'><p>Please set the 775 access rights (chmod 775) for the '" . esc_url($path) . "</p> </div>";
			}
		}

		public function side_menu_notice() {
			$user_id = get_current_user_id();
			if ( ! get_user_meta( $user_id, 'side_menu_notice_dismissed' ) ) {
				$url = esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=side-menu-lite' ), 'install-plugin_side-menu-lite' ) );
				?>
                <div class="notice notice-success" style="position: relative;">
                    <a style="text-decoration: none;" href="?dismiss-side-menu-notice" class="notice-dismiss">
                        <span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ); ?></span>
                    </a>
                    <p>Did you know, that Side Menu has a fancy new replacement called <strong><a
                                    href="https://wordpress.org/plugins/side-menu-lite/" target="_blank">Side Menu
                                Lite</a></strong>? We hope you enjoy using Side Menu Lite for user attention-grabbing!.
                    </p>
                    <ul class="ul-square">
                        <li>Unlimited menus</li>
                        <li>Open link to new window</li>
                        <li>Menu item size control</li>
                        <li>Icon and font size control</li>
                        <li>Display control on devices</li>
                        <li>Adding custom ID and Classes to each button</li>
                        <li>1480 Font Awesome 5 Icon</li>
                        <li><a href="https://wordpress.org/plugins/side-menu-lite/" target="_blank">Learn more</a> or <a
                                    href="<?php echo esc_url( $url ); ?>">Install it now!</a></li>
                    </ul>
                </div>

				<?php
			}
		}

		public function dismiss_side_menu_notice() {
			$user_id = get_current_user_id();
			if ( isset( $_GET['dismiss-side-menu-notice'] ) ) {
				add_user_meta( $user_id, 'side_menu_notice_dismissed', 'true', true );
			}
		}


	}

	$plugin = new Side_Menu_Class();
}