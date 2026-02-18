import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import metadata from '../../../../src/Modules/Pricing/block.json';

registerBlockType(metadata.name, {
	...metadata,
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		return (
			<>
				<InspectorControls>
					<PanelBody title="Plan Settings" initialOpen>
						<TextControl label="Price" value={attributes.price} onChange={(price) => setAttributes({ price })} />
						<TextareaControl
							label="Features (one per line)"
							value={attributes.features.join('\n')}
							onChange={(value) => setAttributes({ features: value.split('\n').filter(Boolean) })}
						/>
					</PanelBody>
				</InspectorControls>
				<section {...blockProps}>
					<RichText tagName="h3" value={attributes.planName} onChange={(planName) => setAttributes({ planName })} />
					<p>{attributes.price}</p>
				</section>
			</>
		);
	},
	save: () => null,
});
