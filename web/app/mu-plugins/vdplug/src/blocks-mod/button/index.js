import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

domReady(function () {
    // +++ Register new block styles +++
    registerBlockStyle("core/button", {
        name: "outline2",
        label: "Outline 2",
    });
})
