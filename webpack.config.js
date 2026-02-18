const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
	...defaultConfig,
	entry: {
		'blocks/hero/index': './assets/js/blocks/hero/index.js',
		'blocks/pricing/index': './assets/js/blocks/pricing/index.js',
		'blocks/faq/index': './assets/js/blocks/faq/index.js',
		'admin/index': './assets/js/admin/index.js',
	},
};
