import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useEntityProp, store as coreStore } from '@wordpress/core-data';
import { dateI18n } from '@wordpress/date';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { ToggleControl, BaseControl, PanelBody, PanelRow } from '@wordpress/components';

function Edit({attributes, setAttributes, isSelected}) {
    // const postId = context.postId;
    const { showAuthor } = attributes;
    let categoriesListFiltered = [];
    let postCategoryStr = '';
    const blockProps = useBlockProps({ className: 'bloginfo' });
    const [ date ] = useEntityProp('postType', 'post', 'date');

    const {
        postAuthor,
        categoriesIds,
        categoriesList
    } = useSelect(
        (select) => {
            const { getEntityRecords } = select(coreStore);
            const postAuthorId = select('core/editor').getCurrentPostAttribute('author');

            return {
                postAuthor: select('core').getUser(postAuthorId),
                categoriesIds: select('core/editor').getCurrentPostAttribute('categories'),
                categoriesList: getEntityRecords('taxonomy', 'category', {
                    _fields: 'id,name',
                    orderby: 'name',
                    order: 'asc',
                    per_page: -1
                })
            };
        },
        []
    );

    if (categoriesList && categoriesIds) {
        categoriesListFiltered = categoriesList.filter(item => categoriesIds.includes(item.id));
        postCategoryStr = categoriesListFiltered.map(item => `${item.name}`).join(', ')
    }

    const inspectorControls = (
        <InspectorControls group="styles">
            <PanelBody title={__('Permission', 'vdplug')}>
                <PanelRow>
                    <BaseControl>
                        <ToggleControl
                            label="Show Author"
                            checked={showAuthor}
                            onChange={(newValue) =>
                                setAttributes({
                                    showAuthor: !!newValue
                                })
                            }
                        />
                    </BaseControl>
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    )

    return (
        <>
            {isSelected && inspectorControls}

            <div {...blockProps}>
                {showAuthor && <> {__('Written by', 'vdplug')} <span className="bloginfo__author">{postAuthor?.username}</span> / </>}
                <span className="bloginfo__date">{dateI18n('d.m.Y', date)}</span> / <span className="bloginfo__category">{postCategoryStr}</span>
            </div>
        </>
    );
}

export default Edit;
