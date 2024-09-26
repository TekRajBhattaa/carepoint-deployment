import {
    InnerBlocks,
    useBlockProps,
    useInnerBlocksProps,
    store as blockEditorStore,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { sprintf, __ } from '@wordpress/i18n';


const TEMPLATE = [
    ['core/columns', {}, [
        ['core/column', {}, [
            ['core/heading', { level: 1, content: 'Title' }],
            // ['core/list'],
            ['verdure/repeater-list-with-icon']
        
           
        ]],
        ['core/column', {}, [
            ['core/image', { id: 15, sizeSlug: 'large', linkDestination: 'none' }]
        ]]
    ]]
    
];
export default function Edit({ attributes, clientId }) {
    const { columnsIds, hasChildBlocks } = useSelect(
        (select) => {
            const { getBlockOrder, getBlockRootClientId } =
				select(blockEditorStore);
            const rootId = getBlockRootClientId(clientId);
            return {
                hasChildBlocks: getBlockOrder(clientId).length > 0,
                rootClientId: rootId,
                columnsIds: getBlockOrder(rootId),
            };
        },
        [clientId]
    );

    const blockProps = useBlockProps({
        className: 'swiper-item swiper-slide',
    });
    const columnsCount = columnsIds.length;
    const currentColumnPosition = columnsIds.indexOf(clientId) + 1;
    const label = sprintf(
        /* translators: 1: Block label (i.e. "Block: Column"), 2: Position of the selected block, 3: Total number of sibling blocks of the same type */
        __('%1$s (%2$d of %3$d)'),
        blockProps['aria-label'],
        currentColumnPosition,
        columnsCount
    );
    const innerBlocksProps = useInnerBlocksProps(
        { ...blockProps, 'aria-label': label },
        {        template: TEMPLATE,
            templateLock: false,
            allowedBlocks: attributes.allowedBlocks,
            renderAppender: hasChildBlocks
                ? undefined
                : InnerBlocks.ButtonBlockAppender,
        }
    );

    return <div {...innerBlocksProps}></div>;
}
