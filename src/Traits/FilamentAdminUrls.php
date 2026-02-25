<?php

namespace Athphane\FilamentSupport\Traits;

use Filament\Facades\Filament;
use Filament\Resources\Resource;

trait FilamentAdminUrls
{
    /*
     * Get the admin URL for the model record.
     *
     * @return string|null
     */
    public function getAdminUrl(string $action = 'edit'): ?string
    {
        // Return null if Model specifies not to generate admin URLs
        if ($this->disableAdminUrlGeneration()) {
            return null;
        }

        /** @var ?resource $modelResource */
        $modelResource = Filament::getModelResource($this);

        // If the model resource is not registered, return null
        if (! $modelResource) {
            return null;
        }

        return $modelResource::getUrl($action, ['record' => $this]);
    }

    /**
     * Disable admin URL generation for the Model.
     */
    public function disableAdminUrlGeneration(): bool
    {
        return false;
    }
}
