/**
 * WordPress dependencies.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';
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

	const { attributes, setAttributes, isSelected, clientId } = props;

	const { title, accordionItemID } = attributes;

	setAttributes( { accordionItemID: clientId } );

	const ALLOWED_BLOCKS = [
		'core/heading',
		'core/paragraph',
		'core/buttons',
		'core/button',
		'core/audio',
		'core/cover',
		'core/image',
		'core/gallery',
		'core/file',
		'core/embed',
		'core/media-text',
		'core/list',
		'core/list-item',
		'core/spacer',
		'core/separator',
		'core/shortcode',
		'core/quote',
		'core/preformatted',
		'core/code',
		'core/html',
		'core/group',
	];

	return (
		<div { ...blockProps }>
			{ ( isSelected || title ) && (
				<h3>
					<button
						type="button"
						aria-expanded="true"
						class="accordion-trigger"
						aria-controls={ `acc-item-content-${ accordionItemID }` }
						id={ `acc-item-btn-${ accordionItemID }` }
					>
						<RichText
							tagName="span"
							value={ title }
							allowedFormats={ [] }
							placeholder={ __(
								'Accordion item title',
								'an-whatever'
							) }
							onChange={ ( newTitle ) =>
								setAttributes( { title: newTitle } )
							}
						/>
					</button>
				</h3>
			) }
			<div
				id={ `acc-item-content-${ accordionItemID }` }
				role="region"
				aria-labelledby={ `acc-item-btn-${ accordionItemID }` }
				class="accordion-panel"
			>
				<InnerBlocks
					templateLock={ false }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</div>
		</div>
	);
}
