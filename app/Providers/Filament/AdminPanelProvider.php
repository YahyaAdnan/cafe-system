<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->darkMode(false)
            ->defaultThemeMode(ThemeMode::Light)
            ->unsavedChangesAlerts()
            ->login()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ])
            ->colors([
                'peach' => [
                    50 => '#fff4f0',
                    100 => '#ffe8e0',
                    200 => '#ffd1c2',
                    300 => '#ffb49d',
                    400 => '#ff8f6b',
                    500 => '#ff6b3d',
                    600 => '#ff4f1a',
                    700 => '#e63900',
                    800 => '#cc3300',
                    900 => '#a32800',
                    950 => '#661900',
                ],
                'lavender' => [
                    50 => '#f8f6ff',
                    100 => '#f0ebff',
                    200 => '#e4daff',
                    300 => '#d3bfff',
                    400 => '#b794ff',
                    500 => '#9d6aff',
                    600 => '#8445ff',
                    700 => '#6b1aff',
                    800 => '#5700e6',
                    900 => '#4600b8',
                    950 => '#2a006e',
                ],
                'coral' => [
                    50 => '#fff1f0',
                    100 => '#ffe4e2',
                    200 => '#ffc5bf',
                    300 => '#ff9f95',
                    400 => '#ff7563',
                    500 => '#ff4d36',
                    600 => '#ff2600',
                    700 => '#cc1e00',
                    800 => '#991700',
                    900 => '#661000',
                    950 => '#330800',
                ],
                'mint' => [
                    50 => '#f0fff7',
                    100 => '#e0fff0',
                    200 => '#b8ffd9',
                    300 => '#8bffc2',
                    400 => '#4dff9e',
                    500 => '#00ff6b',
                    600 => '#00cc55',
                    700 => '#009940',
                    800 => '#00662b',
                    900 => '#003315',
                    950 => '#001a0b',
                ],
                'sunset' => [
                    50 => '#fff8f0',
                    100 => '#fff1e0',
                    200 => '#ffe2c2',
                    300 => '#ffd199',
                    400 => '#ffb84d',
                    500 => '#ffa000',
                    600 => '#cc8000',
                    700 => '#996000',
                    800 => '#664000',
                    900 => '#332000',
                    950 => '#1a1000',
                ],
                'berry' => [
                    50 => '#fdf0f9',
                    100 => '#fae0f4',
                    200 => '#f7bfe8',
                    300 => '#f182d1',
                    400 => '#eb46ba',
                    500 => '#e60fa3',
                    600 => '#cc0d91',
                    700 => '#990a6d',
                    800 => '#660748',
                    900 => '#330424',
                    950 => '#1a0212',
                ],
                'ocean' => [
                    50 => '#f0faff',
                    100 => '#e0f4ff',
                    200 => '#bae8ff',
                    300 => '#7ed6ff',
                    400 => '#38c0ff',
                    500 => '#00a3ff',
                    600 => '#0082cc',
                    700 => '#006199',
                    800 => '#004166',
                    900 => '#002033',
                    950 => '#00101a',
                ],
                'golden' => [
                    50 => '#fffbf0',
                    100 => '#fff6e0',
                    200 => '#ffecb8',
                    300 => '#ffe08f',
                    400 => '#ffd466',
                    500 => '#ffc73d',
                    600 => '#ffb800',
                    700 => '#cc9300',
                    800 => '#996e00',
                    900 => '#664900',
                    950 => '#332500',
                ],
                'primary' => [
                    50 => '#f3f1f9',
                    100 => '#e7e3f4',
                    200 => '#cfc7e9',
                    300 => '#b7abde',
                    400 => '#9f8fd3',
                    500 => '#8773c8',
                    600 => '#6f5cbd',
                    700 => '#5745b2',
                    800 => '#463791',
                    900 => '#352970',
                    950 => '#231c4f',
                ],
                'secondary' => [
                    50 => '#f5f7fa',
                    100 => '#ebeef5',
                    200 => '#d7dfe9',
                    300 => '#b7c4d8',
                    400 => '#92a5c3',
                    500 => '#6c83ad',
                    600 => '#566b92',
                    700 => '#465877',
                    800 => '#3b4a63',
                    900 => '#344054',
                    950 => '#1d2535',
                ],
                'success' => [
                    50 => '#f0fdf4',
                    100 => '#dcfce7',
                    200 => '#bbf7d0',
                    300 => '#86efac',
                    400 => '#4ade80',
                    500 => '#22c55e',
                    600 => '#16a34a',
                    700 => '#15803d',
                    800 => '#166534',
                    900 => '#14532d',
                    950 => '#052e16',
                ],
                'warning' => [
                    50 => '#fffbeb',
                    100 => '#fef3c7',
                    200 => '#fde68a',
                    300 => '#fcd34d',
                    400 => '#fbbf24',
                    500 => '#f59e0b',
                    600 => '#d97706',
                    700 => '#b45309',
                    800 => '#92400e',
                    900 => '#78350f',
                    950 => '#451a03',
                ],
                'danger' => [
                    50 => '#fef2f2',
                    100 => '#fee2e2',
                    200 => '#fecaca',
                    300 => '#fca5a5',
                    400 => '#f87171',
                    500 => '#ef4444',
                    600 => '#dc2626',
                    700 => '#b91c1c',
                    800 => '#991b1b',
                    900 => '#7f1d1d',
                    950 => '#450a0a',
                ],
                'info' => [
                    50 => '#f0f9ff',
                    100 => '#e0f2fe',
                    200 => '#bae6fd',
                    300 => '#7dd3fc',
                    400 => '#38bdf8',
                    500 => '#0ea5e9',
                    600 => '#0284c7',
                    700 => '#0369a1',
                    800 => '#075985',
                    900 => '#0c4a6e',
                    950 => '#082f49',
                ],
                'gray' => [
                    50 => '#f8fafc',
                    100 => '#f1f5f9',
                    200 => '#e2e8f0',
                    300 => '#cbd5e1',
                    400 => '#94a3b8',
                    500 => '#64748b',
                    600 => '#475569',
                    700 => '#334155',
                    800 => '#1e293b',
                    900 => '#0f172a',
                    950 => '#020617',
                ],
                'indigo' => [
                    50 => '#f5f3ff',
                    100 => '#ede9fe',
                    200 => '#ddd6fe',
                    300 => '#c4b5fd',
                    400 => '#a78bfa',
                    500 => '#8b5cf6',
                    600 => '#7c3aed',
                    700 => '#6d28d9',
                    800 => '#5b21b6',
                    900 => '#4c1d95',
                    950 => '#2e1065',
                ],
                'rose' => [
                    50 => '#fff1f2',
                    100 => '#ffe4e6',
                    200 => '#fecdd3',
                    300 => '#fda4af',
                    400 => '#fb7185',
                    500 => '#f43f5e',
                    600 => '#e11d48',
                    700 => '#be123c',
                    800 => '#9f1239',
                    900 => '#881337',
                    950 => '#4c0519',
                ],
                'amber' => [
                    50 => '#fffbeb',
                    100 => '#fef3c7',
                    200 => '#fde68a',
                    300 => '#fcd34d',
                    400 => '#fbbf24',
                    500 => '#f59e0b',
                    600 => '#d97706',
                    700 => '#b45309',
                    800 => '#92400e',
                    900 => '#78350f',
                    950 => '#451a03',
                ],
                'emerald' => [
                    50 => '#ecfdf5',
                    100 => '#d1fae5',
                    200 => '#a7f3d0',
                    300 => '#6ee7b7',
                    400 => '#34d399',
                    500 => '#10b981',
                    600 => '#059669',
                    700 => '#047857',
                    800 => '#065f46',
                    900 => '#064e3b',
                    950 => '#022c22',
                ],
                'violet' => [
                    50 => '#f5f3ff',
                    100 => '#ede9fe',
                    200 => '#ddd6fe',
                    300 => '#c4b5fd',
                    400 => '#a78bfa',
                    500 => '#8b5cf6',
                    600 => '#7c3aed',
                    700 => '#6d28d9',
                    800 => '#5b21b6',
                    900 => '#4c1d95',
                    950 => '#2e1065',
                ],
                'teal' => [
                    50 => '#f0fdfa',
                    100 => '#ccfbf1',
                    200 => '#99f6e4',
                    300 => '#5eead4',
                    400 => '#2dd4bf',
                    500 => '#14b8a6',
                    600 => '#0d9488',
                    700 => '#0f766e',
                    800 => '#115e59',
                    900 => '#134e4a',
                    950 => '#042f2e',
                ],
                'cyan' => [
                    50 => '#ecfeff',
                    100 => '#cffafe',
                    200 => '#a5f3fc',
                    300 => '#67e8f9',
                    400 => '#22d3ee',
                    500 => '#06b6d4',
                    600 => '#0891b2',
                    700 => '#0e7490',
                    800 => '#155e75',
                    900 => '#164e63',
                    950 => '#083344',
                ],
                'fuchsia' => [
                    50 => '#fdf4ff',
                    100 => '#fae8ff',
                    200 => '#f5d0fe',
                    300 => '#f0abfc',
                    400 => '#e879f9',
                    500 => '#d946ef',
                    600 => '#c026d3',
                    700 => '#a21caf',
                    800 => '#86198f',
                    900 => '#701a75',
                    950 => '#4a044e',
                ],
                'lime' => [
                    50 => '#f7fee7',
                    100 => '#ecfccb',
                    200 => '#d9f99d',
                    300 => '#bef264',
                    400 => '#a3e635',
                    500 => '#84cc16',
                    600 => '#65a30d',
                    700 => '#4d7c0f',
                    800 => '#3f6212',
                    900 => '#365314',
                    950 => '#1a2e05',
                ],
                'sky' => [
                    50 => '#f0f9ff',
                    100 => '#e0f2fe',
                    200 => '#bae6fd',
                    300 => '#7dd3fc',
                    400 => '#38bdf8',
                    500 => '#0ea5e9',
                    600 => '#0284c7',
                    700 => '#0369a1',
                    800 => '#075985',
                    900 => '#0c4a6e',
                    950 => '#082f49',
                ]
            ])
            ->renderHook(
                'panels::main.start',  // 👈 Changed from body to main
                fn (): string => '

                <style>

            .language-switch-trigger{
            --tw-ring-opacity: 0 !important;
    --tw-ring-color: none !important;

            }
                    .glass-wrapper {
                        background-color: rgba(255, 255, 255, 0.3);
                        padding: 1.5rem;
                        border-radius: 35px;
                        border: 4px solid rgba(255, 255, 255, 0.1);
                        margin: 1rem;
                    }
                </style>
                <div class="glass-wrapper">'
            )
            ->renderHook(
                'panels::main.end',  // 👈 Changed from body to main
                fn (): string => '</div>'
            )

            ->renderHook(
                'panels::styles.after',
                fn (): string => '
                <style>
                .fi-logo {
                margin-top: 40px !important;
                height: 5.5rem !important;
                border-radius: 10px !important;
                }
                    /* Root Variables */
                    :root {
                        --color-primary: #8773c8;
                        --color-secondary: #6c83ad;
                        --color-success: #10b981;
                        --color-danger: #ef4444;
                        --color-warning: #f59e0b;
                        --color-info: #3b82f6;
                        --color-background: #f3f1f9;
                        --color-surface: #ffffff;
                        --color-text: #3a4964;
                        --color-text-secondary: #6c83ad;
                        --glassmorphism: rgba(255, 255, 255, 0.1);
                        --glassmorphism-border: rgba(255, 255, 255, 0.1);
                        --noise-opacity: 0.18;
                    }


                    /* Main Background */
                    body {
        background-color: var(--color-background) !important;
        color: var(--color-text) !important;
    }

                    /* Glass Effect */
                    .filament-main-content,
                    .filament-card,
                    .filament-sidebar,
                    .filament-tables-container,
                    .filament-forms-field-wrapper,
                    .filament-modal-window {
                        background: var(--glassmorphism) !important;
                        border: 1px solid var(--glassmorphism-border) !important;
                        border-radius: 12px !important;
                    }

                    /* Tables Specific */
                    .filament-tables-container {
                        overflow: hidden !important;
                    }

                    .filament-tables-table-container {
                        background: transparent !important;
                    }

                    /* Loader Animation */
                    @keyframes rotate {
                        100% { transform: rotate(360deg); }
                    }
                    @keyframes dash {
                        0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
                        50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
                        100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
                    }

                    .custom-loader {
                        animation: rotate 2s linear infinite;
                        z-index: 2;
                        width: 40px;
                        height: 40px;
                    }

                    .custom-loader circle {
                        stroke: var(--color-primary);
                        stroke-linecap: round;
                        animation: dash 1.5s ease-in-out infinite;
                    }

                    /* Pagination */
                    .filament-tables-pagination button {
                        background: var(--glassmorphism) !important;
                        border-color: var(--glassmorphism-border) !important;
                    }

                    .filament-tables-pagination button:hover {
                        background: rgba(255, 255, 255, 0.2) !important;
                    }

                    /* Noise Overlay */
                    body::before {
                        content: "";
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-image: url("data:image/svg+xml,%3Csvg viewBox=\'0 0 241 241\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'2.45\' numOctaves=\'1\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E");
                        opacity: var(--noise-opacity);
                        pointer-events: none;
                        z-index: 9999;
                    }



                    /* Hover Effects */
                    .filament-button:hover {
                        background: rgba(255, 255, 255, 0.2) !important;
                        transform: translateY(-1px);
                        transition: all 0.2s ease;
                    }

                    /* Sidebar Refinements */
                    .filament-sidebar {
                        border-radius: 0 12px 12px 0 !important;
                    }
                     /* Inner components */
                    .filament-main-content .filament-card,
                    .filament-main-content .filament-tables-container,
                    .filament-main-content .filament-form-card {
                        background: transparent !important;
                        border: none !important;
                    }
                        /* Target the main wrapper specifically */
                    .fi-main {
                       width: 99% !important;
    background-color: rgb(255 255 255 / 32%) !important;
    -filter: blur(12px) !important;
    --(12px) !important;
    border: 4px solid rgb(255 255 255 / 19%) !important;
    border-radius: 35px !important;
    padding: 1.5rem !important;
    margin: 1rem auto !important;
    max-width: 96% !important;
    font-weight: bold !important;
                    }




                    /* Sidebar specific */
                    .filament-sidebar {
                        background: rgba(255, 255, 255, 0.1) !important;
                        (12px) !important;
                        border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
                    }


                    /* Inner content should be transparent */
                    .fi-main .filament-main-content {
                        background: transparent !important;
                        -filter: none !important;
                        border: none !important;
                        padding: 0 !important;
                        margin: 0 !important;
                    }

                        /* Main table container */

                    .fi-ta-ctn {
                        background: rgba(255, 255, 255, 0.3) !important;
                        (12px) !important;
                        -it-(12px) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        box-shadow: none !important;
                    }

                    /* Table header container */
                    .fi-ta-header-ctn {
                        background: rgba(255, 255, 255, 0.2) !important;
                        border-color: rgba(255, 255, 255, 0.1) !important;
                    }

                    /* Table rows */
                    .fi-ta-row {
                        background: transparent !important;
                        border-color: rgba(255, 255, 255, 0.1) !important;
                    }

                    /* Table row hover */
                    .fi-ta-row:hover {
                        background: rgba(255, 255, 255, 0.1) !important;
                    }

                    /* Table cells */
                    .fi-ta-cell {
                        background: transparent !important;
                    }

                    /* Remove harsh dividers */
                    .divide-gray-200 {
                        --tw-divide-opacity: 0.1 !important;
                    }

                    /* Override dark mode styles */
                    .dark .fi-ta-ctn,
                    .dark .fi-ta-header-ctn,
                    .dark .fi-ta-row {
                        background: rgba(255, 255, 255, 0.1) !important;
                    }

                    /* Make text more visible */
                    .fi-ta-text {
                        color: rgba(0, 0, 0, 0.8) !important;
                    }

                    /* Remove default shadows */
                    .ring-1 {
                        --tw-ring-color: rgba(208, 208, 208, 1) !important;
                    }

                    /* Custom scrollbar for tables */
                    .fi-ta-ctn::-it-scrollbar {
                        width: 8px;
                        height: 8px;
                    }

                    .fi-ta-ctn::--scrollbar-track {
                        background: rgba(255, 255, 255, 0.1);
                    }

                    .fi-ta-ctn::--scrollbar-thumb {
                        background: rgba(255, 255, 255, 0.2);
                        border-radius: 4px;
                    }

                    /* Table header text */
                    .fi-ta-header {
                        color: rgba(0, 0, 0, 0.7) !important;
                    }

                    /* Pagination section */
                    .fi-pagination {
                        background: white !important;
                    }

                    .fi-modal-close-overlay {
                    background-color: rgba(0, 0, 0, 0.7) !important;
                    }
                        .dark .fi-ta-ctn,
                        .dark .fi-sidebar,
                        .dark .fi-main,
                        .dark .fi-modal,
                        .dark .fi-dropdown-list,
                        .dark .fi-form-component {
                            background: inherit !important;
                            color-scheme: light !important;
                        }


                </style>
                                <div class="noise-overlay"></div>

            '
            )

            ->renderHook(
                'panels::styles.after',
                fn (): string => '
                <style>


                .fi-sidebar-header{
                margin-bottom: 15px !important;
                }
                .divide-gray-200>:not([hidden])~:not([hidden]){
                border-color:rgba(227, 227, 231, 0);
                }

                tbody{
                background-color: rgba(255,255,255,0.68) !important;
                }

                .fi-ta-header-ctn{
                padding : 17px !important;
                }

                .fi-ta-row:hover{
                background-color: rgba(249, 247, 247, 0.72) !important;
                }
                  thead tr {
                        background-color: white !important;
                        border-top: 0px;
                        border-bottom: 0px;
                        }
                 .fi-btn {    position: relative !important;
                        display: inline-grid !important;
                        grid-auto-flow: column !important;
                        align-items: center !important;
                        justify-content: center !important;
                        gap: 0.375rem !important;
                        border-radius: 0.5rem !important;
                        padding: 0.5rem 0.75rem !important;
                        font-size: 0.875rem !important;
                        font-weight: 600 !important;
                        transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1) !important;
                        outline: none !important;
                    }

                    /* Primary Button */
                    .fi-btn-primary {
                        background: rgba(255, 255, 255, 0.2) !important;
                        (10px) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        color: #ffffff !important;
                    }

                    .fi-btn-primary:hover {
                        background: rgba(255, 255, 255, 0.3) !important;
                        transform: translateY(-1px) !important;
                    }

                    /* Secondary/Gray Button */
                    .fi-btn-gray {
                        background: rgba(255, 255, 255, 0.1) !important;
                        (10px) !important;
                        border: 1px solid rgba(255, 255, 255, 0.05) !important;
                        color: rgba(255, 255, 255, 0.9) !important;
                    }

                    .fi-btn-gray:hover {
                        background: rgba(255, 255, 255, 0.2) !important;
                        transform: translateY(-1px) !important;
                    }

                    /* Button Icons */
                    .fi-btn-icon {
                        height: 1.25rem !important;
                        width: 1.25rem !important;
                        color: rgba(4,4,4,0.36) !important;
                    }

                    /* Button Shadow */
                    .fi-btn {
                           box-shadow: 0px 0px 7px 0px rgb(0 0 0 / 4%) !important;
    border-width: 0.9px !important;
                    }

                    /* Focus State */
                    .fi-btn:focus-visible {
                        ring: 2px !important;
                        ring-offset: 2px !important;
                        ring-color: rgba(135, 115, 200, 0.5) !important;
                    }

                    /* Disabled State */
                    .fi-btn:disabled {
                        opacity: 0.7 !important;
                        cursor: not-allowed !important;
                    }

                    /* Loading State */
                    .fi-btn[wire\:loading] {
                        opacity: 0.7 !important;
                        cursor: wait !important;
                    }

                    /* Size Variations */
                    .fi-btn-size-sm {
                        padding: 0.375rem 0.625rem !important;
                        font-size: 0.75rem !important;
                    }

                    .fi-btn-size-lg {
                        padding: 0.625rem 1rem !important;
                        font-size: 1rem !important;
                    }

                    /* Button Groups */
                    .fi-btn-group {
                        display: inline-flex !important;
                        border-radius: 0.5rem !important;
                        overflow: hidden !important;
                    }
                    /* Input Wrapper Styling */
    .fi-input-wrp {
        border: 0.4px solid rgba(135, 115, 200, 0.3) !important;
        border-radius: 9px !important;
        overflow: hidden !important;
        transition: all 0.2s ease !important;
        background: rgba(255, 255, 255, 0.35) !important;
        box-shadow: 0 0 0 1px rgba(135, 115, 200, 0.1) !important;
    }

