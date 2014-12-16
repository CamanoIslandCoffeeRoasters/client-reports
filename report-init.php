<?php 
/*
    Plugin Name: WooCommerce Client Reports
    Plugin URI: http://buzzboxcoffee.com
    Description: Custom Reports for wooCommerce Multisite Clients
    Version: 3.0.1
    Author: Tobin Fekkes
    Author URI: http://www.tobinfekkes.com
    License: TAF2
 */ 
?>
<?php

if (!defined( 'REPORT_URL' ) )
        define('REPORT_URL', plugin_dir_url(__FILE__) );
if (!defined( 'REPORT_PATH' ) )
        define('REPORT_PATH', plugin_dir_path(__FILE__) );
if (!defined( 'REPORT_BASENAME' ) )
        define('REPORT_BASENAME', plugin_basename(__FILE__) );



 // HELLO WORLD
// ACTIVATION HOOK, CREATE TABLES
			function activate_reports() {
				global $wpdb;
				
				    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
		    $report_client_table = $wpdb->prefix . "report_client";
		    
		    $create_report_client_table = "CREATE TABLE IF NOT EXISTS " . $report_client_table . " (
		                                  id int(11) NOT NULL AUTO_INCREMENT,
		                                  client_wp_blog_id int(11) NOT NULL,
		                                  client_subdomain text NOT NULL,
		                                  client_display_name text NOT NULL,
		                                  client_date_added date NOT NULL,
		                                  PRIMARY KEY  (id),
		                                  UNIQUE KEY id (id)
		                                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		    
		    
		     dbDelta( $create_report_client_table );
			 
			 
			$report_client_meta_table = $wpdb->prefix . "report_client_meta";
		    
		    $create_report_client_meta_table = "CREATE TABLE IF NOT EXISTS " . $report_client_meta_table . " (
		                                  id int(11) NOT NULL AUTO_INCREMENT,
		                                  client_id int(11) NOT NULL,
		                                  client_meta_key text NOT NULL,
		                                  client_meta_value text NOT NULL,
		                                  PRIMARY KEY  (id),
		                                  UNIQUE KEY id (id)
		                                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		    
		    
		     dbDelta( $create_report_client_meta_table );

		     		     
			$client_id = "NULL";
		     if (is_multisite()) {
			 $parent_blog_id = $wpdb->get_var("SELECT blog_id FROM {$wpdb->blogs} WHERE blog_id = 1");
			 
			 } else {
			 	$parent_blog_id = 1;
				}
			 $wpdb->insert(
			 				"" . $wpdb->prefix . "report_client",
			 													array(
						 				'id' 					=> $client_id, 
						 				'client_wp_blog_id' 	=> $parent_blog_id,
						 				'client_subdomain'		=> 'www',
						 				'client_display_name'	=> get_option('blogname'),
						 				'client_date_added'		=> date("Y-m-d")
						 ) ); 
		     
			} 
			
	register_activation_hook( REPORT_PATH . "report-init.php", "activate_reports");




// DEACTIVATION HOOK, DROP TABLES (UNCOMMENT TO TRUNCATE TABLES)
			function deactivate_reports() {
				global $wpdb;
		
		    $report_client_table = $wpdb->prefix . "report_client";
		    
		     //$wpdb->query("TRUNCATE TABLE " . $report_client_table);
			 
			 
			$report_client_meta_table = $wpdb->prefix . "report_client_meta";
		    
		     //$wpdb->query("TRUNCATE TABLE " . $report_client_meta_table);
			} 
	
	register_deactivation_hook( REPORT_PATH . "report-init.php", "deactivate_reports");

	
	
// UNINSTALLATION HOOK, DROP TABLES (UNCOMMENT TO DROP TABLES)
			function uninstall_reports() {
				global $wpdb;
		
		    $report_client_table = $wpdb->prefix . "report_client";
		    
		     //$wpdb->query("DROP TABLE " . $report_client_table);
			 
			 
			$report_client_meta_table = $wpdb->prefix . "report_client_meta";
		    
		     //$wpdb->query("DROP TABLE " . $report_client_meta_table);
			} 
	
	register_uninstall_hook( REPORT_PATH . "report-init.php", "uninstall_reports");





// DISPLAY DASHBOARD OR SELECTED TAB 
function client_reports () {
    add_menu_page( 'Client Reports', 'Client Reports', 'manage_options', 'client_dashboard', 'client_dashboard', '/wp-content/uploads/2013/10/BBC-favicon2.png', $position );
}

add_action( 'admin_menu', 'client_reports' );


function client_dashboard() {
	
	
		
	function admin_tabs( $current = 'dashboard' ) {
	
    $tabs = array( 'dashboard' => 'Dashboard', 'add_client' => 'Add Client', 'settings' => 'Settings' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=client_dashboard&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

global $pagenow;


wp_nonce_field( "ilc-settings-page" );

	if ( isset ( $_GET['tab'] ) ) {
		 admin_tabs($_GET['tab']);
	} 
		
	else { 
		admin_tabs('dashboard');
	}

		if ( $pagenow == 'admin.php' && $_GET['page'] == 'client_dashboard' ) {

   			if ( isset ( $_GET['tab'] ) ) { 
   				$tab = $_GET['tab'];
   			}
   			else {
   				$tab = 'dashboard';
			}

	switch ( $tab ){
		       
		case 'dashboard' :
		         ?>
		            <br />
		                <?php include(REPORT_PATH . "admin/tabs/tab-dashboard.php") ?>
		                
		         <?php
		      break;
			  
		case 'add_client' :
		         ?>
		            <br />
		                <?php include(REPORT_PATH . "admin/tabs/tab-add_client.php") ?>
		            
		         <?php
		      break;
		       
		case 'settings' :
		         ?>
		            <br />
		                <?php include(REPORT_PATH . "admin/tabs/tab-settings.php") ?>
		
		         <?php
		      break;
		
		   }

		}

	}

?>