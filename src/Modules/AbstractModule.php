<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules;

use Forge\Blocks\Contracts\ModuleInterface;
use Forge\Blocks\Services\ModuleToggleService;
use Forge\Blocks\Support\PluginPaths;

abstract class AbstractModule implements ModuleInterface
{
	public function __construct(
		protected readonly PluginPaths $paths,
		protected readonly ModuleToggleService $toggleService
	) {
	}

	public function register(): void
	{
		if (! $this->toggleService->isEnabled($this->getSlug())) {
			return;
		}

		add_action('init', [$this, 'registerBlock']);
		add_action('wp_enqueue_scripts', [$this, 'conditionallyEnqueueAssets']);
	}

	abstract public function registerBlock(): void;

	public function conditionallyEnqueueAssets(): void
	{
		if (! is_singular()) {
			return;
		}

		global $post;

		if (! $post instanceof \WP_Post) {
			return;
		}

		if (! has_block('forge/' . $this->getSlug(), $post)) {
			return;
		}

		$this->enqueueFrontendAssets();
	}

	protected function enqueueFrontendAssets(): void
	{
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getSettingsSchema(): array
	{
		return [
			'slug'    => $this->getSlug(),
			'name'    => $this->getName(),
			'enabled' => $this->toggleService->isEnabled($this->getSlug()),
		];
	}
}
