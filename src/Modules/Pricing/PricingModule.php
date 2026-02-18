<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\Pricing;

use Forge\Blocks\Modules\AbstractModule;

class PricingModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'pricing';
	}

	public function getName(): string
	{
		return 'Pricing Table';
	}

	public function registerBlock(): void
	{
		register_block_type(
			$this->paths->basePath('src/Modules/Pricing/block.json'),
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
		$plan_name  = esc_html($attributes['planName'] ?? 'Starter');
		$price      = esc_html($attributes['price'] ?? '$29');
		$period     = esc_html($attributes['period'] ?? '/month');
		$button     = esc_html($attributes['buttonText'] ?? 'Choose Plan');
		$features   = $attributes['features'] ?? ['Feature one', 'Feature two'];

		ob_start();
		?>
		<section class="lc-pricing">
			<h3><?php echo $plan_name; ?></h3>
			<p class="lc-pricing__price"><?php echo $price; ?><span><?php echo $period; ?></span></p>
			<ul>
				<?php foreach ((array) $features as $feature) : ?>
					<li><?php echo esc_html((string) $feature); ?></li>
				<?php endforeach; ?>
			</ul>
			<button type="button"><?php echo $button; ?></button>
		</section>
		<?php

		return (string) ob_get_clean();
	}

	protected function enqueueFrontendAssets(): void
	{
		wp_enqueue_style('forge-pricing', $this->paths->baseUrl('assets/css/pricing.css'), [], '1.0.0');
	}
}
