import { addFilter } from "@wordpress/hooks";

/**
 * Disable Layout settings for group
 */
addFilter(
    "blocks.registerBlockType",
    "pluginname/group",
    (settings, name) => {
        if (name !== "core/group") {
            return settings;
        }

        const newSettings = {
            ...settings,
            supports: {
                ...(settings.supports || {}),
                layout: {
                    ...(settings.supports.layout || {}),
                    allowEditing: false,
                    allowSwitching: false,
                    allowInheriting: true,
                },
                __experimentalLayout: {
                    ...(settings.supports.__experimentalLayout || {}),
                    allowEditing: false,
                    allowSwitching: false,
                    allowInheriting: true,
                },
            },
        };
        return newSettings;
    },
    20
);
