<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\Layout;

use Forge\Blocks\Modules\AbstractModule;

class LayoutModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'layout';
	}

	public function getName(): string
	{
		return 'Layout';
	}

	public function registerBlock(): void
	{
	}
}
