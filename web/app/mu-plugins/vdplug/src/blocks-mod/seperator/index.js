import { unregisterBlockStyle, registerBlockStyle } from '@wordpress/blocks';

registerBlockStyle('core/separator', [
    {
        name: "blueline",
        label: "Wide Blue line",
    },

]);

unregisterBlockStyle('core/separator', 'wide');
unregisterBlockStyle('core/separator', 'dots');
