<?php

declare(strict_types=1);

namespace Forge\Blocks\Services;

class ModuleToggleService
{
	private const OPTION_KEY = 'forge_blocks_modules';

	public function isEnabled(string $slug): bool
	{
		$modules = $this->getStates();

		return (bool) ($modules[$slug] ?? true);
	}

	/**
	 * @return array<string,bool>
	 */
	public function getStates(): array
	{
		$states = get_option(self::OPTION_KEY, []);

		if (! is_array($states)) {
			return [];
		}

		return array_map(static fn ($value): bool => (bool) $value, $states);
	}

	/**
	 * @param array<string,bool> $states States keyed by module slug.
	 */
	public function saveStates(array $states): void
	{
		$sanitized = [];

		foreach ($states as $slug => $enabled) {
			$sanitized[sanitize_key($slug)] = (bool) $enabled;
		}

		update_option(self::OPTION_KEY, $sanitized, false);
	}
}
