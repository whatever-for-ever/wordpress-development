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
import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import {
	PanelBody,
	Button,
	SelectControl,
	SearchControl,
} from '@wordpress/components';
import { createBlock } from '@wordpress/blocks';
import { useDispatch, useSelect } from '@wordpress/data';
import { store as coreStore, useEntityRecords } from '@wordpress/core-data';
import { useEffect, useState } from '@wordpress/element';
import { useDebounce } from '@wordpress/compose';

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

	const [ postType, setPostType ] = useState();
	const [ selectedPost, setSelectedPost ] = useState( '' );
	const [ searchTerm, setSearchTerm ] = useState( '' );
	const { insertBlocks } = useDispatch( blockEditorStore );
	const { getBlocksByClientId } = useSelect( ( select ) =>
		select( blockEditorStore )
	);

	const debouncedSetSearchTerm = useDebounce( ( term ) => {
		setSearchTerm( term );
	}, 500 );

	// Get the available post types.
	const postTypes = useSelect( ( select ) =>
		select( coreStore ) // 'core'.
			.getPostTypes()
			?.filter( ( { viewable } ) => viewable )
			.map( ( { slug } ) => {
				return { label: slug, value: slug };
			} )
	);

	// Query the posts.
	const { records } = useEntityRecords( 'postType', postType, {
		per_page: 100,
		search: searchTerm,
	} );

	const concat = ( ...arrays ) =>
		[].concat( ...arrays.filter( Array.isArray ) );

	/*
	 * If we want to create an accordion from a list of selected entries
	 * and there are several PostPicker blocks on the page, we will need
	 * a unique ID for each of them. This is why the block ID is saved.
	 * Using the block ID and the ID of each record, it will be possible
	 * to create unique IDs.
	 *
	 * If the useEffect method is not used, sometimes there is a warning message in the console:
	 * 'Cannot update a component while rendering a different component warning'.
	 * @link https://github.com/WordPress/gutenberg/issues/21049
	 * @link https://stackoverflow.com/questions/62336340/cannot-update-a-component-while-rendering-a-different-component-warning/63424831#63424831
	 *
	 * // TODO: find solution how to proper set attribute in this situation.
	 */
	useEffect( () => {
		setAttributes( { postListId: clientId } );
	}, [] );

	const ALLOWED_BLOCKS = [ 'an-whatever/post-picker-placeholder' ];

	return (
		<div { ...blockProps }>
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				renderAppender={ false }
			/>
			<InspectorControls>
				<PanelBody title={ __( 'Post Picker', 'an-whatever' ) }>
					{ postTypes ? (
						<>
							<SelectControl
								placeholder={ __( 'TEST', 'an-whatever' ) }
								label={ __( 'Post Type', 'an-whatever' ) }
								value={ postType }
								options={ [
									{
										disabled: false,
										label: __( 'Choose...', 'an-whatever' ),
										value: '',
									},
									...postTypes,
								] }
								onChange={ ( newPostType ) =>
									setPostType( newPostType )
								}
								__nextHasNoMarginBottom
							/>
							<SearchControl
								help={ __(
									'Enter search terms to filter list',
									'an-whatever'
								) }
								label={ __( 'Search', 'an-whatever' ) }
								onChange={ ( term ) =>
									debouncedSetSearchTerm( term )
								}
							/>
							<SelectControl
								value={ selectedPost }
								options={ concat(
									[
										{
											disabled: false,
											label: __(
												'Choose...',
												'an-whatever'
											),
											value: '',
										},
									],
									records?.map(
										( { title: { rendered }, id } ) => {
											return {
												label: rendered,
												value: id,
											};
										}
									)
								) }
								onChange={ ( newSelectedPost ) =>
									setSelectedPost( newSelectedPost )
								}
							/>
						</>
					) : (
						<p>{ __( 'Loading...', 'an-whatever' ) }</p>
					) }

					<Button
						disabled={ ! selectedPost ? true : false }
						variant="primary"
						onClick={ () => {
							const newPost = createBlock(
								'an-whatever/post-picker-placeholder',
								{ id: Number( selectedPost ), postType }
							);

							const [ { innerBlocks } ] =
								getBlocksByClientId( clientId );
							insertBlocks(
								newPost,
								innerBlocks.length,
								clientId
							);
						} }
					>
						{ __( 'Insert Post', 'an-whatever' ) }
					</Button>
				</PanelBody>
			</InspectorControls>
		</div>
	);
}
