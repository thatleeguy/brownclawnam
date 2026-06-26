<?php

namespace App\Support;

class Media
{
    /**
     * Resolve an image reference to a URL.
     *
     * - absolute URLs / root-relative paths are returned as-is
     * - files that exist in /public (committed assets like img/connor.jpg,
     *   favicon.png) are served via asset()
     * - everything else is treated as an admin upload living in shared storage
     *   and served through the /media route (persists across deploys, https-safe)
     */
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return url('/media/' . ltrim($path, '/'));
    }
}
