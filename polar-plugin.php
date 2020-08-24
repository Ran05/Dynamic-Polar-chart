<?php
/**
 * Plugin Name: polar-plugin v2
 * Plugin URI: 
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Alvin
 * Author URI: http://www.mywebsite.com
 */

// function that runs when shortcode is called
function wpb_demo_shortcode() { 
 
    // Things that you want to do. 

   
    $message = 'Hello world!'; 
    ob_start();
  
    // Output needs to be return
    if ( is_user_logged_in() )include(plugin_dir_path(__FILE__).'polarchart.php');
    $out = ob_get_clean();
    return $out;
    
}

add_shortcode('greeting', 'wpb_demo_shortcode'); 



    
function dataPolarScript() { 
    global $wpdb;
	
	  $user = wp_get_current_user();
         $userID = $user->ID;
        //  SELECT * FROM tbl_polar where time IN (select max(time) from tbl_polar WHERE `class` = 'life' AND `user_id` = '1' GROUP BY class)
     $liferesult = $wpdb->get_results('SELECT * FROM tbl_polar where time IN (select max(time) from tbl_polar where class="life" AND user_id = '.$userID.' GROUP BY class)');
	
     $businessresult = $wpdb->get_results('SELECT * FROM tbl_polar where time IN (select max(time) from tbl_polar where class="business" AND user_id = '.$userID.' GROUP BY class)');
   

     // $liferesult = $wpdb->get_results('SELECT * FROM tbl_polar where time IN (select max(time) from tbl_polar WHERE `class` = `life` AND `user_id` = '.$userID.' GROUP BY class)');
	
    //  $businessresult = $wpdb->get_results(' SELECT * FROM tbl_polar where time IN (select max(time) from tbl_polar WHERE `class` = `business` AND `user_id` = '.$userID.' GROUP BY class)');
   
   
    
    if(isset($liferesult[0]->value)){
        $life = json_encode(unserialize($liferesult[0]->value));
    }
    if(isset($businessresult[0]->value)){
        $business = json_encode(unserialize($businessresult[0]->value));
    }
 
	
		
	if(empty($businessresult)){
		$business = array();
		$business["data"] = array(
			
		);
		$business["labels"] = array(
			
		);
		$business["backgroundColor"] = array(
			
		);
		
		$business = json_encode($business);

	} 
	if(empty($liferesult)){
		$life = array();
		$life["data"] = array(
			
		);
		$life["labels"] = array(
			
		);
		$life["backgroundColor"] = array(
			
		);
		$life = json_encode($life);
	} 

    echo "<script>var life = $life;var business = $business;</script>";
 
}
add_action('wp_head', 'dataPolarScript' , 100); 


    
    function save_data_polar(){
        //echo "hello world ako";
        // save here
        $user = wp_get_current_user();
         $userID = $user->ID;
         $class =   $_POST["class"];
        global $wpdb;
      
        $result = $wpdb->get_results("SELECT * FROM `tbl_polar` WHERE DATE(time) = CURDATE()  AND time IN (select max(time) from tbl_polar where `class` = '$class' AND `user_id` = '$userID' GROUP BY class)");
      
   
       if(empty($result)){
             $wpdb->insert( "tbl_polar",
            array(  "value" => maybe_serialize($_POST) , "class" => $class ,  "user_id" => $userID ) , array('%s'  , '%s' , '%d'));
   
           echo $wpdb->insert_id;
         }
         else{
            $wpdb->update( "tbl_polar", array( 'value' =>  maybe_serialize($_POST)) ,array('id'=> $result[0]->id ));
         }

        die();
    }
    add_action( 'wp_ajax_save_data_polar', 'save_data_polar' );
    add_action( 'wp_ajax_nopriv_save_data_polar', 'save_data_polar' );


     function plugin_on_activate(){
			
        global $wpdb;
        
        $table_name = 'tbl_polar';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE `{$table_name}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `value` text NOT NULL,
            `class` varchar(24) NOT NULL,
            `user_id` int(16) NOT NULL,
            `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
register_activation_hook( __FILE__, 'plugin_on_activate' );





 ?>