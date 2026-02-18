<?php

declare(strict_types=1);

namespace Forge\Blocks\Services;

class ModuleManager
{
	public function __construct(private readonly ModuleRegistry $registry)
	{
	}

	public function registerEnabledModules(): void
	{
		foreach ($this->registry->all() as $module) {
			$module->register();
		}
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function getModuleSettings(): array
	{
		return array_values(
			array_map(
			static fn ($module): array => $module->getSettingsSchema(),
			$this->registry->all()
		)
		);
	}
}
