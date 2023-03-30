/**
 * WordPress dependencies
 *
 * Retrieves the translation of text.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 *
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useEntityRecord } from '@wordpress/core-data';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 *
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 * * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss'; // gets applied to the editor.

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( props ) {
	const blockProps = useBlockProps(); // because it is not recommended to use it when you have an if block with return.

	const { attributes, setAttributes, clientId } = props;

	const { id = 0, postType = 'post', placeholderId } = attributes;

	const { record, isResolving, hasResolved, status } = useEntityRecord(
		'postType',
		postType,
		id
	);

	// If the useEffect method is not used, sometimes there is a warning message in the console:
	// 'Cannot update a component while rendering a different component warning'.
	// @link https://github.com/WordPress/gutenberg/issues/21049
	// @link https://stackoverflow.com/questions/62336340/cannot-update-a-component-while-rendering-a-different-component-warning/63424831#63424831
	//TODO: find solution how to proper set attribute in this situation.
	useEffect( () => {
		setAttributes( { placeholderId: clientId } );
	}, [] );

	if ( isResolving || ( ! hasResolved && 'IDLE' === status ) ) {
		<div { ...blockProps }>
			return( __( 'Loading...', 'an-whatever' ) );
		</div>;
	}

	return <div { ...blockProps }>{ record?.title?.rendered }</div>;
}
