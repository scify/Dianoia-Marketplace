<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\CarerResourcesPackageManager;
use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\Resource\ResourcesPackageManager;
use App\BusinessLogicLayer\Resource\SimilarityCarerResourcesPackageManager;
use App\BusinessLogicLayer\Resource\TimeCarerResourcesPackageManager;
use App\BusinessLogicLayer\Resource\ResponseCarerResourcesPackageManager;

use App\Http\Controllers\Controller;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypesLkp;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\BusinessLogicLayer\User\UserManager;

class CarerResourceController extends Controller {
    protected ResourceTypesLkp $resourceTypesLkp;
    protected SimilarityCarerResourcesPackageManager $similarityCarerResourcesPackageManager;
    protected TimeCarerResourcesPackageManager $timeCarerResourcesPackageManager;
    protected ResponseCarerResourcesPackageManager $responseCarerResourcesPackageManager;
    protected ResourceManager $resourceManager;
    protected ResourcesPackageManager $resourcesPackageManager;
    protected CarerResourcesPackageManager $carerResourcesPackageManager;
    protected UserManager  $userManager;

    public function __construct(
        SimilarityCarerResourcesPackageManager $similarityCarerResourcesPackageManager,
        TimeCarerResourcesPackageManager       $timeCarerResourcesPackageManager,
        ResponseCarerResourcesPackageManager   $responseCarerResourcesPackageManager,
        ResourceManager                       $resourceManager,
        ResourcesPackageManager               $resourcesPackageManager,
        CarerResourcesPackageManager           $carerResourcesPackageManager,
        UserManager  $userManager) {

        $this->resourceManager = $resourceManager;
        $this->resourcesPackageManager = $resourcesPackageManager;
        $this->carerResourcesPackageManager = $carerResourcesPackageManager;
        $this->similarityCarerResourcesPackageManager = $similarityCarerResourcesPackageManager;
        $this->responseCarerResourcesPackageManager = $responseCarerResourcesPackageManager;
        $this->timeCarerResourcesPackageManager = $timeCarerResourcesPackageManager;
        $this->userManager = $userManager;
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        $viewModel = $this->carerResourcesPackageManager->getCarerResourcesPackageIndexPageVM();
        $viewModel->resourcesPackagesStatuses = [ResourceStatusesLkp::APPROVED];
        $viewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());
        return view('carer_resources.index')->with(['viewModel' => $viewModel, 'user' => Auth::user()]);
    }


    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): View {

        $this->validate($request, [
            'type_id' => 'required'//TODO check if exists in DB tab
        ]);


        switch (intval($request->type_id)) {
            case ResourceTypesLkp::SIMILAR_GAME:
                $createResourcesPackageViewModel = $this->similarityCarerResourcesPackageManager->getCreateResourcesPackageViewModel();
                $carer = 'SIMILAR';
                break;
            case  ResourceTypesLkp::TIME_GAME:
                $createResourcesPackageViewModel = $this->timeCarerResourcesPackageManager->getCreateResourcesPackageViewModel();
                $carer = 'TIME';
                break;
            case ResourceTypesLkp::RESPONSE_GAME:
                $createResourcesPackageViewModel = $this->responseCarerResourcesPackageManager->getCreateResourcesPackageViewModel();
                $carer = 'RESPONSE';
                break;
            case ResourceTypesLkp::COMMUNICATION:
                throw(new \ValueError('Tried to create patient cards through the carer creation page'));
            default:
                throw(new ResourceNotFoundException('Carer type under development'));
        }
        return view('carer_resources.create-edit-carer')->with(['viewModel' => $createResourcesPackageViewModel, 'carer' => $carer]);

    }


    public function edit(int $package_id)#returns view
    {
        try {
            $package = $this->resourcesPackageManager->getResourcesPackage($package_id);
            switch ($package->type_id) {
                case ResourceTypesLkp::SIMILAR_GAME:
                    $editResourceViewModel = $this->similarityCarerResourcesPackageManager->getEditResourceViewModel($package);
                    $carer = 'SIMILAR';
                    break;
                case  ResourceTypesLkp::TIME_GAME:
                    $editResourceViewModel = $this->timeCarerResourcesPackageManager->getEditResourceViewModel($package);;
                    $carer = 'TIME';
                    break;
                case ResourceTypesLkp::RESPONSE_GAME:
                    $editResourceViewModel = $this->responseCarerResourcesPackageManager->getEditResourceViewModel($package);;
                    $carer = 'RESPONSE';
                    break;
                case ResourceTypesLkp::COMMUNICATION:
                    throw(new \ValueError('Tried to edit patient cards through the carer editing page'));
                default:
                    throw(new ResourceNotFoundException('Carer category not yet implemented'));
            }
            return view('carer_resources.create-edit-carer')->with(['viewModel' => $editResourceViewModel, 'carer' => $carer]);

        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse#after submit, (action-route submit button directs here)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'image' => 'file|between:10,500|nullable'
        ]);
        try {
            $ret = $this->resourceManager->updateResource($request, $id);
            $redirect_id = $ret['resource_parent_id'] ?: $ret->id;
            return redirect()->route('carer_resources.edit', $redirect_id)->with('flash_message_success', 'The resource package has been successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'The resource package has not been updated');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */

    public function download_package(int $id)
    {
        $package = $this->resourcesPackageManager->getResourcesPackage($id);
        try {
            switch ($package->type_id) {
                case ResourceTypesLkp::SIMILAR_GAME:
                    $carerType = "similarityCarer";
                    break;
                case  ResourceTypesLkp::TIME_GAME:
                    $carerType = "sequenceCarer";
                    break;
                case ResourceTypesLkp::RESPONSE_GAME:
                    $carerType = "stimulusReactionCarer";
                    break;
                default:
                    throw(new ResourceNotFoundException('Carer category not yet implemented'));
            }
            $this->resourcesPackageManager->downloadCarerPackage($package, $carerType);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getCarerResourcePackages(Request $request)
    {
        $user_id = null;
        if ($request->user_id_to_get_content) {
            $user_id = intval($request->user_id_to_get_content);
        }
        $type_ids = explode(',', $request->type_ids);
        $status_ids = explode(',', $request->status_ids);
        return $this->resourcesPackageManager->getResourcesPackages(
            $request->lang_id,
            $user_id,
            $type_ids,
            $status_ids
        );
    }

}
