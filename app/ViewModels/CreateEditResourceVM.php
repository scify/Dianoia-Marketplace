<?php


namespace App\ViewModels;


use App\Models\Resource\Resource;
use Illuminate\Collections\ItemNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;
use App\Repository\Resource\ResourceTypesLkp;

class CreateEditResourceVM
{
    public Collection $languages;
    public Collection $difficulties;
    public Collection $types;
    public Resource $resource;
    public int $lang_id;

    public function __construct(Collection $languages,
                                Collection $difficulties,
                                Collection $types,
                                Resource $resource,
                                int $lang_id = -1
                )
    {
        $this->languages = $languages;
        $this->difficulties = $difficulties;
        $this->types = $types;
        $this->resource = $resource;
        $this->lang_id = $lang_id;

    }

    public function isEditMode(): bool
    {
        return ($this->resource->id != null);
    }


}
