<?php

declare(strict_types=1);

namespace Forge\Blocks\Core;

use RuntimeException;

class Container
{
	/**
	 * @var array<string,callable(self):mixed>
	 */
	private array $bindings = [];

	/**
	 * @var array<string,mixed>
	 */
	private array $instances = [];

	public function set(string $id, callable $resolver): void
	{
		$this->bindings[$id] = $resolver;
	}

	public function singleton(string $id, callable $resolver): void
	{
		$this->bindings[$id] = static function (self $container) use ($id, $resolver) {
			if (! array_key_exists($id, $container->instances)) {
				$container->instances[$id] = $resolver($container);
			}

			return $container->instances[$id];
		};
	}

	public function get(string $id): mixed
	{
		if (! array_key_exists($id, $this->bindings)) {
			throw new RuntimeException(sprintf('Service "%s" is not registered.', $id));
		}

		return ($this->bindings[$id])($this);
	}
}