.fi-sidebar-item {
    transition: all 0.2s ease !important;
}

.fi-sidebar-item-button{
margin-top: 4px;
}

.fi-sidebar-item-button:active{
background-color: rgb(48 48 228 / 8%) !important;
}

.fi-sidebar-item-button:focus{
background-color: rgb(48 48 228 / 8%) !important;
}

.fi-sidebar-item-button:visited{
background-color: rgb(227 227 255 / 8%) !important;
}


.fi-sidebar-item:hover .fi-sidebar-item-label,
.fi-sidebar-item:hover .fi-sidebar-item-icon {
    color: var(--color-primary) !important;
    transform: translateX(2px) !important;
}

.fi-sidebar-item-label,
.fi-sidebar-item-icon {
    transition: all 0.2s ease !important;
}
    /* Wrapper Focus State */
    .fi-input-wrp:focus-within {
        border-color: rgba(135, 115, 200, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(135, 115, 200, 0.15) !important;
        outline: none !important;
        ring: 0 !important;
    }

    /* Wrapper Hover State */
    .fi-input-wrp:hover:not(:focus-within) {
        border-color: rgba(135, 115, 200, 0.4) !important;
    }

    /* Reset Input Styles */
    .fi-input-wrp .fi-input {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        ring: 0 !important;
        background: transparent !important;
    }

    /* Modern Card & Section Styling */
    .fi-section {
        background: rgba(255, 255, 255, 0.3) !important;
        (12px) !important;
        --(12px) !important;
        border: 1px solid rgba(218,218,218,0.34) !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 24px -1px rgba(0,0,0,0.02) !important;
        overflow: hidden !important;

    }



.gap-x-3 {
    -moz-column-gap: .75rem;
    column-gap: 0.90rem !important;
}

    .fi-section-content-ctn{
    box-shadow: none;
    }

    .language-switch-trigger{

    --tw-ring-opacity: 0 !important;

   }

            .fi-user-menu {
            border-radius: 8px !important;
            }

    .fi-section-header{
    margin: 15px;
    }


    /* Section Content Container */
    .fi-section-content {
        background: transparent !important;
    }

    /* Account Widget Specific */
    .fi-account-widget {
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .fi-account-widget:hover {
        transform: translateY(-2px) !important;
    }

    /* Avatar Container */
    .fi-avatar {
        border: 2px solid rgba(135, 115, 200, 0.2) !important;
        background: rgba(255, 255, 255, 0.9) !important;
    }

    /* Text Styling */
    .fi-section h2 {
        color: rgba(70, 55, 145, 0.9) !important;
        font-weight: 600 !important;
    }

    .fi-section p {
        color: rgba(70, 55, 145, 0.7) !important;
    }

    /* Inner Content */
    .fi-section-content-ctn {
        background: transparent !important;
    }

    /* Remove Default Ring */
    .ring-gray-950\/5 {
        --tw-ring-color: rgb(159 159 159 / 19%) !important;
    }

    /* Sign Out Button */
    .fi-section .fi-btn {
        background: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(135, 115, 200, 0.2) !important;
        (8px) !important;
        --(8px) !important;
        transition: all 0.2s ease !important;
    }

    .fi-section .fi-btn:hover {
        background: rgba(255, 255, 255, 0.3) !important;
        border-color: rgba(135, 115, 200, 0.3) !important;
        transform: translateY(-1px) !important;
    }

    /* Icon Button */
    .fi-icon-btn {
        background: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(135, 115, 200, 0.1) !important;
    }

    .fi-icon-btn:hover {
        background: rgba(255, 255, 255, 0.25) !important;
    }

    .hover\:bg-gray-100:hover{
        background-color: rgb(255 255 255 / 62%) !important;
    }

    nav{
    background: transparent !important;
    box-shadow: none !important;
    }

    .fi-sidebar-header{
    background: transparent !important;
    box-shadow: none !important;

    }
    .fi-logo{
     color: rgb(119 100 191) !important;
    }

    /* Add these new styles for the dropdown */
.choices__list--dropdown {
    background: rgba(255, 255, 255, 0.98) !important;
    border: 1px solid rgba(135, 115, 200, 0.2) !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
    z-index: 999 !important;
    margin: 8px !important;
    position: relative !important;
}

.choices__list--dropdown .choices__item {
    padding: 8px 12px !important;
    color: var(--color-text) !important;
}

.choices__list--dropdown .choices__item--selectable:hover {
    background: rgba(135, 115, 200, 0.1) !important;
}


.choices__list--dropdown, .choices__list[aria-expanded]{
width: auto !important;
}
/* Fix for dropdown visibility */
.choices {
    z-index: 999 !important;
    position: relative !important;
}



                    </style>

                ')
            ->renderHook(
                'panels::styles.after',
                fn (): string => '
            <style>
            /* Secondary/Cancel/Back Buttons */
.fi-btn.fi-btn-color-gray,
.fi-btn.fi-color-gray {
    background: rgba(255, 255, 255, 0.3) !important;
    -filter: blur(8px) !important;
    -it--filter: blur(8px) !important;
    border: 1px solid rgba(108, 131, 173, 0.2) !important;  /* Using secondary color */
    color: #6c83ad !important;  /* Secondary color */
    box-shadow: 0 2px 4px rgba(108, 131, 173, 0.05) !important;
    font-weight: 500 !important;
}

/* Hover State */
.fi-btn.fi-btn-color-gray:hover,
.fi-btn.fi-color-gray:hover {
    background: rgba(255, 255, 255, 0.4) !important;
    border-color: rgba(108, 131, 173, 0.3) !important;
}

/* Active/Pressed State */
.fi-btn.fi-btn-color-gray:active,
.fi-btn.fi-color-gray:active {
    background: rgba(255, 255, 255, 0.35) !important;
    box-shadow: 0 2px 4px rgba(108, 131, 173, 0.1) !important;
}

/* Icon in Button */
.fi-btn.fi-btn-color-gray .fi-btn-icon,
.fi-btn.fi-color-gray .fi-btn-icon {
    color: rgba(108, 131, 173, 0.7) !important;
    opacity: 0.9 !important;
}

/* Focus State */
.fi-btn.fi-btn-color-gray:focus-visible,
.fi-btn.fi-color-gray:focus-visible {
    outline: none !important;
    box-shadow: 0 0 0 2px white, 0 0 0 4px rgba(108, 131, 173, 0.2) !important;
}

/* Loading State */
.fi-btn.fi-btn-color-gray[wire\:loading],
.fi-btn.fi-color-gray[wire\:loading] {
    opacity: 0.7 !important;
    cursor: wait !important;
}

/* Checked State (if needed) */
[input:checked+.fi-btn.fi-btn-color-gray],
[input:checked+.fi-btn.fi-color-gray] {
    background: rgba(108, 131, 173, 0.2) !important;
    color: #6c83ad !important;
    border-color: rgba(108, 131, 173, 0.3) !important;
}

.fi-user-menu{
 background-color: rgba(255,255,255,0.56);
                        padding: 1px;
                        border-radius: 35px;
                        border: 4px solid rgba(255,255,255,0.53);
}

  /* Pagination Container */
    .fi-pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 1rem !important;
        padding: 1rem !important;
    }

    /* Pagination Items Container */
    .fi-pagination-items {
        display: flex !important;
        justify-content: center !important;
        margin: 0 auto !important;
    }

    /* Overview Text */
    .fi-pagination-overview {
        text-align: center !important;
        width: auto !important;
        flex: 0 0 auto !important;
    }

    /* Per Page Select */
    .fi-pagination-records-per-page-select {
        margin: 0 1rem !important;
    }

    /* Fix the grid layout */
    .grid.grid-cols-\[1fr_auto_1fr\] {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 1rem !important;
    }

    /* Navigation Buttons */
    .fi-pagination-next-btn,
    .fi-pagination-previous-btn {
        position: relative !important;
        transform: none !important;
    }

    /* Center align the records per page dropdown */
    .col-start-2 {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 0 auto !important;
    }

    /* Remove default grid positioning */
    .justify-self-end,
    .justify-self-start {
        justify-self: auto !important;
    }

    /* Container adjustments */
    .fi-ta-pagination {
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 1rem !important;
        padding: 1rem !important;
        flex-wrap: wrap !important;
    }

    /* Make items wrap on mobile */
    @media (max-width: 640px) {
        .fi-ta-pagination {
            flex-direction: column !important;
            gap: 0.75rem !important;
        }

        .fi-pagination-items {
            order: 2 !important;
        }
    }

    .fi-ta-filters-dropdown{
    margin-right: 10px !important;
    }


    }
     .fi-fo-repeater-item  {
            border-width: 0.5px;
            }
            </style>
                ')
            ->font('Inter')
            ->brandName('Ali Cafe System')
            ->renderHook(
                'panels::main.start',  // 👈 Changed from body to main
                fn (): string => '
                <style>
                    .fi-ac-btn-action .fi-fo-actions  {
                        margin-top: 100px !important;
                    }



                </style>
               '
            )
            ->renderHook(
                'panels::head.end',
                fn () => new HtmlString('
                <style>
                    /* Make validation errors more prominent */
                   /* Maximum specificity override */
                    html body .fi-fo-field-wrp-error-message,
                    html body .fi-fo-field-wrp-error-message[class*="text-"],
                    .fi-fo-field-wrp-error-message.text-danger-600,
                    .dark .fi-fo-field-wrp-error-message.text-danger-400,
                    [data-validation-error].fi-fo-field-wrp-error-message {
                        color: rgb(220, 38, 38) !important;
                        color: #DC2626 !important;
                        --tw-text-opacity: 1 !important;
                        font-weight: 600 !important;
                        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
                    }

                    /* Use CSS custom property override */
                    :root {
                        --fi-error-color: rgb(220, 38, 38) !important;
                    }

                    /* Additional forceful overrides */
                    .fi-fo-field-wrp-error-message {
                        color: var(--fi-error-color) !important;
                        -webkit-text-fill-color: rgb(220, 38, 38) !important;
                    }

                    /* Force override for any potential color transitions */
                    .fi-fo-field-wrp-error-message * {
                        color: inherit !important;
                    }

                    /* Override dark mode specifically */
                    @media (prefers-color-scheme: dark) {
                        .fi-fo-field-wrp-error-message {
                            color: rgb(248, 113, 113) !important;
                            -webkit-text-fill-color: rgb(248, 113, 113) !important;
                        }
                    }
                    /* Add shake animation for errors */
                    @keyframes shake {
                        10%, 90% {
                            transform: translate3d(-1px, 0, 0);
                        }

                        20%, 80% {
                            transform: translate3d(2px, 0, 0);
                        }

                        30%, 50%, 70% {
                            transform: translate3d(-4px, 0, 0);
                        }

                        40%, 60% {
                            transform: translate3d(4px, 0, 0);
                        }
                    }

                    /* Error state for inputs */
                    .has-error .fi-input-wrp {
                        border-color: rgb(220, 38, 38) !important;
                        box-shadow: 0 0 0 1px rgb(220, 38, 38) !important;
                    }

                    /* Danger text overrides */
                    .text-danger-600 {
                        color: rgb(220, 38, 38) !important;
                    }

                    .dark .text-danger-400 {
                        color: rgb(248, 113, 113) !important;
                    }

                    .hover\:bg-custom-400\/10:hover {
    color: white !important;
    background-color: rgb(90 62 179 / 79%) !important;
}

  .hover\:bg-custom-400\/10:focus {
    color: white !important;
    background-color: rgb(90 62 179 / 79%) !important;
}

 .focus\:bg-custom-400\/10:focus {
    color: white !important;
    background-color: rgb(90 62 179 / 79%) !important;
}

 .focus\:bg-custom-400\/10:active {
    color: white !important;
    background-color: rgb(90 62 179 / 79%) !important;
}
.hover\:bg-custom-400\/10:active {
    color: white !important;
    background-color: rgb(90 62 179 / 79%) !important;
}


.fi-dropdown-panel{
z-index: 9;
}

.fi-btn-label{
font-weight: bold;
}

body{
font-weight: bold !important;
}

 .fi-btn-icon{
                    color: white !important;
                    }


                    .fi-badge{
                        --tw-ring-color :rgba(var(--c-600), 0.3) !important;
                        font-size: 12px !important;
                        font-weight: bold !important;
                    }
                </style>
            ')
            )
            ->authMiddleware([
                Authenticate::class,
            ])->navigationItems([

            ]);
    }

    private function getNavigation()
    {
        return array(
            NavigationItem::make()
                ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                ->url(fn (): string => Dashboard::getUrl())
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.pages.dashboard')),
            // ...
        );
    }
}
