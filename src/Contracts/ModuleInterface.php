<?php

declare(strict_types=1);

namespace Forge\Blocks\Contracts;

interface ModuleInterface extends ServiceInterface
{
	public function getSlug(): string;

	public function getName(): string;

	/**
	 * @return array<string,mixed>
	 */
	public function getSettingsSchema(): array;
}
