# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A [VitoDeploy](https://vitodeploy.com) plugin [specifically for the 4.x version (currently in beta)] that
installs [WP-CLI](https://wp-cli.org/) on remote servers via SSH.

## Structure

```
Plugin.php          # Plugin entry point — registers views & service type in boot()
Services/WpCli.php  # Service class — implements install(), uninstall(), version() via SSH
views/install.blade.php  # Blade template with the install shell script
views/uninstall.blade.php  # Blade template with the un-install shell script
```

## Key architecture

- `Plugin::boot()` registers the `wp-cli` service with Vito's `RegisterViews` and `RegisterServiceType` system
- `WpCli::install()` runs the `install.blade.php` template over SSH (downloads & verifies wp-cli.phar via GPG, installs
  to `/usr/local/bin/wp`), see [Installing](https://make.wordpress.org/cli/handbook/guides/installing/) WP-CLI guide for
  more information.
- `WpCli::uninstall()` runs a corresponding `uninstall.blade.php` template over SSH.
- `WpCli::version()` runs `wp cli version` over SSH.
- The `composer.json` autoload-dev maps `App\Vito\Plugins\TheFrosty\VitoWpCli\` to root `/` so local Vito package
  templates resolve during development

## Development notes

- This is a PHP 8.0+ project with no test suite or build steps.
- The `vendor/` directory is gitignored; `composer.json` references `vitodeploy/vito: 4.*` as a dev dependency.
- Views are blade templates containing raw shell scripts (not rendered HTML).
- See VitoDeploy 4.x plugin docs: https://vitodeploy.com/docs/4.x/plugins
