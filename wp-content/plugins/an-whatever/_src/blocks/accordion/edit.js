/**
 * WordPress dependencies.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( props ) {
	const blockProps = useBlockProps();

	const { attributes, setAttributes, clientId, className } = props;

	const { accordionID } = attributes;

	setAttributes( { accordionID: clientId } );

	const ALLOWED_BLOCKS = [ 'an-whatever/accordion-item' ];

	return (
		<section { ...blockProps }>
			<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } />
		</section>
	);
}
