<?php

// This are the default blocks for new post types
define('VDPLUG_JOB_TPL', array(
    array('core/cover', array(
        "className" => "hero jobinfo",
        "backgroundColor" => "gray",
        "dimRatio" => 0,
        "url" => "/app/mu-plugins/vdplug/static/job-background.png",
    ),
    array(

        array('core/post-title', array(
            'textAlign' => 'left'
        )),
        array('core/post-terms', array(
                'textAlign' => 'left',
                'className' => 'job-department',
                'term' => 'vd_job_department',
                'prefix'=> ' Department: '
        )),
        array('core/post-terms', array(
                'textAlign' => 'left',
                'className' => 'job-location',
                'term' => 'vd_job_location',
                'prefix'=> 'Location: '
        )),
        array('core/buttons', array(
            'textAlign' => 'left',
        ), array(
            array('core/button', array(
                'text' => 'Apply Now',
                'textAlign' => 'left',
                'className' => 'is-style-outline',
                'link' => array(
                    'href' => '#application_area',
                )
            ))
        )),
    )),
    array('verdure/section', array(
        "className" => "jobinfo",
        ),
        array(
            array('core/paragraph', array(
                'content' => 'Please enter your job details here...',
            )),
            array('core/heading', array(
                    'size' => 'h2',
                    'className' => 'jobform-heading',
                    'content' => 'Please Fill Out This Application Form To Aply For This Position',
                    'textAlign' => 'center'
                )
            ),
            array('gravityforms/form', array(
                'formId' => '9',
                "id" => "application-area",
                "title" => false,
                "description" => false,
                "ajax" => true,
                "inputPrimaryColor" => "#204ce5"
            ))
        )
    )
));

function vdplug_create_job_posttype()
{
    // Register custom taxonomy for vd_job
    register_taxonomy('vd_job_location', 'vd_job', [
        'label' => __('Office Location', 'vdplug'),
        'rewrite' => [
            'slug' => 'job-loc',
            'with_front' => true
        ],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Office Location', 'vdplug'),
            'all_items' => __('All Office Locations', 'vdplug'),
            'edit_item' => __('Edit Office Location', 'vdplug'),
            'view_item' => __('View Office Location', 'vdplug'),
            'update_item' => __('Update Office Location', 'vdplug'),
            'add_new_item' => __('Add New Office Location', 'vdplug'),
            'new_item_name' => __('New Office Location Name', 'vdplug'),
            'search_items' => __('Search Office Locations', 'vdplug'),
            'parent_item' => __('Parent Office Location', 'vdplug'),
            'parent_item_colon' => __('Parent Office Location:', 'vdplug'),
            'not_found' => __('No Office Locations found', 'vdplug'),
        ]
    ]);

    register_taxonomy('vd_job_department', 'vd_job', [
        'label' => __('Department', 'vdplug'),
        'rewrite' => [
            'slug' => 'job-dep',
            'with_front' => true
        ],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Department', 'vdplug'),
            'all_items' => __('All Departments', 'vdplug'),
            'edit_item' => __('Edit Department', 'vdplug'),
            'view_item' => __('View Department', 'vdplug'),
            'update_item' => __('Update Department', 'vdplug'),
            'add_new_item' => __('Add New Department', 'vdplug'),
            'new_item_name' => __('New Department Name', 'vdplug'),
            'search_items' => __('Search Departments', 'vdplug'),
            'parent_item' => __('Parent Department', 'vdplug'),
            'parent_item_colon' => __('Parent Department:', 'vdplug'),
            'not_found' => __('No Departments found', 'vdplug'),
        ]
    ]);

    register_post_type(
        'vd_job',
        array(
            'labels' => array(
                'name' => __('Jobs'),
                'all_items' => __('All Jobs', 'vdplug'),
                'singular_name' => __('Job'),
                'add_new' => __('Add New Job', 'vdplug'),
                'add_new_item' => __('Add New Job', 'vdplug'),
                'edit_item' => __('Edit Job', 'vdplug'),
                'new_item' => __('New Job', 'vdplug'),
                'view_item' => __('View Job', 'vdplug'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'menu_icon' => 'dashicons-id-alt',
            'rewrite' => array(
                'slug' => 'job',
                'with_front' => false
            ),
            'show_in_rest' => true,
            'taxonomies' => array('vd_job_location', 'vd_job_department'),
            'template' => VDPLUG_JOB_TPL,
        )
    );

    /**
     * Register custom post meta field.
     */
    register_post_meta(
        'vd_job',
        'vd_job_personio_id',
        array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        )
    );

    register_term_meta(
        'vd_job_location',
        'vd_job_location_country',
        array(
            'type' => 'string',
            'description' => 'Please enter the country name',
            'single' => true,
            'show_in_rest' => array(
                'schema' => array(
                    'type' => 'string',
                    'format' => 'url',
                    'context' => array( 'view', 'edit' ),
                    'readonly' => true,
                )
            ),
        )
    );
}


add_action('init', 'vdplug_create_job_posttype');


add_action('vd_job_location_edit_form_fields', 'edit_country_field', 10, 2);
add_action('edited_vd_job_location', 'save_taxonomy_custom_fields', 10, 2);

function edit_country_field($taxonomy)
{
    $t_id = $taxonomy->term_id; // Get the ID of the term you're editing
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check
    ?>
<tr class="form-field">
    <th scope="row" valign="top">
        <label for="vd-country"><?php _e('Country', 'vdplug'); ?></label>
    </th>
    <td>
        <input type="text" name="term_meta[vd_job_location_country]" id="vd-country" value="<?php echo $term_meta['vd_job_location_country'] ? $term_meta['vd_job_location_country'] : ''; ?>"><br />
        <p class="description"><?php _e('Please enter the country for this location', 'vdplug'); ?></span>
    </td>
</tr>
    <?php
}

// A callback function to save our extra taxonomy field(s)
function save_taxonomy_custom_fields($term_id)
{
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}
