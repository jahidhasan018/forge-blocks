<?php

declare(strict_types=1);

namespace Forge\Blocks\REST;

use Forge\Blocks\Services\ModuleManager;
use Forge\Blocks\Services\ModuleToggleService;
use WP_REST_Request;
use WP_REST_Response;

class ModuleController
{
	public function __construct(
		private readonly ModuleManager $moduleManager,
		private readonly ModuleToggleService $toggleService
	) {
	}

	public function register(): void
	{
		add_action('rest_api_init', [$this, 'registerRoutes']);
	}

	public function registerRoutes(): void
	{
		register_rest_route(
			'forge/v1',
			'/modules',
			[
				[
					'methods'             => 'GET',
					'callback'            => [$this, 'getModules'],
					'permission_callback' => [$this, 'canManageModules'],
				],
				[
					'methods'             => 'POST',
					'callback'            => [$this, 'saveModules'],
					'permission_callback' => [$this, 'canManageModules'],
				],
			]
		);
	}

	public function canManageModules(): bool
	{
		return current_user_can('manage_options');
	}

	public function getModules(): WP_REST_Response
	{
		return new WP_REST_Response($this->moduleManager->getModuleSettings());
	}

	public function saveModules(WP_REST_Request $request): WP_REST_Response
	{
		$payload = $request->get_json_params();
		$states  = is_array($payload['states'] ?? null) ? $payload['states'] : [];

		$this->toggleService->saveStates($states);

		return new WP_REST_Response(['success' => true]);
	}
}
