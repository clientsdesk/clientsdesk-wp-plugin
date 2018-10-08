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
    /**
     * @var ClientsdeskAPI
     */
    public $client;

    public function register()
    {
        $this->client = $this->register_client();
        add_shortcode('clientsdesk', array($this, 'web_form_shortcode'));
        add_action('admin_post_nopriv_process_form', array($this, 'process_form_data'));
        add_action('admin_post_process_form', array($this, 'process_form_data'));

    }

    public function web_form_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(
                'form_id' => '',
            ),
            $atts,
            'clientsdesk'
        );

        wp_enqueue_script('clientsdesk-webform-submit-script');


        return $this->form_builder($atts['form_id']);
    }


    // This is test function to check how shortcode works.
    // TODO rebuild to AJAX
    public function process_form_data()
    {
        $form_id = $_POST['form_id'];
        if (!strlen($form_id)) {
            throw new \Exception('Clientsdesk API Auth Failed');
            return ('Clientsdesk API Auth Failed');
        }
        try {
            $response = $this->client->messages()->create($_POST);
            var_dump($response);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function register_client()
    {
        if (!isset($this->client)) {
            $key = esc_attr(get_option('clientsdesk_api_key'));
            $signature = esc_attr(get_option('clientsdesk_api_signature'));
            if (!strlen($key) || !strlen($signature)) {
                throw new \Exception('Clientsdesk API Auth Failed');
            }

            return (new ClientsdeskAPI($key, $signature, 'api-clientsdesk.eu.ngrok.io'));
        }


    }

    // TODO If we set hiden inputs on API side, like page url or something dynamic - how to fill values?
    // May be create some manual to set this vars in wordpress page templates based on their names.
    // Or pass array of vars to shortcode.

    private function form_builder($form_id)
    {
        // Call the from from API
        try {
            $form = $this->get_form($form_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        // Build the HTML from form.fields
        $frm = '<form action="' . admin_url('admin-post.php') . '" method="post">';
        $frm .= '<input type="hidden" name="action" value="process_form">';
        $frm .= '<input type="hidden" name="form_id" value="' . $form_id . '">';
        $frm .= '<input type="hidden" name="action" value="cld_sendform">';
        $frm .= html_entity_decode($form['web_form']['html']);
        $frm .= '<input type="submit"/>';
        $frm .= '</form>';


        return $frm;
    }

    private function get_form($form_id)
    {

        try {
            $form = $this->client->web_forms()->show($form_id);
            return $form;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}