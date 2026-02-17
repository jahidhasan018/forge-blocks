<?php

declare(strict_types=1);

use Forge\Blocks\Contracts\ModuleInterface;
use Forge\Blocks\Services\ModuleManager;
use Forge\Blocks\Services\ModuleRegistry;
use PHPUnit\Framework\TestCase;

final class ModuleManagerTest extends TestCase
{
	public function testRegisterEnabledModulesCallsRegister(): void
	{
		$module = new class() implements ModuleInterface {
			public bool $registered = false;

			public function register(): void
			{
				$this->registered = true;
			}

			public function getSlug(): string
			{
				return 'fake-module';
			}

			public function getName(): string
			{
				return 'Fake Module';
			}

			public function getSettingsSchema(): array
			{
				return [];
			}
		};

		$registry = new ModuleRegistry();
		$registry->add($module);

		$manager = new ModuleManager($registry);
		$manager->registerEnabledModules();

		self::assertTrue($module->registered);
	}
}
