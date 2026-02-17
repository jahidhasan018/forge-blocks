<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\FAQ;

use Forge\Blocks\Modules\AbstractModule;

class FaqModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'faq';
	}

	public function getName(): string
	{
		return 'FAQ';
	}

	public function registerBlock(): void
	{
		register_block_type(
			$this->paths->basePath('src/Modules/FAQ/block.json'),
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
		$items = $attributes['items'] ?? [
			[
				'question' => 'How fast can I launch?',
				'answer'   => 'Most teams launch in one day.',
			],
		];

		ob_start();
		?>
		<section class="lc-faq">
			<?php foreach ((array) $items as $item) : ?>
				<details>
					<summary><?php echo esc_html((string) ($item['question'] ?? '')); ?></summary>
					<p><?php echo esc_html((string) ($item['answer'] ?? '')); ?></p>
				</details>
			<?php endforeach; ?>
		</section>
		<?php

		return (string) ob_get_clean();
	}

	protected function enqueueFrontendAssets(): void
	{
		wp_enqueue_style('forge-faq', $this->paths->baseUrl('assets/css/faq.css'), [], '1.0.0');
	}
}
