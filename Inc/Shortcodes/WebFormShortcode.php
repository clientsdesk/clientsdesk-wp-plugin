<?php
/**
 * @package  ClientsdeskPlugin
 */
namespace Inc\Shortcodes;
use Inc\Base\BaseController;
use Clientsdesk\API\HttpClient as ClientsdeskAPI;
/**
 *
 */
class WebFormShortcode extends BaseController
{
    public function register() {
        add_shortcode( 'clientsdesk', array( $this, 'web_form_shortcode' ) );
    }

    public function web_form_shortcode( $atts ) {
        // Attributes
        $atts = shortcode_atts(
            array(
                'form_id' => '',
            ),
            $atts,
            'clientsdesk'
        );

        wp_enqueue_script( 'clientsdesk-webform-submit-script' );



        return $this->form_builder($atts['form_id']);
    }

    private function form_builder($form_id)
    {
        // Call the from from API
        try {
            $form = $this->get_form($form_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        // Build the HTML from form.fields
        $frm = '<form action="">';
        $frm .=  $form['web_form']['html'];
        $frm .= '<input type="submit"/>';
        $frm .= '</form>';


        return $frm;
    }

    private function get_form($form_id)
    {
        $key = esc_attr(get_option('clientsdesk_api_key'));
        $signature = esc_attr(get_option('clientsdesk_api_signature'));
        if (!strlen($key) || !strlen($signature) || !strlen($form_id)) {
            throw new \Exception('Clientsdesk API Auth Failed');
        }
        $client = new ClientsdeskAPI($key, $signature, 'api-clientsdesk.eu.ngrok.io');
        try {
            $form = $client->web_forms()->show($form_id);
            return $form;
        } catch (\Exception $e) {

        }
    }
}