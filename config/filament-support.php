<?php

return [
    'modifiers' => [
        'forms' => env('FILAMENT_SUPPORT_MODIFIER_FORMS', true),
        'actions' => env('FILAMENT_SUPPORT_MODIFIER_ACTIONS', true),
        'tables' => env('FILAMENT_SUPPORT_MODIFIER_TABLES', true),
        'infolists' => env('FILAMENT_SUPPORT_MODIFIER_INFOLISTS', true),
        'summarizers' => env('FILAMENT_SUPPORT_MODIFIER_SUMMARIZERS', true),
    ],
];
