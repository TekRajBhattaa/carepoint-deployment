<?php
use function Env\env;

add_filter('gform_validation_9', 'vdclassic_career_form_validation', 10, 2);
function vdclassic_career_form_validation($validation_result)
{
    $form = $validation_result['form'];
    if (!filter_var(rgpost('input_3'), FILTER_VALIDATE_EMAIL)) {
        foreach ($form['fields'] as &$field) {
            if ($field->id == '3') {
                $field->failed_validation = true;
                $validation_result['is_valid'] = false;
                $field->validation_message = __('The email address field is invalid', 'vdclassic');
                break;
            }
        }
    }
    if (rgpost('input_3') != rgpost('input_5')) {
        foreach ($form['fields'] as &$field) {
            if ($field->id == '5') {
                $field->failed_validation = true;
                $validation_result['is_valid'] = false;
                $field->validation_message = __('The confirm email address field is invalid', 'vdclassic');
                break;
            }
        }
    }
    $startdate = rgpost('input_10');
    if (strtotime($startdate) <= time()) {
        foreach ($form['fields'] as &$field) {
            if ($field->id == '10') {
                $field->failed_validation = true;
                $validation_result['is_valid'] = false;
                $field->validation_message = __('The start date should be the future date', 'vdclassic');
                break;
            }
        }
    }

    $linkedin = rgpost('input_8');
    if (!filter_var($linkedin, FILTER_VALIDATE_URL)) {
        foreach ($form['fields'] as &$field) {
            if ($field->id == '8') {
                $field->failed_validation = true;
                $validation_result['is_valid'] = false;
                $field->validation_message = __('The linkedin profile url is invalid', 'vdclassic');
                break;
            }
        }
    }
    $validation_result['form'] = $form;
    return $validation_result;
}


