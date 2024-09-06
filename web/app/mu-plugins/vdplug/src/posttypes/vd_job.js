import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { BaseControl, PanelRow, TextControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';

const VdJobSidebar = () => {
    const [postType,] = useEntityProp('postType', 'vd_job', 'type');
    const [meta, setMeta] = useEntityProp('postType', 'vd_job', 'meta');

    // Will only render component for post type 'vd_job'
    if ('vd_job' !== postType) {
        return null;
    }

    return (
        <PluginDocumentSettingPanel title={__('Vd Job settings', 'vdplug')} initialOpen="true">
            <PanelRow>
                <BaseControl>
                    <TextControl
                        label={__('Personio Id', 'vdplug')}
                        value={meta.vd_job_personio_id}
                        onChange={(newValue) => setMeta({ ...setMeta, vd_job_personio_id: newValue })}
                    />
                </BaseControl>
            </PanelRow>
        </PluginDocumentSettingPanel>
    )
}

registerPlugin('vd-job-settings', {
    render: VdJobSidebar,
    icon: 'palmtree',
});
