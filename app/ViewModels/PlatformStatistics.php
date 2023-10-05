<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;

class PlatformStatistics {
    public Collection $generalPlatformStatistics;

    public Collection $resourcesPerTypeStatistics;

    public Collection $resourcesPerUserStatistics;

    /**
     * @param Collection $generalPlatformStatistics
     * @param Collection $resourcesPerTypeStatistics
     * @param Collection $resourcesPerUserStatistics
     */
    public function __construct(Collection $generalPlatformStatistics,
        Collection $resourcesPerTypeStatistics,
        Collection $resourcesPerUserStatistics) {
        $this->generalPlatformStatistics = $generalPlatformStatistics;
        $this->resourcesPerTypeStatistics = $resourcesPerTypeStatistics;
        $this->resourcesPerUserStatistics = $resourcesPerUserStatistics;
    }
}
