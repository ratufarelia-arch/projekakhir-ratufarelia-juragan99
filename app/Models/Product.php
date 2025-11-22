<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'cut_type',
        'description',
        'price',
        'discount',
        'weight',
        'weight_variant',
        'cooking_tips',
        'stock',
        'image_path',
        'image_disk',
        'halal_certified',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
        'halal_certified' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $disk = $this->image_disk ?: config('filesystems.default');
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk($disk);
        $url = $storage->url($this->image_path);

        return $this->normalizeStorageUrl($url, $disk);
    }

    protected function normalizeStorageUrl(string $url, string $disk): string
    {
        $driver = config("filesystems.disks.{$disk}.driver");

        if ($driver !== 'local') {
            return $url;
        }

        return preg_replace('#^https?://[^/]+#', '', $url) ?: $url;
    }
}
