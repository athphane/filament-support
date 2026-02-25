<?php

namespace Athphane\FilamentSupport\Forms\Components;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload as BaseSpatieFileUpload;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SpatieMediaLibraryFileUpload extends BaseSpatieFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        // Configure visibility correctly from media library disk config
        $this->visibility(function () {
            $media_disk = config('media-library.disk_name');

            return config("filesystems.disks.{$media_disk}.visibility", 'private');
        });

        // Set disk to the media library disk unless visibility is private
        $this->disk($this->getCustomVisibility() === 'private' ? null : config('media-library.disk_name'));
    }

    public function getCollection(): ?string
    {
        return $this->evaluate($this->getName());
    }

    public function getUploadedFileNameForStorage(TemporaryUploadedFile $file): string
    {
        if (str($file->getClientOriginalName())->length() >= 26) {
            return Str::ulid().'.'.$file->getClientOriginalExtension();
        }

        return $file->getClientOriginalName();
    }
}
