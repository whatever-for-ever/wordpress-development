/**
 * WordPress dependencies
 *
 * Retrieves the translation of text.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 *
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 *
 * Resolves the specified entity records.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-core-data/#useentityrecords
 *
 * A FormTokenField is a field similar to the tags and categories fields
 * in the interim editor chrome, or the “to” field in Mail on OS X.
 * Tokens can be entered by typing them or selecting them from a list of suggested tokens.
 * * @see https://developer.wordpress.org/block-editor/reference-guides/components/form-token-field/
 *
 * Renders a placeholder. Normally used by blocks to render their empty state.
 * * @see https://github.com/WordPress/gutenberg/tree/trunk/packages/components/src/placeholder
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useEntityRecords } from '@wordpress/core-data';
import { useEffect } from '@wordpress/element';
import { FormTokenField, Placeholder } from '@wordpress/components';

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
export default function Edit( {
	attributes: { postList },
	setAttributes,
	isSelected,
	clientId,
} ) {
	const blockProps = useBlockProps(); // because it is not recommended to use it when you have an if block with return.

	const postsRequest = useEntityRecords( 'postType', 'an_whatever', {
		per_page: -1, // TODO: How to do it efficiently if there are 10000 entries? The suggestions should include all entries. By default, only 10 entries are displayed.
	} );

	// If the useEffect method is not used, sometimes there is a warning message in the console:
	// 'Cannot update a component while rendering a different component warning'.
	// @link https://github.com/WordPress/gutenberg/issues/21049
	// @link https://stackoverflow.com/questions/62336340/cannot-update-a-component-while-rendering-a-different-component-warning/63424831#63424831
	//TODO: find solution how to proper set attribute in this situation.
	useEffect( () => {
		setAttributes( { postListId: clientId } );
	}, [] );

	/*
	 * If we want to create an accordion from a list of selected entries
	 * and there are several PostPicker blocks on the page, we will need
	 * a unique ID for each of them. This is why the block ID is saved.
	 * Using the block ID and the ID of each record, it will be possible
	 * to create unique IDs.
	 */

	if (
		postsRequest.isResolving ||
		( ! postsRequest.hasResolved && 'IDLE' === postsRequest.status )
	) {
		return (
			<div { ...blockProps }>{ __( 'Loading...', 'an-whatever' ) }</div>
		);
	}

	return (
		<div { ...blockProps }>
			{ isSelected ? (
				<Placeholder label={ __( 'Posts Picker', 'an-whatever' ) }>
					<FormTokenField
						label={ __( 'Posts to display', 'an-whatever' ) }
						__experimentalShowHowTo={ false }
						maxSuggestions={ 100 } // we may not need this.
						value={ postsRequest?.records
							?.filter( ( item ) => {
								return postList?.includes( item.id );
							} )
							.map( ( item ) => {
								return (
									item.title.rendered + ' | ID: ' + item.id // We add the ID string because the block list of proposals cannot have identical names.
								);
							} ) }
						suggestions={ postsRequest?.records?.map( ( post ) => {
							return post.title.rendered + ' | ID: ' + post.id; // We add the ID string because the block list of proposals cannot have identical names.
						} ) }
						onChange={ ( newList ) => {
							setAttributes( {
								postList: postsRequest?.records
									?.filter( ( item ) => {
										return newList.includes(
											item.title.rendered +
												' | ID: ' +
												item.id // We add the ID string because the block list of proposals cannot have identical names.
										);
									} )
									.map( ( item ) => {
										return item.id;
									} ),
							} );
						} }
					/>
				</Placeholder>
			) : (
				<>
					<section { ...blockProps }>
						<div className="accordion-item">
							{ postsRequest?.records
								?.filter( ( item ) => {
									return postList?.includes( item.id );
								} )
								.map( ( item ) => {
									return (
										<li key={ item.id }>
											{ item.title.rendered }
										</li>
									);
								} ) }
						</div>
					</section>
				</>
			) }
		</div>
	);
}
