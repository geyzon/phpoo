# PHP OOP Project - Copilot Instructions

## Architecture Overview

This is a **PHP OOP study project** using PSR-4 autoloading, Twig templating, and an MVC-inspired routing system.

### Core Architecture
- **Routing**: URL-based controller resolution via `Uri` class parsing `REQUEST_URI`
- **Controllers**: Dynamically loaded based on URI segments with namespace resolution
- **Structure**: 
  - Root namespace: `App\\` mapped to `src/`
  - Controllers in `src/Controllers/` with sub-folders: `Site/`, `Admin/`, `Erro/`
  - Models, Repositories, Views, and helper functions in their respective folders

### Request Flow
1. `public/index.php` (router) → parses static assets vs dynamic requests
2. `bootstrap/bootstrap.php` → instantiates `Controller` class
3. `Controller::controller()` → resolves URI to controller class name using nested folder detection
4. Default route: `/` → `HomeController::index()` at `src/Controllers/`
5. URI pattern: `/{folder}/{action}` → `App\Controllers\{Folder}\{Action}Controller`

**Example routing:**
- `/` → `App\Controllers\HomeController::index()`
- `/admin/home` → `App\Controllers\Admin\HomeController::index()`
- `/site/produto` → `App\Controllers\Site\ProdutoController`

## Key Patterns & Conventions

### Controller Organization
- **Base controllers** (root level): `src/Controllers/{Name}Controller.php` in `App\Controllers` namespace
- **Grouped controllers** (Site/Admin): `src/Controllers/{Group}/{Action}Controller.php` in `App\Controllers\{Group}` namespace
- **Error handling**: `App\Controllers\Erro\ErrorController` handles invalid routes
- **Constants**: `DEFAULT_CONTROLLER` and `DEFAULT_ACTION` defined in router (default: "Home" and "index")

### PSR-4 Autoloading (composer.json)
All namespaces are configured with explicit mappings. When adding new code:
- New controller: Add to appropriate folder and namespace
- New utility class: Create in `src/Classes/` with `App\Classes` namespace
- Models/Repositories: Use base classes in `src/Models/Model.php` and `src/Repositories/Repository.php` (currently empty stubs)

### URI Parsing (`src/Classes/Uri.php`)
- Parses `$_SERVER["REQUEST_URI"]` into array segments via `explode('/', $uri)`
- `getUriArray()[1]` = folder/controller name, `[2]` = action name
- `emptyUri()` returns true for `/` or empty string

### Nested Controller Detection (`src/Controllers/Controller.php`)
- **FOLDERS_CONTROLLERS constant**: `['Site', 'Admin']` - whitelisted folders for nested structure
- Logic: If URI segment matches folder, load `App\Controllers\{Folder}\{Action}Controller`
- Otherwise: Load `App\Controllers\{Controller}Controller` from root

## Development Workflows

### Adding a New Controller
1. Create file in appropriate folder:
   - Root: `src/Controllers/MyController.php`
   - Grouped: `src/Controllers/Site/MyController.php`
2. Define class with namespace matching folder structure
3. Create `public` action methods (return void - echo output or set view)
4. No need to update autoload - PSR-4 handles it

### Dependencies & Setup
- **PHP**: ≥8.2.0 (strict typing available)
- **Twig**: ^3.22 for templating (integrated via `functions_twig.php`)
- **Symfony VarDumper**: For debugging (`dump()` function available)
- Install: `composer install`

### Session & Globals
- Sessions initialized in router: `session_start()`
- HTTP method detection: Use `$_SERVER["REQUEST_METHOD"]`
- Query strings: Parse via `$_GET`, `$_POST`

## Project-Specific Notes

- **View class** (`src/Views/View.php`): Currently empty - templating integration pending
- **Model/Repository base classes**: Empty stubs for future data layer implementation
- **Error handling**: Controlled via `Erro\ErrorController` - catches non-existent controller classes
- **Twig functions**: Defined in `src/Functions/functions_twig.php` (empty) - future custom helpers
- **Debug output**: Dump statements in `Controller::controller()` for routing inspection

## Common Pitfalls

1. **Namespace mismatch**: Ensure controller namespace matches folder structure exactly
2. **Whitelist enforcement**: Only `Site` and `Admin` folders support nested structure (see FOLDERS_CONTROLLERS)
3. **Action method visibility**: Methods must be public to be callable via routing
4. **URI parsing edge case**: Empty URI defaults to `HomeController::index()`
