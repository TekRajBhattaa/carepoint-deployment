<?php

use function Env\env;

/**
 * Mapping for contact forms (GravityForms)
 */
function vdplug_hse_pardot($validation_result)
{
    if (!$validation_result["is_valid"]) {
        return $validation_result;
    }

    return $validation_result;
}
add_filter('gform_validation', 'vdplug_hse_pardot');

/**
 * Display form with docsign checkbox
 * https://docs.gravityforms.com/gform_form_settings_fields/
 */
function vdplug_custom_form_setting($fields, $form)
{
    /**
     * NEW CODE WITH NEW API < v2.5 Gravityforms !!!
     */

    // works if only one field being added
    // must have at least Gravity Forms version 2.4.7
    $new_field_id = GFFormsModel::get_next_field_id($form['fields']);

    $field_docusign = array(
        'type' => 'toggle',
        'id' => $new_field_id, // The Field ID must be unique
        'class' => 'werner',
        'name' => 'hse_docsign',
        'defaultValue' => 1,
        'isRequired' => false,
        'horizontal'    => true,
        'formId' => $form['id'],
        'pageNumber'  => 1, // Ensure this is correct
        'label' => esc_html__('Use Docsign', 'vdplug'),
        'description' => esc_html__('Soll dieses Formular für docusign aktiviert werden?', 'vdplug'),
        'save_callback' => function ($field, $value) {
            update_option('enable_hse_docsign', (bool) $value);

            return $value;
        },
    );
    $fields['form_options']['fields'][] = $field_docusign;

    return $fields;
}
add_filter('gform_form_settings_fields', 'vdplug_custom_form_setting', 10, 2);

/**
 * Populate form instance with $_POST['hse_docsign']
 */
function vdplug_save_my_custom_form_setting($form)
{
    $form['hse_docsign'] = rgpost('_gform_setting_hse_docsign');
    return $form;
}
add_filter('gform_pre_form_settings_save', 'vdplug_save_my_custom_form_setting');

/**
 * Check submitted form for hse_docsign setting and call remote API
 * https://docs.gravityforms.com/gform_after_submission/#h-3-send-entry-data-to-third-party
 */
function vdplug_hse_docusign_form($entry, $form)
{
    if ($form['hse_docsign'] == '1') {
        vdplug_hse_docusign($entry);
    }
}
add_filter('gform_after_submission', 'vdplug_hse_docusign_form', 10, 2);

/**
 * Recieve access token
 */
function vdplug_get_docusign_auth_code()
{
    $user_id   = env('DOCUSIGN_USER_ID');
    $client_id = env('DOCUSIGN_CLIENT_ID');
    $host = "account.docusign.com";
    $key = env('DOCUSIGN_KEY');

    $tstamp = time();
    $payload = array(
        "iss" => $client_id,
        "sub" => $user_id,
        "iat" => $tstamp,
        "exp" => $tstamp+60*1000,
        "aud" => $host,
        "scope" => "signature impersonation"
    );

    $jwt = \Firebase\JWT\JWT::encode($payload, $key, 'RS256');
    $headers = array('Accept' => 'application/json');
    $data = array('grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $jwt);

    $ch = curl_init("https://$host/oauth/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set the posted fields
    $r = curl_exec($ch); // Execute the cURL statement
    curl_close($ch); // Close the cURL connection
    if (empty($r)) {
        return false;
    }
    $obj = json_decode($r);

    if (empty($obj)) {
        return false;
    }
    if (!property_exists($obj, 'access_token')) {
        return false;
    }

    return $obj->access_token;
}

/**
 * sign document
 */
function vdplug_hse_docusign($result)
{
    $accessToken = vdplug_get_docusign_auth_code();
    if (empty($accessToken)) {
        return;
    }

    $form       = GFAPI::get_form($result["form_id"]);
    $form_data  = array();

    $last_name  = "";
    $first_name = "";
    $email      = "";
    $country    = "";
    $tplId      = "";
    $distriname = "";
    foreach ($form['fields'] as $field) {
        if (!isset($field->adminLabel) || empty($field->adminLabel)) {
            continue;
        }
        $lbl = $field->adminLabel;
        $val = $result[$field->id];
        if (empty($val)) {
            continue;
        }
        $form_data[$lbl] = $val;
        if ($lbl == "signer_first_name") {
            $first_name = $val;
        } elseif ($lbl == "signer_last_name") {
            $last_name = $val;
        } elseif ($lbl == "signer_email") {
            $email = $val;
        } elseif (strpos($lbl, "Land für ") !== false && !empty($val)) {
            $tplId = $val;
            foreach ($field->choices as $choice) {
                if ($val == $choice["value"]) {
                    $country = $choice["text"];
                }
            }
        } elseif ($lbl == "distribution") {
            $distriname = $val;
        }
    }
    if (empty($tplId)) {
        return;
    }
    $form_data["company_country"] = $country;
    $form_data["distribution"]    = $distriname;

    $parts      = explode("_", $tplId);
    $templateId = false;
    $catId      = 432;

    if (isset($parts[2]) && $parts[2] != "dummy") {
        $templateId = $parts[2];
    }

    if (isset($parts[1])) {
        if (!$templateId && $parts[1] != "dummy" && !is_numeric($parts[1])) {
            $templateId = $parts[1];
        } elseif (is_numeric($parts[1])) {
            $catId = $parts[1];
        }
    }
    if (!$templateId) {
        return;
    }
    $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition(['status' => 'sent', 'template_id' => $templateId]);

    $txt_tabs = array();
    foreach ($form_data as $lbl => $val) {
        $txt_tabs[] = new \DocuSign\eSign\Model\Text(['tab_label' => $lbl, 'value' => $val]);
    }
    $tabs = new \DocuSign\eSign\Model\Tabs(['text_tabs' => $txt_tabs]);

    $signer = new \DocuSign\eSign\Model\TemplateRole([
        'email'     => $email,
        'name'      => "$first_name $last_name",
        'role_name' => 'Partner',
        'tabs'      => $tabs
    ]);
    $envelope_definition->setTemplateRoles([$signer]);
    $accountId = 'a92317d1-de5d-4d38-9e1e-17867d709bdf';

    # The API base_path
    #$basePath = 'https://docusign.net/restapi';
    $basePath = 'https://eu.docusign.net/restapi';
    $config = new DocuSign\eSign\Configuration();
    $config->setHost($basePath);
    $config->addDefaultHeader("Authorization", "Bearer " . $accessToken);
    #print_r($config);
    $apiClient   = new DocuSign\eSign\Client\ApiClient($config);
    #print_r($apiClient);
    $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi($apiClient);
    #print_r($accountId);
    #print_r($envelope_definition);
    #print_r($envelopeApi);
    $envelopeApi->createEnvelope($accountId, $envelope_definition);
}
