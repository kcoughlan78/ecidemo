<?php

if(!defined('WP_ADMIN') || !is_admin()) return;

if(NEXTEND_SMART_SLIDER2_BASE == 'nextend-smart-slider2-full'){
    if(!file_exists(WP_PLUGIN_DIR.'/nextend/nextend.php')){
      require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
      
      class nextend_smart_slider2 extends Plugin_Installer_Skin{
        	function feedback($string) {
        		if ( isset( $this->upgrader->strings[$string] ) )
        			$string = $this->upgrader->strings[$string];
        
        		if ( strpos($string, '%') !== false ) {
        			$args = func_get_args();
        			$args = array_splice($args, 1);
        			if ( !empty($args) )
        				$string = vsprintf($string, $args);
        		}
        		if ( empty($string) )
        			return;
        		echo $string;
        	}
        };
        
      	$upgrader = new Plugin_Upgrader( new nextend_smart_slider2( compact('type', 'title', 'nonce') ) );
        ob_start();
      	$result = $upgrader->install( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'nextend/nextend.zip');
        if(!$result){
            ob_clean();
            echo 'It seems like that the WordPress installer can not write '.WP_PLUGIN_DIR;
            echo '<br>Please install manually the following library plugin:  <a href="'.content_url('plugins/nextend-smart-slider2-full/nextend/nextend.zip').'">wp-contents/plugins/nextend-smart-slider2-full/nextend/nextend.zip</a> => Then you can activate this plugin!';
            
            exit;
        }else{
            ob_clean();
        }
    }
    if(!is_plugin_active('nextend/nextend.php')){
        add_action('activated_plugin', 'nextend_smart_slider2_activated_plugin', 11, 2);
    
        function nextend_smart_slider2_run_activate_plugin( $plugin, $network_wide) {
            if($network_wide){
                $current = get_site_option( 'active_sitewide_plugins', array() );
            }else{
                $current = get_option( 'active_plugins', array() );
            }
            
            $plugin = plugin_basename( trim( $plugin ) );
            do_action( 'activate_plugin', $plugin, $network_wide);
            do_action( 'activate_' . $plugin, $network_wide);		
            if ( $network_wide ) {
          			$current[$plugin] = time();
          			update_site_option( 'active_sitewide_plugins', $current );
        		} else {
          			$current[] = $plugin;
          			sort($current);
          			update_option('active_plugins', $current);
        		}
            do_action( 'activated_plugin', $plugin, $network_wide);
            
            return null;
        }
        function nextend_smart_slider2_activated_plugin($plugin, $network_wide){
            if($plugin == 'nextend-smart-slider2-full/nextend-smart-slider2-full.php'){
                nextend_smart_slider2_run_activate_plugin('nextend/nextend.php', $network_wide);
            }
        }
    }
}
