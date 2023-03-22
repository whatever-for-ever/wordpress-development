/**
 * WordPress dependencies.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';
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

	// If the useEffect method is not used, sometimes there is a warning message in the console:
	// 'Cannot update a component while rendering a different component warning'.
	// @link https://github.com/WordPress/gutenberg/issues/21049
	// @link https://stackoverflow.com/questions/62336340/cannot-update-a-component-while-rendering-a-different-component-warning/63424831#63424831
	// TODO: find solution without useEffect or find documentation about requiring useEffect in this situation.
	useEffect( () => {
		setAttributes( { accordionID: clientId } );
	}, [] );

	const ALLOWED_BLOCKS = [ 'an-whatever/accordion-item' ];

	return (
		<section { ...blockProps }>
			<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } />
		</section>
	);
}
