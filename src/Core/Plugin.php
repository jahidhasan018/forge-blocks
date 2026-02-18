<?php

declare(strict_types=1);

namespace Forge\Blocks\Core;

use Forge\Blocks\Admin\AdminDashboard;
use Forge\Blocks\Modules\FAQ\FaqModule;
use Forge\Blocks\Modules\Hero\HeroModule;
use Forge\Blocks\Modules\Layout\LayoutModule;
use Forge\Blocks\Modules\Marketing\MarketingModule;
use Forge\Blocks\Modules\Pricing\PricingModule;
use Forge\Blocks\Modules\Testimonials\TestimonialsModule;
use Forge\Blocks\REST\ModuleController;
use Forge\Blocks\Services\GlobalStyleService;
use Forge\Blocks\Services\ModuleManager;
use Forge\Blocks\Services\ModuleRegistry;
use Forge\Blocks\Services\ModuleToggleService;
use Forge\Blocks\Support\PluginPaths;

class Plugin
{
	private Container $container;

	public function __construct(private readonly string $mainFile)
	{
		$this->container = new Container();
	}

	public function boot(): void
	{
		$this->registerServices();
		$this->registerModules();

		$this->container->get(GlobalStyleService::class)->register();
		$this->container->get(AdminDashboard::class)->register();
		$this->container->get(ModuleController::class)->register();
		$this->container->get(ModuleManager::class)->registerEnabledModules();
	}

	private function registerServices(): void
	{
		$this->container->singleton(PluginPaths::class, fn (): PluginPaths => new PluginPaths($this->mainFile));
		$this->container->singleton(ModuleToggleService::class, fn (): ModuleToggleService => new ModuleToggleService());
		$this->container->singleton(ModuleRegistry::class, fn (): ModuleRegistry => new ModuleRegistry());
		$this->container->singleton(
			ModuleManager::class,
			fn (Container $container): ModuleManager => new ModuleManager($container->get(ModuleRegistry::class))
		);
		$this->container->singleton(GlobalStyleService::class, fn (): GlobalStyleService => new GlobalStyleService());
		$this->container->singleton(
			AdminDashboard::class,
			fn (Container $container): AdminDashboard => new AdminDashboard($container->get(PluginPaths::class))
		);
		$this->container->singleton(
			ModuleController::class,
			fn (Container $container): ModuleController => new ModuleController(
				$container->get(ModuleManager::class),
				$container->get(ModuleToggleService::class)
			)
		);
	}

	private function registerModules(): void
	{
		$registry = $this->container->get(ModuleRegistry::class);
		$paths    = $this->container->get(PluginPaths::class);
		$toggle   = $this->container->get(ModuleToggleService::class);

		$registry->add(new HeroModule($paths, $toggle));
		$registry->add(new PricingModule($paths, $toggle));
		$registry->add(new FaqModule($paths, $toggle));
		$registry->add(new TestimonialsModule($paths, $toggle));
		$registry->add(new LayoutModule($paths, $toggle));
		$registry->add(new MarketingModule($paths, $toggle));
	}
}
