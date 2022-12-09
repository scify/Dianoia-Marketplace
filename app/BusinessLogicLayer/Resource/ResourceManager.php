<?php

namespace App\BusinessLogicLayer\Resource;

use App\BusinessLogicLayer\Shapes\ShapesIntegrationManager;
use App\Models\Resource\Resource;
use App\Repository\ContentLanguageLkpRepository;
use App\Repository\DifficultiesLkpRepository;
use App\Repository\ReportsRepository;
use App\Repository\Resource\ResourceRepository;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypeLkpRepository;
use App\Repository\Resource\ResourceTypesLkp;
use App\Repository\User\UserRepository;
use App\ViewModels\CreateEditResourceVM;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ResourceManager {
    protected ResourceRepository $resourceRepository;
    protected ContentLanguageLkpRepository $contentLanguageLkpRepository;
    protected DifficultiesLkpRepository $difficultiesLkpRepository;
    protected ResourceTypeLkpRepository $resourceTypeLkpRepository;
    protected ReportsRepository $reportsRepository;
    protected UserRepository $userRepository;
    protected ShapesIntegrationManager $shapesIntegrationManager;

    public function __construct(ResourceRepository           $resourceRepository,
                                ContentLanguageLkpRepository $contentLanguageLkpRepository,
                                DifficultiesLkpRepository    $difficultiesLkpRepository,
                                ResourceTypeLkpRepository    $resourceTypeLkpRepository,
                                ReportsRepository            $reportsRepository,
                                UserRepository               $userRepository,
                                ShapesIntegrationManager     $shapesIntegrationManager
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->contentLanguageLkpRepository = $contentLanguageLkpRepository;
        $this->difficultiesLkpRepository = $difficultiesLkpRepository;
        $this->resourceTypeLkpRepository = $resourceTypeLkpRepository;
        $this->reportsRepository = $reportsRepository;
        $this->userRepository = $userRepository;
        $this->shapesIntegrationManager = $shapesIntegrationManager;
    }

    public function getCreateResourcesViewModel(): CreateEditResourceVM {
        $contentLanguages = $this->getContentLanguagesForResources();
        $difficulties = $this->getDifficultiesForResources();
        $types = $this->getResourceTypes();
        $lang = app()->getLocale();

        return new CreateEditResourceVM(
            $contentLanguages, $difficulties, $types, collect(), new  Resource(), $lang
        );
    }

    public function getDisplayResourcesViewModel(array $resource_params = []): CreateEditResourceVM {
        $contentLanguages = $this->getContentLanguagesForResources();
        $difficulties = $this->getDifficultiesForResources();
        $lang = app()->getLocale();
        $types = $this->getResourceTypes();

        $type_ids = $types->map(
            function ($type_entry) {
                return $type_entry->id;
            }
        );
        $preselect_types = $resource_params['preselect_type_name'] ?: 'all';

        return new CreateEditResourceVM(
            $contentLanguages, $difficulties, $type_ids, $preselect_types, new  Resource($resource_params), $lang
        );
    }

    public function getEditResourcesViewModel(Resource $resource): CreateEditResourceVM {
        $contentLanguages = $this->getContentLanguagesForResources();
        $difficulties = $this->getDifficultiesForResources();
        $types = $this->getResourceTypes();
        $lang = app()->getLocale();

        return new CreateEditResourceVM(
            $contentLanguages, $difficulties, $types, collect(), $resource, $lang
        );
    }

    public function getResourceTypes() {
        $ret = $this->resourceTypeLkpRepository->all();

        return $ret;
    }

    public function getDifficultiesForResources() {
        return $this->difficultiesLkpRepository->all();
    }

    public function getContentLanguagesForResources() {
        return $this->contentLanguageLkpRepository->all();
    }

    public function getResource($id) {
        return $this->resourceRepository->find($id);
    }

    public function getResources(int $lang_id = null, $user_id = null, array $status_ids = [], array $difficulties = null, array $type_ids = null, array $ratings = null) {
        if ($status_ids == []) {
            $status_ids = [ResourceStatusesLkp::APPROVED];
        }

        return $this->resourceRepository->getResources($user_id, $lang_id, $status_ids, $difficulties, $type_ids, $ratings);
    }

    public function rejectResource($id) {
        return $this->resourceRepository->update(['status_id' => ResourceStatusesLkp::REJECTED], $id);
    }

    public function approveResource($id) {
        return $this->resourceRepository->update(['status_id' => ResourceStatusesLkp::APPROVED], $id);
    }


    public function storeResource(Request $request) {
        $storeArr = [
            'name' => $request['name'],
            'slug' => null,
            'lang_id' => $request['lang'],
            'img_path' => null,
            'pdf_path' => null,
            'type_id' => $request['type_id'],
            'difficulty_id' => $request['difficulty_id'],
            'status_id' => ResourceStatusesLkp::CREATED_PENDING_APPROVAL,
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null,
            'description' => $request['description'],
        ];

        $resource = $this->resourceRepository->create($storeArr);
        $resourceFileManager = new ResourceFileManager();
        try {
            $img_path = $resourceFileManager->saveImage($resource->id, $request);
        } catch (FileNotFoundException $e) {
            $img_path = null;
        }
        try {
            $pdf_path = $resourceFileManager->savePdf($resource->id, $request);
        } catch (FileNotFoundException $e) {
            $pdf_path = null;
        }

        $user = $this->userRepository->find(Auth::id());
        if ($user->shapes_auth_token && ShapesIntegrationManager::isEnabled()) {
            $resourceType = $this->resourceTypeLkpRepository->find($request['type_id']);
            $this->shapesIntegrationManager->sendUsageDataToDatalakeAPI($user, 'resource_created', $resourceType->name);
        }

        return $this->resourceRepository->update([
            'img_path' => $img_path,
            'pdf_path' => $pdf_path, ],
            $resource->id);
    }

    /**
     * @throws FileNotFoundException
     */
    public function updateResource($request, $id) {
        $storeArr = [
            'name' => $request['name'],
            'slug' => $request['slug'],
            'description' => $request['description'],
            'lang_id' => $request['lang'],
            'type_id' => $request['type_id'],
            'difficulty_id' => $request['difficulty_id'],
            'status_id' => $request['status_id'],
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null,
        ];
        $old_resource = $this->resourceRepository->find($id);
        $storeArr['img_path'] = $old_resource['img_path'];
        $storeArr['pdf_path'] = $old_resource['pdf_path'];
        $resource = $this->resourceRepository->update($storeArr, $id);
        $resourceFileManager = new ResourceFileManager();
        if (isset($request['image'])) {
            $resourceFileManager->deleteResourceImage($old_resource);
            $img_path = $resourceFileManager->saveImage($resource->id, $request);
            $resource = $this->resourceRepository->update([
                'img_path' => $img_path, ],
                $resource->id);
        }
        if (isset($request['pdf'])) {
            $resourceFileManager->deleteResourcePdf($old_resource);
            $pdf_path = $resourceFileManager->savePdf($resource->id, $request);
            $resource = $this->resourceRepository->update([
                'pdf_path' => $pdf_path, ],
                $resource->id);
        }

        return $resource;
    }

    public function reportResource($id, $reporting_user_id, $reportReason, $reportComment) {
        $storeArr = [
            'resource_id' => $id,
            'reporting_user_id' => $reporting_user_id,
            'reason' => $reportReason,
            'comment' => $reportComment,
        ];

        return $this->reportsRepository->create($storeArr);
    }

    public function destroyResource($id) {
        $resource = $this->resourceRepository->find($id);
        $resourceFileManager = new ResourceFileManager();
        $resourceFileManager->deleteResourceAudio($resource);
        $resourceFileManager->deleteResourceImage($resource);
        $this->resourceRepository->delete($id);
    }

    public function cloneResource($id, $newParentId) {
        $resource = $this->resourceRepository->find($id);
        $fileManager = new ResourceFileManager();
        $storeArr = [
            'name' => $resource->name,
            'img_path' => $fileManager->cloneResourceToDirectory(basename($resource->img_path), 'image'),
            'audio_path' => $resource->audio_path ? $fileManager->cloneResourceToDirectory(basename($resource->audio_path), 'audio') : null,
            'resource_parent_id' => $newParentId ?: null,
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null,
        ];

        return $this->resourceRepository->create($storeArr);
    }

    public function storeOrUpdateAverageResourceRating($id, $avg_rating) {
        return $this->resourceRepository->update([
            'avg_rating' => $avg_rating, ],
            $id);
    }

    public function getTransformExercisesForMobileApp($paginated) {
        $transformed = $paginated->through(function ($exercise) {
            $keys = array_keys($exercise->toArray());
            $exercise['slug'] = $exercise->slug;
            $exercise['title'] = $exercise->name;
            $exercise['description'] = $exercise->description;

            switch ($exercise->type_id) {
                case ResourceTypesLkp::ATTENTION:
                    $exercise['category'] = 'focus_activities';
                    break;
                case ResourceTypesLkp::MEMORY:
                    $exercise['category'] = 'memory_activities';
                    break;
                case ResourceTypesLkp::REASON:
                    $exercise['category'] = 'think_activities';
                    break;
                case ResourceTypesLkp::EXECUTIVE:
                    $exercise['category'] = 'executive_activities';
                    break;
                case ResourceTypesLkp::CARER:
                    $exercise['category'] = 'carer_activities';
                    break;
                case ResourceTypesLkp::STORIES:
                    $exercise['category'] = 'stories';

                default:
                    $exercise['category'] = '';
            }

            $exercise['full_text'] = '';
            $exercise['video_url'] = '';
            $exercise['image_url'] = $exercise->img_path == null ? '' : $exercise->img_path;
            $exercise['instructions'] = ['Κάντε click στο σύνδεσμο για να δείτε το έγγραφο'];
            $exercise['link'] = config('app.url') . '/storage/' . $exercise->pdf_path;
            $exercise['difficulty_level'] = 'difficulty_level_' . ($exercise->difficulty_id + 1);
            $exercise['created_by'] = $this->resourceRepository->where(
                ['id' => $exercise->id], ['*'], ['creator'])->first()->creator->name;
            $exercise['rating'] = $exercise->avg_rating;
            foreach ($keys as $key) {
                if ($key != 'slug' and $key != 'description') {
                    unset($exercise[$key]);
                }
            }

            return $exercise;
        })->toArray();
        $transformed['data'] = array_values(array_filter($transformed['data']));

        return $transformed;
    }

    public function getPaginatedResourcesForMobile($requestLanguage = null, $requestCategory = null) {
        $whereArray = [
            'lang_id' => null,
            'type_id' => null,
        ];

        if ($requestLanguage) {
            $contentLanguages = $this->getContentLanguagesForResources();
            foreach ($contentLanguages as $lang) {
                if ($lang->code == $requestLanguage) {
                    $whereArray['lang_id'] = $lang->id;
                    break;
                }
            }
        }
        if ($requestCategory) {
            switch ($requestCategory) {
                case 'focus_activities':
                    $whereArray['type_id'] = [ResourceTypesLkp::ATTENTION];
                    break;
                case 'memory_activities':
                    $whereArray['type_id'] = [ResourceTypesLkp::MEMORY];
                    break;
                case 'think_activities':
                    $whereArray['type_id'] = [ResourceTypesLkp::REASON];
                    break;
                case 'executive_activities':
                    $whereArray['type_id'] = [ResourceTypesLkp::EXECUTIVE];
                    break;
                case 'carer_activities':
                    $whereArray['type_id'] = [ResourceTypesLkp::CARER];
                    break;
                case 'stories':
                    $whereArray['type_id'] = [ResourceTypesLkp::STORIES];
                    break;
                default:
                    throw new InvalidArgumentException('Requested Category Does Not Exist');
            }
        }

        $paginated = $this->resourceRepository->getResources(
            null, $whereArray['lang_id'], null, null, $whereArray['type_id'], null, 10, true);
        $paginated->appends(['lang' => $requestLanguage])->links();
        $paginated->appends(['category' => $requestCategory])->links();

        return $this->getTransformExercisesForMobileApp($paginated);
    }

    public function getReportedExercises() {
        $reports = $this->reportsRepository->all();
        $resourcesWithReportInfo = Collection::empty();
        foreach ($reports as $report) {
            $resource = $this->resourceRepository->find($report->resource_id);
            $resource->reportData = $report;
            $resource->creator = $report->creator;
            $resourcesWithReportInfo->push($resource);
        }

        return $resourcesWithReportInfo;
    }

    public function getResourceBySlug($resources_slug) {
        return $this->resourceRepository->where(['slug' => $resources_slug]);
    }
}
