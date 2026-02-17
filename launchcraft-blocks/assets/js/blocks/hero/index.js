import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	URLInputButton,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	__experimentalSpacer as Spacer,
} from '@wordpress/components';
import metadata from '../../../../src/Modules/Hero/block.json';

const ALIGN_OPTIONS = [
	{ label: 'Left', value: 'left' },
	{ label: 'Center', value: 'center' },
	{ label: 'Right', value: 'right' },
];

const TOKEN_OPTIONS = [
	{ label: 'Primary', value: 'primary-color' },
	{ label: 'Secondary', value: 'secondary-color' },
];

registerBlockType(metadata.name, {
	...metadata,
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps({
			style: { textAlign: attributes.textAlign, color: `var(--lc-${attributes.colorToken})` },
		});

		return (
			<>
				<InspectorControls>
					<PanelBody title="Content Settings" initialOpen>
						<TextControl
							label="CTA Text"
							value={attributes.ctaText}
							onChange={(ctaText) => setAttributes({ ctaText })}
						/>
						<URLInputButton
							url={attributes.ctaUrl}
							onChange={(ctaUrl) => setAttributes({ ctaUrl })}
						/>
					</PanelBody>
					<PanelBody title="Responsive Alignment" initialOpen={false}>
						<SelectControl
							label="Desktop"
							value={attributes.textAlign}
							options={ALIGN_OPTIONS}
							onChange={(textAlign) => setAttributes({ textAlign })}
						/>
						<SelectControl
							label="Tablet"
							value={attributes.tabletTextAlign}
							options={ALIGN_OPTIONS}
							onChange={(tabletTextAlign) => setAttributes({ tabletTextAlign })}
						/>
						<SelectControl
							label="Mobile"
							value={attributes.mobileTextAlign}
							options={ALIGN_OPTIONS}
							onChange={(mobileTextAlign) => setAttributes({ mobileTextAlign })}
						/>
						<SelectControl
							label="Color Token"
							value={attributes.colorToken}
							options={TOKEN_OPTIONS}
							onChange={(colorToken) => setAttributes({ colorToken })}
						/>
					</PanelBody>
				</InspectorControls>
				<section {...blockProps}>
					<RichText
						tagName="h1"
						value={attributes.title}
						placeholder="Hero Title"
						onChange={(title) => setAttributes({ title })}
					/>
					<RichText
						tagName="p"
						value={attributes.subtitle}
						placeholder="Hero subtitle"
						onChange={(subtitle) => setAttributes({ subtitle })}
					/>
					<Spacer marginTop={16} marginBottom={16}>
						<span className="lc-hero__button">{attributes.ctaText}</span>
					</Spacer>
				</section>
			</>
		);
	},
	save: () => null,
});
