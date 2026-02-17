<?php

declare(strict_types=1);

namespace Forge\Blocks\Services;

use Forge\Blocks\Contracts\ModuleInterface;

class ModuleRegistry
{
	/**
	 * @var array<string,ModuleInterface>
	 */
	private array $modules = [];

	public function add(ModuleInterface $module): void
	{
		$this->modules[$module->getSlug()] = $module;
	}

	/**
	 * @return array<string,ModuleInterface>
	 */
	public function all(): array
	{
		return $this->modules;
	}

	public function get(string $slug): ?ModuleInterface
	{
		return $this->modules[$slug] ?? null;
	}
}
