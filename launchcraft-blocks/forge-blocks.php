<?php
/**
 * Plugin Name: Forge Blocks
 * Description: Modular Gutenberg landing page builder with dynamic rendering and module toggles.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 8.0
 * Author: Forge
 * License: GPL-2.0-or-later
 * Text Domain: forge-blocks
 *
 * @package Forge\Blocks
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
}

add_action(
	'plugins_loaded',
	static function (): void {
		$plugin = new Forge\Blocks\Core\Plugin(__FILE__);
		$plugin->boot();
	}
);
