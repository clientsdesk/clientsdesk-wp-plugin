<?php
/**
 * @package  ClientsdeskPlugin
 */
namespace Inc\Base;
use Inc\Base\BaseController;
/**
 *
 */
class Enqueue extends BaseController
{
    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );


    }

    function admin_enqueue() {
        // enqueue all our scripts
        wp_enqueue_style( 'clientdeskpluginstyle', $this->plugin_url . 'assets/clientsdesk_admin_style.css' );
        wp_enqueue_script( 'clientdeskpluginscript', $this->plugin_url . 'assets/clientsdesk_admin_script.js' );
    }

    function enqueue(){
        wp_register_script( 'clientsdesk-webform-submit-script', $this->plugin_url . "assets/clientsdesk_script.js", array( 'jquery' ), false, true );
        wp_localize_script( 'clientsdesk-webform-submit-script', 'ajax_url', admin_url( 'admin-ajax.php' ) );
    }
}