import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextareaControl } from '@wordpress/components';
import metadata from '../../../../src/Modules/FAQ/block.json';

registerBlockType(metadata.name, {
	...metadata,
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const rawItems = attributes.items.map((item) => `${item.question}|${item.answer}`).join('\n');
		return (
			<>
				<InspectorControls>
					<PanelBody title="FAQ Items" initialOpen>
						<TextareaControl
							label="Question|Answer per line"
							value={rawItems}
							onChange={(value) => {
								const items = value
									.split('\n')
									.filter(Boolean)
									.map((line) => {
										const [question, answer] = line.split('|');
										return { question, answer };
									});
								setAttributes({ items });
							}}
						/>
					</PanelBody>
				</InspectorControls>
				<section {...blockProps}>
					{attributes.items.map((item, index) => (
						<div key={index}>
							<RichText tagName="h4" value={item.question} onChange={() => {}} />
							<p>{item.answer}</p>
						</div>
					))}
				</section>
			</>
		);
	},
	save: () => null,
});
