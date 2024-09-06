import { registerBlockVariation } from '@wordpress/blocks';
/**
 * Register the Article Categories variation for the Post Terms block.
 */
registerBlockVariation(
    'core/post-terms', [{
        name: 'job-location',
        title: 'Job Location',
        icon: 'category',
        isDefault: false,
        attributes: { term: 'vd_job_location' },
    },
    {
        name: 'job-department',
        title: 'Job Department',
        icon: 'category',
        isDefault: false,
        attributes: { term: 'vd_job_department' },
    }]
);
