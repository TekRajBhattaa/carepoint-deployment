import { dispatch } from '@wordpress/data';

function registerEndpoint() {
    dispatch('core').addEntities([
        {
            name: 'multiple-post-type', // route name
            kind: 'wp/v2', // namespace
            baseURL: '/wp/v2/multiple-post-type', // API path without /wp-json
        },
    ]);
}

export { registerEndpoint };
