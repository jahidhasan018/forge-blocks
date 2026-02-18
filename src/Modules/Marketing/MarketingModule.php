<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\Marketing;

use Forge\Blocks\Modules\AbstractModule;

class MarketingModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'marketing';
	}

	public function getName(): string
	{
		return 'Marketing';
	}

	public function registerBlock(): void
	{
	}
}
