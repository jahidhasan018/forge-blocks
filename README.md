# Forge Blocks

## 1) Architecture Design
- Modular architecture with DI container (`src/Core/Container.php`).
- Module system (`ModuleInterface`, `AbstractModule`, `ModuleRegistry`, `ModuleManager`, `ModuleToggleService`).
- Dynamic block rendering in PHP per module.
- REST API for module toggles.
- React admin dashboard for module management.
- Global style tokens injected as CSS variables.

## 2) Composer
Uses PSR-4 autoloading and PHP 8+.

## 3) Bootstrap
Main plugin file initializes `Plugin` on `plugins_loaded`.

## 4) Module System
Each module extends `AbstractModule`; block registration only occurs when enabled.

## 5) Fully Implemented Block Example
Hero block includes:
- `block.json`
- React editor with InspectorControls and responsive controls.
- Dynamic render callback in PHP.
- Conditional frontend asset loading.

## 6) Admin Dashboard Structure
React app with:
- Sidebar navigation.
- Module toggle controls.
- Save via REST API.
