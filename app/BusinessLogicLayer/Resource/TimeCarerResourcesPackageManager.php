<?php


namespace App\BusinessLogicLayer\Resource;

use App\Models\Resource\Resource;
use App\Models\Resource\ResourcesPackage;
use App\Repository\ContentLanguageLkpRepository;
use App\Repository\Resource\ResourceRepository;
use App\Repository\Resource\ResourcesPackageRepository;
use App\Repository\Resource\ResourceTypeLkpRepository;
use App\Repository\Resource\ResourceTypesLkp;
use App\ViewModels\CreateEditResourceVM;
use App\ViewModels\DisplayPackageVM;
use Illuminate\Support\Collection;

class TimeCarerResourcesPackageManager extends CarerResourcesPackageManager
{
    public ResourcesPackageRepository $resourcesPackageRepository;
    protected ContentLanguageLkpRepository $contentLanguageLkpRepository;
    protected ResourceRepository $resourceRepository;
    const maximumCardsThreshold = 4;
    const type_id = ResourceTypesLkp::TIME_GAME;

    public function __construct(ResourceTypeLkpRepository $resourceTypeLkpRepository,
                                ResourceRepository $resourceRepository,
                                ContentLanguageLkpRepository $contentLanguageLkpRepository,
                                ResourcesPackageRepository $resourcesPackageRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->contentLanguageLkpRepository = $contentLanguageLkpRepository;
        $this->resourcesPackageRepository = $resourcesPackageRepository;
        parent::__construct($resourceTypeLkpRepository, $resourceRepository, $contentLanguageLkpRepository,$resourcesPackageRepository, self::type_id);
    }

    public function getCreateResourcesPackageViewModel(): CreateEditResourceVM
    {
        $contentLanguages = $this->getContentLanguagesForResources();
        return new CreateEditResourceVM($contentLanguages,
            new  Resource(),
            new Collection(),
            new ResourcesPackage(),
            self::maximumCardsThreshold,
            self::type_id);
    }

    public function getEditResourceViewModel($package): CreateEditResourceVM
    {
        $contentLanguages = $this->getContentLanguagesForResources();

        $childrenResourceCards = $this->resourceRepository->getChildrenCardsWithParent($package->card_id);
//        return new CreateParentVM(self::maximumCardsThreshold, self::type_id)

        return new CreateEditResourceVM($contentLanguages,
            $this->resourceRepository->find($package->card_id),
            $childrenResourceCards,
            $package,
            self::maximumCardsThreshold,
            self::type_id);
    }

    public function getApprovedTimeCarerPackagesParentResources(): DisplayPackageVM
    {

        $approvedPatientPackages = $this->resourcesPackageRepository->getResourcesPackages([self::type_id]);
        return new DisplayPackageVM($approvedPatientPackages);

    }

}
