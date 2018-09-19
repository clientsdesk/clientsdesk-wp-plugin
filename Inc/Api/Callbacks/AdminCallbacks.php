<?php
/**
 * @package  ClientsdeskPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;
use Clientsdesk\API\HttpClient as ClientsdeskAPI;
use Clientsdesk\API\Exceptions\ApiResponseException;

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {

        $key = esc_attr(get_option('clientsdesk_api_key'));
        $signature = esc_attr(get_option('clientsdesk_api_signature'));

        if (!strlen($key) || !strlen($signature)) {
            return require_once("$this->plugin_path/templates/no_auth_admin.php");
        }

        $client = new ClientsdeskAPI($key, $signature, 'api-clientsdesk.eu.ngrok.io');

        if(isset($_GET['form_id'])){
            $this->showWebForm($client, $_GET['form_id']);
        } else {
            $this->indexWebForms($client);
        }

    }

    public function adminSettings()
    {
        return require_once("$this->plugin_path/templates/settings.php");
    }

    public function clientsdeskAdminSection()
    {
        echo 'Enter Auth details here';
    }

    public function clientsdeskApiKey()
    {
        $value = esc_attr(get_option('clientsdesk_api_key'));
        echo '<input type="text" class="regular-text" name="clientsdesk_api_key" value="' . $value . '" placeholder="ClientsDesk API Key">';
    }

    public function clientsdeskApiSignature()
    {
        $value = esc_attr(get_option('clientsdesk_api_signature'));
        echo '<input type="text" class="regular-text" name="clientsdesk_api_signature" value="' . $value . '" placeholder="ClientsDesk API Signature">';
    }

    private function indexWebForms(ClientsdeskAPI $client)
    {

        $indexParams = [
            'page' => 0,
            'per_page' => 20
        ];

        try {
            $response = $client->web_forms()->getIndex($indexParams);
            return require_once("$this->plugin_path/templates/dashboard.php");
        } catch (ApiResponseException $e) {
            return require_once("$this->plugin_path/templates/error_admin.php");
        }
    }

    private function showWebForm(ClientsdeskAPI $client, $form_id){

        try {
            $response = $client->web_forms()->show($form_id);
            return require_once("$this->plugin_path/templates/show_web_form.php");
        } catch (ApiResponseException $e) {
            return require_once("$this->plugin_path/templates/error_admin.php");
        }

    }


}