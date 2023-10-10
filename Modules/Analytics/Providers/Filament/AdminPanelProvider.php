<?php

namespace Modules\Analytics\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    private string $module = "Analytics";
    public function panel(Panel $panel): Panel
    {
        $moduleNamespace = $this->getModuleNamespace();
        return $panel
            ->id('analytics::admin')
            ->path('admin/analytics')
            ->colors([
                'primary' => Color::Teal,
            ])
            ->discoverResources(in: module_path($this->module, 'Filament/Admin/Resources'), for: "$moduleNamespace\\Filament\\Admin\\Resources")
            ->discoverPages(in: module_path($this->module, 'Filament/Admin/Pages'), for: "$moduleNamespace\\Filament\\Admin\\Pages")
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: module_path($this->module, 'Filament/Admin/Widgets'), for: "$moduleNamespace\\Filament\\Admin\\Widgets")
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([               
                \Hasnayeen\Themes\ThemesPlugin::make()
            ]);
    }

    protected function getModuleNamespace(): string
    {
        return config('modules.namespace').'\\'.$this->module;
    }
}
