<?php
/*
Plugin Name: Font Awesome Experiment
Plugin URI: -
Description: -
Version: 0.1
Author: Edvin Brobeck
Author URI: http://www.raketwebbyra.se
*/

/*
 * Shortcode function
 */
function dws_icons($params, $content = null){
    extract(shortcode_atts(array(
        'name' => 'default'
    ), $params));

    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<i class="'.$name.'"></i>';
    return force_balance_tags( $result );
}
add_shortcode('icon', 'dws_icons');


class fontawesome_raket{
	
	function __construct()
	{
		add_action('init',array(&$this, 'init'));

	}
	
	function init(){

        //Add font awesome to BackEnd And FrontEnd
		if(!is_admin()){
            wp_enqueue_style("fontawesome", 'http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css');
		} else {
            wp_enqueue_style("fontawesome", 'http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css');
			wp_enqueue_style("dws_admin_style", plugins_url('assets/css/admin.css', __FILE__ ));
		}

        //Fail safe - Kick out 'dat Cheater!
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}

        //Register TMCE Plugin
		add_filter( 'mce_external_plugins', array(&$this, 'regplugins') );
		add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );

        //Add Fontawesome to the Editor Iframe
        function plugin_mce_css( $mce_css ) {
            if ( ! empty( $mce_css ) )
                $mce_css .= ',';
            $mce_css .= 'http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css';
            return $mce_css;
        }
        add_filter( 'mce_css', 'plugin_mce_css' );
	}

	function regbtns($buttons)
	{
		array_push($buttons, 'dws_icons');
		return $buttons;
	}

	function regplugins($plgs)
	{
		$plgs['dws_icons'] = plugins_url('assets/js/plugins/icons.js', __FILE__ );
		return $plgs;
	}
}
$fontawesome_raket = new fontawesome_raket();