add_action('gform_after_submission', 'vdclassic_post_to_third_party', 10, 2);
function vdclassic_post_to_third_party($entry, $form)
{
    $personio_id = env('PERSONIO_CLIENT');
    $personio_token = env('PERSONIO_TOKEN');

    foreach ($form['fields'] as $oneField) {
        if ($oneField->type == "hidden") {
            $fieldName = $oneField->label;
        } else {
            $fieldName = $oneField->adminLabel;
        }
        if ($fieldName == "talentpool") {
            $input[$fieldName] = $entry[$oneField->id . ".1"];
        } else {
            $input[$fieldName] = $entry[$oneField->id];
        }
    }
    if (isset($input['jobId']) && $input['jobId'] != "") {
        if (isset($input["name"]) && isset($input["lastname"]) && isset($input["mail"]) && isset($input["jobId"]) && $input['mail'] == $input['mail2']) {
            switch ($input['seen']) {
                case 'Xing':
                    $seenId = 19412;
                    break;
                case 'Bierwagenevent':
                    $seenId = 21815;
                    break;
                case 'Messe':
                    $seenId = 21812;
                    break;
                case 'Instagram':
                    $seenId = 21809;
                    break;
                case 'bitte-nichts-mit-it.de':
                    $seenId = 21806;
                    break;
                case 'Twitter':
                    $seenId = 19433;
                    break;
                case 'Sonstige':
                    $seenId = 19469;
                    break;
                case 'Mitarbeiterempfehlung':
                    $seenId = 19403;
                    break;
                case 'LinkedIn':
                    $seenId = 19415;
                    break;
                case 'Indeed':
                    $seenId = 19430;
                    break;
                case 'IHK Lehrstellenbörse':
                    $seenId = 19454;
                    break;
                case 'Homepage':
                    $seenId = 19409;
                    break;
                case 'HAZ':
                    $seenId = 19463;
                    break;
                case 'Facebook':
                    $seenId = 19427;
                    break;
                case 'Bundesagentur für Arbeit':
                    $seenId = 19436;
                    break;
            }

            if (isset($input['talentpool']) && $input['talentpool'] == "Yes") {
                $talentpool = "custom_option_977";
            } else {
                $talentpool = "custom_option_978";
            }

            $submitted = false;

            $filedata = array();
            if ($input['cv'] != "") {
                $urls = json_decode($input['cv']);
                foreach ($urls as $url) {
                    $parse_url = parse_url($url);
                    $path = $parse_url['path'];
                    $fileAbsPath = str_replace('/wp/', '', ABSPATH) . $path;
                    // Prepare the parameters
                    $post_data['file'] = curl_file_create($fileAbsPath, 'application/pdf', basename($fileAbsPath));
                    $headers = [
                        "Accept: application/json",
                        "Content-Type: multipart/form-data",
                        "x-company-id: " . $personio_id,
                        "Authorization: Bearer " . $personio_token
                    ];

                    // Configure the CURL request
                    // We're using curl because wp_remote_post doesn't easily support form/multipart
                    $request = curl_init('https://api.personio.de/v1/recruiting/applications/documents');
                    curl_setopt_array($request, [
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $post_data,
                        CURLOPT_HTTPHEADER => $headers,
                        CURLOPT_RETURNTRANSFER => true
                    ]);

                    if (!empty($fileAbsPath) && is_file($fileAbsPath)) {
                        // Execute it
                        $apiUploadResponse = json_decode(curl_exec($request));
                        if ($apiUploadResponse) {
                            $filedata[] = [
                                'uuid' => $apiUploadResponse->uuid,
                                'original_filename' => $apiUploadResponse->original_filename,
                                'category' => 'other'
                            ];
                        } else {
                            echo __('File upload error: ' . curl_error($request), 'vdclassic');
                            exit();
                        }
                    }
                }
            }

            $postField = [
                'recruiting_channel_id' => $seenId,
                'first_name' => $input['name'],
                'last_name' => $input['lastname'],
                'email' => $input['mail'],
                'job_position_id' => $input['jobId'],
                'application_date' => date("Y-m-d"),
                'message' => $input['message'],
                'attributes' => [
                    [
                        'id' => 'available_from',
                        'value' => $input['available']
                    ],
                    [
                        'id' => 'phone',
                        'value' => $input['tel']
                    ],
                    [
                        "id" => "salary_expectations",
                        "value" => $input['money']
                    ],
                    [
                        "id" => "custom_attribute_277893",
                        "value" => $input['link']
                    ],
                    [
                        "id" => "custom_attribute_716197",
                        "value" => $talentpool
                    ]
                ],
                'files' => $filedata
            ];

            $apiResponse = wp_remote_post('https://api.personio.de/v1/recruiting/applications', [
                'headers' => [
                    'X-Company-ID' => $personio_id,
                    'authorization' => 'Bearer ' . $personio_token,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
                'body' => wp_json_encode($postField),
                'data_format' => 'body',
            ]);


            if ($apiResponse['response']['code'] === 201) {
                echo '<p>'.__('Submission successfull, please wait...', 'vdclassic').'</p>';
                $submitted = true;
            } else {
                // Api returned the failed reposne, We will not delete the records from the submission
            }
        }

        if ($submitted) {
            global $wpdb;
            $table = $wpdb->prefix . "gf_entry_meta";
            $table2 = $wpdb->prefix . "gf_entry";
            $wpdb->delete($table, array('entry_id' => $entry['id']));
            $wpdb->delete($table2, array('id' => $entry['id']));
            // Delete all uploads after transfered to personio
            if ($input['cv'] != "") {
                $urls = json_decode($input['cv']);
                foreach ($urls as $url) {
                    $path = explode(get_option('siteurl'), $url)[1];
                    $fileAbsPath = get_home_path() . $path;
                    if (file_exists($fileAbsPath)) {
                        unlink($fileAbsPath);
                    }
                }
            }
        }
    }
}

add_filter('gform_field_value_jobid', 'vdclassic_jobid_population_function');
function vdclassic_jobid_population_function($value)
{
    $id = get_the_ID();
    $currentPostMeta = get_post_meta($id);
    return $currentPostMeta['vd_job_personio_id'][0];
}
