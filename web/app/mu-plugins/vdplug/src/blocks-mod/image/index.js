import { unregisterBlockStyle } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

domReady(function () {
    // +++ Remove default "rounded" style +++
    unregisterBlockStyle("core/image", "rounded");
})
