<?php

declare(strict_types=1);

namespace Forge\Blocks\Support;

class PluginPaths
{
	public function __construct(private readonly string $mainFile)
	{
	}

	public function basePath(string $path = ''): string
	{
		return trailingslashit(plugin_dir_path($this->mainFile)) . ltrim($path, '/');
	}

	public function baseUrl(string $path = ''): string
	{
		return trailingslashit(plugin_dir_url($this->mainFile)) . ltrim($path, '/');
	}
}
