<?php


namespace App\ViewModels;


use App\Models\Resource\Resource;
use App\Models\Resource\ResourcesPackage;
use Illuminate\Collections\ItemNotFoundException;
use Illuminate\Support\Collection;
use PHPUnit\Exception;
use App\Repository\Resource\ResourceTypesLkp;

class CreateEditResourceVM
{
    public Collection $languages;
    public Resource $resource;
    public int $lang_id;
    public int $type_id;

    public function __construct(Collection $languages,
                                Resource $resource,
                                int $lang_id = -1
                )
    {
        $this->languages = $languages;
        $this->resource = $resource;
        $this->lang_id = $lang_id;
    }

    public function ReachedMaximumCardLimit(): bool
    {
        $numCards = sizeof($this->childrenCards);
        return $numCards === $this->maximumCardThreshold;
    }

    public function isEditMode(): bool
    {
        return ($this->resource->id != null);
    }


}
