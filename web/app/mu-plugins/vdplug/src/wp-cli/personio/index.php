<?php
namespace WP_CLI\Personio;

use WP_Query;

include __DIR__ . '/template.php';

// Import job feed from Personio API
// https://developer.personio.de/reference/get_xml


/**
 * Load XML feed with simplexml
 */
function getJobs()
{
    $list = simplexml_load_file('https://hornetsecurity.jobs.personio.de/xml');
    // $list = simplexml_load_file(home_url('app/uploads/personio--small.xml'), 'SimpleXMLElement', LIBXML_NOCDATA);
    return $list;
}

/**
 * Remove jobs with a vd_job_personio_id key that is not in XML feed anymore!
 * @param string[] $allJobIds
 * @param bool $debug
 */
function removedJobs($allJobIds, $debug = true)
{
    // Get all vd_job and loop over it
    $myJobs = new WP_Query(array(
        'cache_results'  => false,
        'post_type'     => 'vd_job',
        'post_status' => ['publish', 'pending', 'draft', 'future', 'private'],
        'posts_per_page' => -1,
        'meta_key' => 'vd_job_personio_id'
    ));

    if ($myJobs->have_posts()) {
        while ($myJobs->have_posts()) {
            $myJobs->the_post();
            $myJobId = get_post_meta(get_the_ID(), 'vd_job_personio_id', true);

            if (!in_array($myJobId, $allJobIds)) {
                // Not included XML feed
                if ($debug) {
                    printf("🗑 PERSONIO ID: %s, POST ID: %s removed from personio!\n", $myJobId, get_the_ID());
                }

                // Change post status
                // $post_unpublish_id = wp_update_post(array(
                //     'post_status'   => 'draft',
                // ));

                // Delete post
                $status = wp_delete_post(get_the_ID(), false);

                if (!is_wp_error($status)) {
                    // the post update is valid
                    if ($debug) {
                        printf("ⓘ The post moved to 'trash'!\n", $myJobId, get_the_ID());
                    }
                } else {
                    if ($debug) {
                        printf("⚠ PERSONIO ID: %s, POST ID: %s There was a error moving the post to trash bin!\n", $myJobId, get_the_ID());
                    }
                }
            }
        }
    }

    wp_reset_postdata();
}

/**
 * Loop over XML feed and import every data row
 */
function importJobs()
{
    $jobs = getJobs();
    $jobIds = array();
    $catIds = array(16, 18, 17);

    foreach ($jobs->position as $job) {
        printf("++ %s (JOB ID: %s)\n", $job->name, $job->id);

        // Prepared variables stored in post
        $page_title = $job->name;
        $page_content = \WP_CLI\Personio\Template\renderMarkup($job);
        $terms_department = preg_split("/\,/", $job->department);
        $terms_location = preg_split("/\,/", $job->office);

        $data_default = array(
            'post_type'     => 'vd_job',
            'post_title'    => $page_title,      // Title of the Content
            'post_content'  => $page_content,    // Content
            'post_status'   => 'pending',        // Post Status
            'meta_input'   => array(
                'vd_job_personio_id' => strval($job->id)
            )
        );

        $myposts = get_posts(array(
            'post_type'     => 'vd_job',
            'post_status' => ['publish', 'pending', 'draft', 'future', 'private'],
            'meta_key' => 'vd_job_personio_id',
            'meta_value'     => strval($job->id)
        ), 'OBJECT');

        if (count($myposts) > 0) {
            // Job Post exits, do only update....
            $mypost = $myposts[0];
            printf("ⓘ Processing (%s) EXISTING Post ID: %s\n", $job->id, $mypost->ID);

            if ($mypost->ID) {
                $update_data = array_merge($data_default, array(
                    'ID' => $mypost->ID
                ));
                $post_id = wp_update_post($update_data);
                if (!is_wp_error($post_id)) {
                    // the post is valid, update terms
                    wp_set_object_terms($mypost->ID, $terms_location, 'vd_job_location', false);
                    wp_set_object_terms($mypost->ID, $terms_department, 'vd_job_department', false);
                } else {
                    echo "⚠ There was an error in modify the job";
                    echo $post_id->get_error_message();
                }
            }
        } else {
            // No Job Post, insert a new job post....
            $update_data = array_merge($data_default, array(
                'post_author'   => 1,  // Post Author ID
            ));
            $post_id = wp_insert_post($update_data);
            if (!is_wp_error($post_id)) {
                printf("ⓘ Processing (%s) NEW Post ID: %s\n", $job->id, $post_id);
                // the post is valid
                wp_set_object_terms($post_id, $terms_location, 'vd_job_location', false);
                wp_set_object_terms($post_id, $terms_department, 'vd_job_department', false);
            } else {
                printf("⚠ There was an error in the job insertion\n", $post_id->get_error_message());
            }
        }
        // if ($post_id) {
        //     wp_set_object_terms($post_id, array_rand($catIds), 'vd_job_seniority');
        // }
        wp_reset_postdata();
        $jobIds[] = (string)$job->id;
    }

    // Remove job post not in XML feed anymore
    removedJobs($jobIds);
}
