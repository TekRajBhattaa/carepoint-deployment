import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { BaseControl, TextControl, PanelRow } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';

const VdLocationSidebar = () => {
    const [postType,] = useEntityProp('postType', 'vd_location', 'type');
    const [meta, setMeta] = useEntityProp('postType', 'vd_location', 'meta');

    // Will only render component for post type 'vd_location'
    if ('vd_location' !== postType) {
        return null;
    }

    return (
        <PluginDocumentSettingPanel title={__('Vd location settings', 'vdplug')} initialOpen="true">
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('Latitude', 'vdplug')}
                        value={meta.vd_location_latitude}
                        onChange={(newValue) => setMeta({ ...meta, vd_location_latitude: newValue })}
                    />
                </BaseControl>
            </PanelRow>
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('Longitude', 'vdplug')}
                        value={meta.vd_location_longitude}
                        onChange={(newValue) => setMeta({ ...setMeta, vd_location_longitude: newValue })}
                    />
                </BaseControl>
            </PanelRow>
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('Phone', 'vdplug')}
                        value={meta.vd_location_phone}
                        onChange={(newValue) => setMeta({ ...setMeta, vd_location_phone: newValue })}
                    />
                </BaseControl>
            </PanelRow>
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('E-Mail', 'vdplug')}
                        value={meta.vd_location_email}
                        onChange={(newValue) => setMeta({ ...setMeta, vd_location_email: newValue })}
                    />
                </BaseControl>
            </PanelRow>
        </PluginDocumentSettingPanel>
    )
}

registerPlugin('vd-location-settings', {
    render: VdLocationSidebar,
    icon: 'palmtree',
});

