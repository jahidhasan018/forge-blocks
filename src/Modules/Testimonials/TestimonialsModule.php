<?php

declare(strict_types=1);

namespace Forge\Blocks\Modules\Testimonials;

use Forge\Blocks\Modules\AbstractModule;

class TestimonialsModule extends AbstractModule
{
	public function getSlug(): string
	{
		return 'testimonials';
	}

	public function getName(): string
	{
		return 'Testimonials';
	}

	public function registerBlock(): void
	{
	}
}
