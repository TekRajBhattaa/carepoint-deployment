import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { BaseControl, TextControl, PanelRow } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';

const VdPostSidebar = () => {
    const [postType,] = useEntityProp('postType', 'post', 'type');
    const [meta, setMeta] = useEntityProp('postType', 'post', 'meta');

    // Will only render component for post type 'post'
    if ('post' !== postType) {
        return null;
    }

    return (
        <PluginDocumentSettingPanel title={__('Video settings', 'vdplug')} initialOpen="true">
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('Video url', 'vdplug')}
                        type="url"
                        placeholder="https://www.youtube.com/watch?v=f8PFeiLvr18"
                        value={meta.vd_video_url}
                        onChange={(newValue) => setMeta({ ...meta, vd_video_url: newValue })}
                    />
                </BaseControl>
            </PanelRow>
        </PluginDocumentSettingPanel>
    )
}

registerPlugin('vd-post-settings', {
    render: VdPostSidebar,
    icon: 'palmtree',
});
