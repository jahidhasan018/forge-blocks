<?php

declare(strict_types=1);

namespace Forge\Blocks\Admin;

use Forge\Blocks\Support\PluginPaths;

class AdminDashboard
{
	public function __construct(private readonly PluginPaths $paths)
	{
	}

	public function register(): void
	{
		add_action('admin_menu', [$this, 'addMenuPage']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	public function addMenuPage(): void
	{
		add_menu_page(
			esc_html__('Forge Blocks', 'forge-blocks'),
			esc_html__('Forge Blocks', 'forge-blocks'),
			'manage_options',
			'forge-blocks',
			[$this, 'renderPage'],
			'dashicons-screenoptions'
		);
	}

	public function renderPage(): void
	{
		echo '<div id="forge-admin-app"></div>';
	}

	public function enqueueAssets(string $hook): void
	{
		if ('toplevel_page_forge-blocks' !== $hook) {
			return;
		}

		$asset_file = $this->paths->basePath('build/admin/index.asset.php');
		$assets     = file_exists($asset_file) ? include $asset_file : ['dependencies' => [], 'version' => '1.0.0'];

		wp_enqueue_script(
			'forge-admin',
			$this->paths->baseUrl('build/admin/index.js'),
			$assets['dependencies'],
			$assets['version'],
			true
		);

		wp_enqueue_style(
			'forge-admin',
			$this->paths->baseUrl('build/admin/index.css'),
			[],
			$assets['version']
		);

		wp_localize_script(
			'forge-admin',
			'ForgeAdmin',
			[
				'restUrl' => esc_url_raw(rest_url('forge/v1/modules')),
				'nonce'   => wp_create_nonce('wp_rest'),
			]
		);
	}
}
