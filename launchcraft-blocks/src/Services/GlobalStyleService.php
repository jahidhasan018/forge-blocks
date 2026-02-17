<?php

declare(strict_types=1);

namespace Forge\Blocks\Services;

class GlobalStyleService
{
	private const OPTION_KEY = 'forge_blocks_global_styles';

	public function register(): void
	{
		add_action('wp_head', [$this, 'printCssVariables']);
	}

	/**
	 * @return array<string,string>
	 */
	public function getStyles(): array
	{
		$defaults = [
			'primary-color'   => '#5b5bd6',
			'secondary-color' => '#121212',
			'body-font'       => 'Inter, sans-serif',
			'heading-font'    => 'Poppins, sans-serif',
		];

		$styles = get_option(self::OPTION_KEY, []);

		if (! is_array($styles)) {
			return $defaults;
		}

		return array_merge($defaults, array_map('sanitize_text_field', $styles));
	}

	public function printCssVariables(): void
	{
		$styles = $this->getStyles();

		echo '<style id="forge-global-styles">:root{';
		foreach ($styles as $token => $value) {
			echo esc_html(sprintf('--lc-%s:%s;', sanitize_key($token), $value));
		}
		echo '}</style>';
	}
}
