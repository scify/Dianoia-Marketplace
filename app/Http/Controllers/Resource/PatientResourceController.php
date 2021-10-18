<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\PatientResourcesPackageManager;
use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypesLkp;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class PatientResourceController extends Controller
{

    protected ResourceManager $resourceManager;
    protected UserManager  $userManager;
    public function __construct(ResourceManager $resourceManager,  UserManager  $userManager)
    {
        $this->resourceManager = $resourceManager;
        $this->userManager = $userManager;
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $viewModel = Collection::empty();
        $viewModel->resourcesPackagesStatuses = [ResourceStatusesLkp::APPROVED];
        $viewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());

        return view('patient_resources.index')->with(
            ['viewModel' =>$viewModel, 'user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {

//        $createResourceViewModel = $this->patientResourceManager->getCreateResourceViewModel();
        $createResourcesPackageViewModel = $this->patientResourcesPackageManager->getCreateResourcesPackageViewModel();
        return view('patient_resources.create-edit')->with(['viewModel' => $createResourcesPackageViewModel]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:100',
            'sound' => 'mimes:mp3|required|file|between:5,2000|nullable',
            'image' => 'mimes:jpg,png,jpeg|required|file|between:5,2000|nullable'
        ]);


        try {

            $resource = $this->resourceManager->storeResource($request);
            if ($resource->resource_parent_id === null) {
                $resourcePackage = $this->patientResourcesPackageManager->storeResourcePackage($resource, $request['lang']);
            } else {
                #$resourcePackage = $this->patientResourcesPackageManager->getResourcesPackage($resource->resource_parent_id);
                $resourcePackage = $this->patientResourcesPackageManager->getResourcesPackageWithCoverCard($resource->resource_parent_id);
            }
            $redirect_id = $resourcePackage->id;
            return redirect()->route('patient_resources.edit', $redirect_id)->with('flash_message_success', 'The resource package has been successfully created');
        } catch (Exception $e) {
            return redirect()->with('flash_message_failure', 'Failure - resource card has not been added');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)#returns view
    {

        try {
//            $createResourceViewModel = $this->patientResourceManager->getEditResourceViewModel($id);
            $package = $this->patientResourcesPackageManager->getResourcesPackage($id);
            $createResourceViewModel = $this->patientResourcesPackageManager->getEditResourceViewModel($package->card_id, $package);
            return view('patient_resources.create-edit')->with(['viewModel' => $createResourceViewModel]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function download_package(int $id): View
    {
        try {
            $package = $this->patientResourcesPackageManager->getResourcesPackage($id);
            $this->patientResourcesPackageManager->downloadPackage($package);
            return $this->show_packages();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function getPatientResourcePackages(Request $request)
    {
        $user_id = null;
        if ($request->user_id_to_get_content) {
            $user_id = intval($request->user_id_to_get_content);
        }
        $status_ids = explode(',', $request->status_ids);
        return $this->patientResourcesPackageManager->getResourcesPackages(
            $request->lang_id,
            $user_id,
            [ResourceTypesLkp::COMMUNICATION],
            $status_ids
        );
    }
}


