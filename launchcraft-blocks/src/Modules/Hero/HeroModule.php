<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\Hero;

use Forge\Blocks\Modules\AbstractModule;

class HeroModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'hero';
	}

	public function getName(): string
	{
		return 'Hero';
	}

	public function registerBlock(): void
	{
		register_block_type(
			$this->paths->basePath('src/Modules/Hero/block.json'),
			[
				'render_callback' => [$this, 'render'],
			]
		);
	}

	/**
	 * @param array<string,mixed> $attributes Block attributes.
	 */
	public function render(array $attributes): string
	{
		$title    = esc_html($attributes['title'] ?? 'Build Better Landing Pages');
		$subtitle = esc_html($attributes['subtitle'] ?? 'Compose high-converting sections with Forge blocks.');
		$cta_text = esc_html($attributes['ctaText'] ?? 'Get Started');
		$cta_url  = esc_url($attributes['ctaUrl'] ?? '#');
		$align    = esc_attr($attributes['textAlign'] ?? 'center');

		ob_start();
		?>
		<section class="lc-hero" style="text-align:<?php echo $align; ?>;">
			<h1 class="lc-hero__title"><?php echo $title; ?></h1>
			<p class="lc-hero__subtitle"><?php echo $subtitle; ?></p>
			<a class="lc-hero__button" href="<?php echo $cta_url; ?>"><?php echo $cta_text; ?></a>
		</section>
		<?php

		return (string) ob_get_clean();
	}

	protected function enqueueFrontendAssets(): void
	{
		wp_enqueue_style('forge-hero', $this->paths->baseUrl('assets/css/hero.css'), [], '1.0.0');
	}
}
