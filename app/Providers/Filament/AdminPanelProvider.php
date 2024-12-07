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

//            ->renderHook(
//                'panels::main.start',  // 👈 Changed from body to main
//                fn (): string => '
//
//                <style>
//
//            .language-switch-trigger{
//            --tw-ring-opacity: 0 !important;
//    --tw-ring-color: none !important;
//
//            }
//                    .glass-wrapper {
//                        background-color: rgba(255, 255, 255, 0.3);
//                        padding: 1.5rem;
//                        border-radius: 35px;
//                        border: 4px solid rgba(255, 255, 255, 0.1);
//                        margin: 1rem;
//                    }
//                </style>
//                <div class="glass-wrapper">'
//            )
//            ->renderHook(
//                'panels::main.end',  // 👈 Changed from body to main
//                fn (): string => '</div>'
//            )
//
//            ->renderHook(
//                'panels::styles.after',
//                fn (): string => '
//                <style>
//                .fi-logo {
//                margin-top: 40px !important;
//                height: 5.5rem !important;
//                border-radius: 10px !important;
//                }
//                    /* Root Variables */
//                    :root {
//                        --color-primary: #8773c8;
//                        --color-secondary: #6c83ad;
//                        --color-success: #10b981;
//                        --color-danger: #ef4444;
//                        --color-warning: #f59e0b;
//                        --color-info: #3b82f6;
//                        --color-background: #f3f1f9;
//                        --color-surface: #ffffff;
//                        --color-text: #3a4964;
//                        --color-text-secondary: #6c83ad;
//                        --glassmorphism: rgba(255, 255, 255, 0.1);
//                        --glassmorphism-border: rgba(255, 255, 255, 0.1);
//                        --noise-opacity: 0.18;
//                    }
//
//
//                    /* Main Background */
//                    body {
//        background-color: var(--color-background) !important;
//        color: var(--color-text) !important;
//    }
//
//                    /* Glass Effect */
//                    .filament-main-content,
//                    .filament-card,
//                    .filament-sidebar,
//                    .filament-tables-container,
//                    .filament-forms-field-wrapper,
//                    .filament-modal-window {
//                        background: var(--glassmorphism) !important;
//                        border: 1px solid var(--glassmorphism-border) !important;
//                        border-radius: 12px !important;
//                    }
//
//                    /* Tables Specific */
//                    .filament-tables-container {
//                        overflow: hidden !important;
//                    }
//
//                    .filament-tables-table-container {
//                        background: transparent !important;
//                    }
//
//                    /* Loader Animation */
//                    @keyframes rotate {
//                        100% { transform: rotate(360deg); }
//                    }
//                    @keyframes dash {
//                        0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
//                        50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
//                        100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
//                    }
//
//                    .custom-loader {
//                        animation: rotate 2s linear infinite;
//                        z-index: 2;
//                        width: 40px;
//                        height: 40px;
//                    }
//
//                    .custom-loader circle {
//                        stroke: var(--color-primary);
//                        stroke-linecap: round;
//                        animation: dash 1.5s ease-in-out infinite;
//                    }
//
//                    /* Pagination */
//                    .filament-tables-pagination button {
//                        background: var(--glassmorphism) !important;
//                        border-color: var(--glassmorphism-border) !important;
//                    }
//
//                    .filament-tables-pagination button:hover {
//                        background: rgba(255, 255, 255, 0.2) !important;
//                    }
//
//                    /* Noise Overlay */
//                    body::before {
//                        content: "";
//                        position: fixed;
//                        top: 0;
//                        left: 0;
//                        width: 100%;
//                        height: 100%;
//                        background-image: url("data:image/svg+xml,%3Csvg viewBox=\'0 0 241 241\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'2.45\' numOctaves=\'1\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E");
//                        opacity: var(--noise-opacity);
//                        pointer-events: none;
//                        z-index: 9999;
//                    }
//
//
//
//                    /* Hover Effects */
//                    .filament-button:hover {
//                        background: rgba(255, 255, 255, 0.2) !important;
//                        transform: translateY(-1px);
//                        transition: all 0.2s ease;
//                    }
//
//                    /* Sidebar Refinements */
//                    .filament-sidebar {
//                        border-radius: 0 12px 12px 0 !important;
//                    }
//                     /* Inner components */
//                    .filament-main-content .filament-card,
//                    .filament-main-content .filament-tables-container,
//                    .filament-main-content .filament-form-card {
//                        background: transparent !important;
//                        border: none !important;
//                    }
//                        /* Target the main wrapper specifically */
//                    .fi-main {
//                       width: 99% !important;
//    background-color: rgb(255 255 255 / 32%) !important;
//    -filter: blur(12px) !important;
//    --(12px) !important;
//    border: 4px solid rgb(255 255 255 / 19%) !important;
//    border-radius: 35px !important;
//    padding: 1.5rem !important;
//    margin: 1rem auto !important;
//    max-width: 96% !important;
//    font-weight: bold !important;
//                    }
//
//
//
//
//                    /* Sidebar specific */
//                    .filament-sidebar {
//                        background: rgba(255, 255, 255, 0.1) !important;
//                        (12px) !important;
//                        border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
//                    }
//
//
//                    /* Inner content should be transparent */
//                    .fi-main .filament-main-content {
//                        background: transparent !important;
//                        -filter: none !important;
//                        border: none !important;
//                        padding: 0 !important;
//                        margin: 0 !important;
//                    }
//
//                        /* Main table container */
//
//                    .fi-ta-ctn {
//                        background: rgba(255, 255, 255, 0.3) !important;
//                        (12px) !important;
//                        -it-(12px) !important;
//                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
//                        box-shadow: none !important;
//                    }
//
//                    /* Table header container */
//                    .fi-ta-header-ctn {
//                        background: rgba(255, 255, 255, 0.2) !important;
//                        border-color: rgba(255, 255, 255, 0.1) !important;
//                    }
//
//                    /* Table rows */
//                    .fi-ta-row {
//                        background: transparent !important;
//                        border-color: rgba(255, 255, 255, 0.1) !important;
//                    }
//
//                    /* Table row hover */
//                    .fi-ta-row:hover {
//                        background: rgba(255, 255, 255, 0.1) !important;
//                    }
//
//                    /* Table cells */
//                    .fi-ta-cell {
//                        background: transparent !important;
//                    }
//
//                    /* Remove harsh dividers */
//                    .divide-gray-200 {
//                        --tw-divide-opacity: 0.1 !important;
//                    }
//
//                    /* Override dark mode styles */
//                    .dark .fi-ta-ctn,
//                    .dark .fi-ta-header-ctn,
//                    .dark .fi-ta-row {
//                        background: rgba(255, 255, 255, 0.1) !important;
//                    }
//
//                    /* Make text more visible */
//                    .fi-ta-text {
//                        color: rgba(0, 0, 0, 0.8) !important;
//                    }
//
//                    /* Remove default shadows */
//                    .ring-1 {
//                        --tw-ring-color: rgba(208, 208, 208, 1) !important;
//                    }
//
//                    /* Custom scrollbar for tables */
//                    .fi-ta-ctn::-it-scrollbar {
//                        width: 8px;
//                        height: 8px;
//                    }
//
//                    .fi-ta-ctn::--scrollbar-track {
//                        background: rgba(255, 255, 255, 0.1);
//                    }
//
//                    .fi-ta-ctn::--scrollbar-thumb {
//                        background: rgba(255, 255, 255, 0.2);
//                        border-radius: 4px;
//                    }
//
//                    /* Table header text */
//                    .fi-ta-header {
//                        color: rgba(0, 0, 0, 0.7) !important;
//                    }
//
//                    /* Pagination section */
//                    .fi-pagination {
//                        background: white !important;
//                    }
//
//                    .fi-modal-close-overlay {
//                    background-color: rgba(0, 0, 0, 0.7) !important;
//                    }
//                        .dark .fi-ta-ctn,
//                        .dark .fi-sidebar,
//                        .dark .fi-main,
//                        .dark .fi-modal,
//                        .dark .fi-dropdown-list,
//                        .dark .fi-form-component {
//                            background: inherit !important;
//                            color-scheme: light !important;
//                        }
//
//
//                </style>
//                                <div class="noise-overlay"></div>
//
//            '
//            )
//
//            ->renderHook(
//                'panels::styles.after',
//                fn (): string => '
//                <style>
//
//
//                .fi-sidebar-header{
//                margin-bottom: 15px !important;
//                }
//                .divide-gray-200>:not([hidden])~:not([hidden]){
//                border-color:rgba(227, 227, 231, 0);
//                }
//
//                tbody{
//                background-color: rgba(255,255,255,0.68) !important;
//                }
//
//                .fi-ta-header-ctn{
//                padding : 17px !important;
//                }
//
//                .fi-ta-row:hover{
//                background-color: rgba(249, 247, 247, 0.72) !important;
//                }
//                  thead tr {
//                        background-color: white !important;
//                        border-top: 0px;
//                        border-bottom: 0px;
//                        }
//                 .fi-btn {    position: relative !important;
//                        display: inline-grid !important;
//                        grid-auto-flow: column !important;
//                        align-items: center !important;
//                        justify-content: center !important;
//                        gap: 0.375rem !important;
//                        border-radius: 0.5rem !important;
//                        padding: 0.5rem 0.75rem !important;
//                        font-size: 0.875rem !important;
//                        font-weight: 600 !important;
//                        transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1) !important;
//                        outline: none !important;
//                    }
//
//                    /* Primary Button */
//                    .fi-btn-primary {
//                        background: rgba(255, 255, 255, 0.2) !important;
//                        (10px) !important;
//                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
//                        color: #ffffff !important;
//                    }
//
//                    .fi-btn-primary:hover {
//                        background: rgba(255, 255, 255, 0.3) !important;
//                        transform: translateY(-1px) !important;
//                    }
//
//                    /* Secondary/Gray Button */
//                    .fi-btn-gray {
//                        background: rgba(255, 255, 255, 0.1) !important;
//                        (10px) !important;
//                        border: 1px solid rgba(255, 255, 255, 0.05) !important;
//                        color: rgba(255, 255, 255, 0.9) !important;
//                    }
//
//                    .fi-btn-gray:hover {
//                        background: rgba(255, 255, 255, 0.2) !important;
//                        transform: translateY(-1px) !important;
//                    }
//
//                    /* Button Icons */
//                    .fi-btn-icon {
//                        height: 1.25rem !important;
//                        width: 1.25rem !important;
//                        color: rgba(4,4,4,0.36) !important;
//                    }
//
//                    /* Button Shadow */
//                    .fi-btn {
//                           box-shadow: 0px 0px 7px 0px rgb(0 0 0 / 4%) !important;
//    border-width: 0.9px !important;
//                    }
//
//                    /* Focus State */
//                    .fi-btn:focus-visible {
//                        ring: 2px !important;
//                        ring-offset: 2px !important;
//                        ring-color: rgba(135, 115, 200, 0.5) !important;
//                    }
//
//                    /* Disabled State */
//                    .fi-btn:disabled {
//                        opacity: 0.7 !important;
//                        cursor: not-allowed !important;
//                    }
//
//                    /* Loading State */
//                    .fi-btn[wire\:loading] {
//                        opacity: 0.7 !important;
//                        cursor: wait !important;
//                    }
//
//                    /* Size Variations */
//                    .fi-btn-size-sm {
//                        padding: 0.375rem 0.625rem !important;
//                        font-size: 0.75rem !important;
//                    }
//
//                    .fi-btn-size-lg {
//                        padding: 0.625rem 1rem !important;
//                        font-size: 1rem !important;
//                    }
//
//                    /* Button Groups */
//                    .fi-btn-group {
//                        display: inline-flex !important;
//                        border-radius: 0.5rem !important;
//                        overflow: hidden !important;
//                    }
//                    /* Input Wrapper Styling */
//    .fi-input-wrp {
//        border: 0.4px solid rgba(135, 115, 200, 0.3) !important;
//        border-radius: 9px !important;
//        overflow: hidden !important;
//        transition: all 0.2s ease !important;
//        background: rgba(255, 255, 255, 0.35) !important;
//        box-shadow: 0 0 0 1px rgba(135, 115, 200, 0.1) !important;
//    }
//
//.fi-sidebar-item {
//    transition: all 0.2s ease !important;
//}
//
//.fi-sidebar-item-button{
//margin-top: 4px;
//}
//
//.fi-sidebar-item-button:active{
//background-color: rgb(48 48 228 / 8%) !important;
//}
//
//.fi-sidebar-item-button:focus{
//background-color: rgb(48 48 228 / 8%) !important;
//}
//
//.fi-sidebar-item-button:visited{
//background-color: rgb(227 227 255 / 8%) !important;
//}
//
//
//.fi-sidebar-item:hover .fi-sidebar-item-label,
//.fi-sidebar-item:hover .fi-sidebar-item-icon {
//    color: var(--color-primary) !important;
//    transform: translateX(2px) !important;
//}
//
//.fi-sidebar-item-label,
//.fi-sidebar-item-icon {
//    transition: all 0.2s ease !important;
//}
//    /* Wrapper Focus State */
//    .fi-input-wrp:focus-within {
//        border-color: rgba(135, 115, 200, 0.5) !important;
//        box-shadow: 0 0 0 3px rgba(135, 115, 200, 0.15) !important;
//        outline: none !important;
//        ring: 0 !important;
//    }
//
//    /* Wrapper Hover State */
//    .fi-input-wrp:hover:not(:focus-within) {
//        border-color: rgba(135, 115, 200, 0.4) !important;
//    }
//
//    /* Reset Input Styles */
//    .fi-input-wrp .fi-input {
//        border: none !important;
//        outline: none !important;
//        box-shadow: none !important;
//        ring: 0 !important;
//        background: transparent !important;
//    }
//
//    /* Modern Card & Section Styling */
//    .fi-section {
//        background: rgba(255, 255, 255, 0.3) !important;
//        (12px) !important;
//        --(12px) !important;
//        border: 1px solid rgba(218,218,218,0.34) !important;
//        border-radius: 10px !important;
//        box-shadow: 0 4px 24px -1px rgba(0,0,0,0.02) !important;
//        overflow: hidden !important;
//
//    }
//
//
//
//.gap-x-3 {
//    -moz-column-gap: .75rem;
//    column-gap: 0.90rem !important;
//}
//
//    .fi-section-content-ctn{
//    box-shadow: none;
//    }
//
//    .language-switch-trigger{
//
//    --tw-ring-opacity: 0 !important;
//
//   }
//
//            .fi-user-menu {
//            border-radius: 8px !important;
//            }
//
//    .fi-section-header{
//    margin: 15px;
//    }
//
//
//    /* Section Content Container */
//    .fi-section-content {
//        background: transparent !important;
//    }
//
//    /* Account Widget Specific */
//    .fi-account-widget {
//        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
//    }
//
//    .fi-account-widget:hover {
//        transform: translateY(-2px) !important;
//    }
//
//    /* Avatar Container */
//    .fi-avatar {
//        border: 2px solid rgba(135, 115, 200, 0.2) !important;
//        background: rgba(255, 255, 255, 0.9) !important;
//    }
//
//    /* Text Styling */
//    .fi-section h2 {
//        color: rgba(70, 55, 145, 0.9) !important;
//        font-weight: 600 !important;
//    }
//
//    .fi-section p {
//        color: rgba(70, 55, 145, 0.7) !important;
//    }
//
//    /* Inner Content */
//    .fi-section-content-ctn {
//        background: transparent !important;
//    }
//
//    /* Remove Default Ring */
//    .ring-gray-950\/5 {
//        --tw-ring-color: rgb(159 159 159 / 19%) !important;
//    }
//
//    /* Sign Out Button */
//    .fi-section .fi-btn {
//        background: rgba(255, 255, 255, 0.2) !important;
//        border: 1px solid rgba(135, 115, 200, 0.2) !important;
//        (8px) !important;
//        --(8px) !important;
//        transition: all 0.2s ease !important;
//    }
//
//    .fi-section .fi-btn:hover {
//        background: rgba(255, 255, 255, 0.3) !important;
//        border-color: rgba(135, 115, 200, 0.3) !important;
//        transform: translateY(-1px) !important;
//    }
//
//    /* Icon Button */
//    .fi-icon-btn {
//        background: rgba(255, 255, 255, 0.15) !important;
//        border: 1px solid rgba(135, 115, 200, 0.1) !important;
//    }
//
//    .fi-icon-btn:hover {
//        background: rgba(255, 255, 255, 0.25) !important;
//    }
//
//    .hover\:bg-gray-100:hover{
//        background-color: rgb(255 255 255 / 62%) !important;
//    }
//
//    nav{
//    background: transparent !important;
//    box-shadow: none !important;
//    }
//
//    .fi-sidebar-header{
//    background: transparent !important;
//    box-shadow: none !important;
//
//    }
//    .fi-logo{
//     color: rgb(119 100 191) !important;
//    }
//
//    /* Add these new styles for the dropdown */
//.choices__list--dropdown {
//    background: rgba(255, 255, 255, 0.98) !important;
//    border: 1px solid rgba(135, 115, 200, 0.2) !important;
//    border-radius: 8px !important;
//    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
//    z-index: 999 !important;
//    margin: 8px !important;
//    position: relative !important;
//}
//
//.choices__list--dropdown .choices__item {
//    padding: 8px 12px !important;
//    color: var(--color-text) !important;
//}
//
//.choices__list--dropdown .choices__item--selectable:hover {
//    background: rgba(135, 115, 200, 0.1) !important;
//}
//
//
//.choices__list--dropdown, .choices__list[aria-expanded]{
//width: auto !important;
//}
///* Fix for dropdown visibility */
//.choices {
//    z-index: 999 !important;
//    position: relative !important;
//}
//
//
//
//                    </style>
//
//                ')
//            ->renderHook(
//                'panels::styles.after',
//                fn (): string => '
//            <style>
//            /* Secondary/Cancel/Back Buttons */
//.fi-btn.fi-btn-color-gray,
//.fi-btn.fi-color-gray {
//    background: rgba(255, 255, 255, 0.3) !important;
//    -filter: blur(8px) !important;
//    -it--filter: blur(8px) !important;
//    border: 1px solid rgba(108, 131, 173, 0.2) !important;  /* Using secondary color */
//    color: #6c83ad !important;  /* Secondary color */
//    box-shadow: 0 2px 4px rgba(108, 131, 173, 0.05) !important;
//    font-weight: 500 !important;
//}
//
///* Hover State */
//.fi-btn.fi-btn-color-gray:hover,
//.fi-btn.fi-color-gray:hover {
//    background: rgba(255, 255, 255, 0.4) !important;
//    border-color: rgba(108, 131, 173, 0.3) !important;
//}
//
///* Active/Pressed State */
//.fi-btn.fi-btn-color-gray:active,
//.fi-btn.fi-color-gray:active {
//    background: rgba(255, 255, 255, 0.35) !important;
//    box-shadow: 0 2px 4px rgba(108, 131, 173, 0.1) !important;
//}
//
///* Icon in Button */
//.fi-btn.fi-btn-color-gray .fi-btn-icon,
//.fi-btn.fi-color-gray .fi-btn-icon {
//    color: rgba(108, 131, 173, 0.7) !important;
//    opacity: 0.9 !important;
//}
//
///* Focus State */
//.fi-btn.fi-btn-color-gray:focus-visible,
//.fi-btn.fi-color-gray:focus-visible {
//    outline: none !important;
//    box-shadow: 0 0 0 2px white, 0 0 0 4px rgba(108, 131, 173, 0.2) !important;
//}
//
///* Loading State */
//.fi-btn.fi-btn-color-gray[wire\:loading],
//.fi-btn.fi-color-gray[wire\:loading] {
//    opacity: 0.7 !important;
//    cursor: wait !important;
//}
//
///* Checked State (if needed) */
//[input:checked+.fi-btn.fi-btn-color-gray],
//[input:checked+.fi-btn.fi-color-gray] {
//    background: rgba(108, 131, 173, 0.2) !important;
//    color: #6c83ad !important;
//    border-color: rgba(108, 131, 173, 0.3) !important;
//}
//
//.fi-user-menu{
// background-color: rgba(255,255,255,0.56);
//                        padding: 1px;
//                        border-radius: 35px;
//                        border: 4px solid rgba(255,255,255,0.53);
//}
//
//  /* Pagination Container */
//    .fi-pagination {
//        display: flex !important;
//        justify-content: center !important;
//        align-items: center !important;
//        gap: 1rem !important;
//        padding: 1rem !important;
//    }
//
//    /* Pagination Items Container */
//    .fi-pagination-items {
//        display: flex !important;
//        justify-content: center !important;
//        margin: 0 auto !important;
//    }
//
//    /* Overview Text */
//    .fi-pagination-overview {
//        text-align: center !important;
//        width: auto !important;
//        flex: 0 0 auto !important;
//    }
//
//    /* Per Page Select */
//    .fi-pagination-records-per-page-select {
//        margin: 0 1rem !important;
//    }
//
//    /* Fix the grid layout */
//    .grid.grid-cols-\[1fr_auto_1fr\] {
//        display: flex !important;
//        justify-content: center !important;
//        align-items: center !important;
//        gap: 1rem !important;
//    }
//
//    /* Navigation Buttons */
//    .fi-pagination-next-btn,
//    .fi-pagination-previous-btn {
//        position: relative !important;
//        transform: none !important;
//    }
//
//    /* Center align the records per page dropdown */
//    .col-start-2 {
//        display: flex !important;
//        justify-content: center !important;
//        align-items: center !important;
//        margin: 0 auto !important;
//    }
//
//    /* Remove default grid positioning */
//    .justify-self-end,
//    .justify-self-start {
//        justify-self: auto !important;
//    }
//
//    /* Container adjustments */
//    .fi-ta-pagination {
//        display: flex !important;
//        flex-direction: row !important;
//        justify-content: center !important;
//        align-items: center !important;
//        gap: 1rem !important;
//        padding: 1rem !important;
//        flex-wrap: wrap !important;
//    }
//
//    /* Make items wrap on mobile */
//    @media (max-width: 640px) {
//        .fi-ta-pagination {
//            flex-direction: column !important;
//            gap: 0.75rem !important;
//        }
//
//        .fi-pagination-items {
//            order: 2 !important;
//        }
//    }
//
//    .fi-ta-filters-dropdown{
//    margin-right: 10px !important;
//    }
//
//
//    }
//     .fi-fo-repeater-item  {
//            border-width: 0.5px;
//            }
//            </style>
//                ')
//            ->font('Inter')
//            ->brandName('Ali Cafe System')
//            ->renderHook(
//                'panels::main.start',  // 👈 Changed from body to main
//                fn (): string => '
//                <style>
//                    .fi-ac-btn-action .fi-fo-actions  {
//                        margin-top: 100px !important;
//                    }
//
//
//
//                </style>
//               '
//            )
//            ->renderHook(
//                'panels::head.end',
//                fn () => new HtmlString('
//                <style>
//                    /* Make validation errors more prominent */
//                   /* Maximum specificity override */
//                    html body .fi-fo-field-wrp-error-message,
//                    html body .fi-fo-field-wrp-error-message[class*="text-"],
//                    .fi-fo-field-wrp-error-message.text-danger-600,
//                    .dark .fi-fo-field-wrp-error-message.text-danger-400,
//                    [data-validation-error].fi-fo-field-wrp-error-message {
//                        color: rgb(220, 38, 38) !important;
//                        color: #DC2626 !important;
//                        --tw-text-opacity: 1 !important;
//                        font-weight: 600 !important;
//                        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
//                    }
//
//                    /* Use CSS custom property override */
//                    :root {
//                        --fi-error-color: rgb(220, 38, 38) !important;
//                    }
//
//                    /* Additional forceful overrides */
//                    .fi-fo-field-wrp-error-message {
//                        color: var(--fi-error-color) !important;
//                        -webkit-text-fill-color: rgb(220, 38, 38) !important;
//                    }
//
//                    /* Force override for any potential color transitions */
//                    .fi-fo-field-wrp-error-message * {
//                        color: inherit !important;
//                    }
//
//                    /* Override dark mode specifically */
//                    @media (prefers-color-scheme: dark) {
//                        .fi-fo-field-wrp-error-message {
//                            color: rgb(248, 113, 113) !important;
//                            -webkit-text-fill-color: rgb(248, 113, 113) !important;
//                        }
//                    }
//                    /* Add shake animation for errors */
//                    @keyframes shake {
//                        10%, 90% {
//                            transform: translate3d(-1px, 0, 0);
//                        }
//
//                        20%, 80% {
//                            transform: translate3d(2px, 0, 0);
//                        }
//
//                        30%, 50%, 70% {
//                            transform: translate3d(-4px, 0, 0);
//                        }
//
//                        40%, 60% {
//                            transform: translate3d(4px, 0, 0);
//                        }
//                    }
//
//                    /* Error state for inputs */
//                    .has-error .fi-input-wrp {
//                        border-color: rgb(220, 38, 38) !important;
//                        box-shadow: 0 0 0 1px rgb(220, 38, 38) !important;
//                    }
//
//                    /* Danger text overrides */
//                    .text-danger-600 {
//                        color: rgb(220, 38, 38) !important;
//                    }
//
//                    .dark .text-danger-400 {
//                        color: rgb(248, 113, 113) !important;
//                    }
//
//                    .hover\:bg-custom-400\/10:hover {
//    color: white !important;
//    background-color: rgb(90 62 179 / 79%) !important;
//}
//
//  .hover\:bg-custom-400\/10:focus {
//    color: white !important;
//    background-color: rgb(90 62 179 / 79%) !important;
//}
//
// .focus\:bg-custom-400\/10:focus {
//    color: white !important;
//    background-color: rgb(90 62 179 / 79%) !important;
//}
//
// .focus\:bg-custom-400\/10:active {
//    color: white !important;
//    background-color: rgb(90 62 179 / 79%) !important;
//}
//.hover\:bg-custom-400\/10:active {
//    color: white !important;
//    background-color: rgb(90 62 179 / 79%) !important;
//}
//
//
//.fi-dropdown-panel{
//z-index: 9;
//}
//
//.fi-btn-label{
//font-weight: bold;
//}
//
//body{
//font-weight: bold !important;
//}
//
// .fi-btn-icon{
//                    color: white !important;
//                    }
//
//
//                    .fi-badge{
//                        --tw-ring-color :rgba(var(--c-600), 0.3) !important;
//                        font-size: 12px !important;
//                        font-weight: bold !important;
//                    }
//                </style>
//            ')
//            )
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
