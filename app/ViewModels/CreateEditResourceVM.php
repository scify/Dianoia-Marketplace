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
    public String $preselect_types;
    public Resource $resource;
    public String $lang;

    public function __construct(Collection $languages,
                                Collection $difficulties,
                                Collection $types,
                                String $preselectTypes,
                                Resource $resource,
                                String $lang
                )
    {
        $this->languages = $languages;
        $this->difficulties = $difficulties;
        $this->types = $types;
        $this->resource = $resource;
        $this->preselect_types = $preselectTypes;
        $this->lang = $lang;

    }

    public function isEditMode(): bool
    {
        return ($this->resource->id != null);
    }


}
