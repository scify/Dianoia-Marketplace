<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Notifications\AdminNotice;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypesLkp;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ResourceController extends Controller
{

    protected ResourceManager $resourceManager;
    protected UserManager $userManager;

    public function __construct(
        ResourceManager $resourceManager,
        UserManager  $userManager)
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
        return view('exercises.index')->with(
            ['viewModel' =>$viewModel, 'user' => Auth::user()]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function display(Request $request): View
    {
//        $createResourceViewModel = $this->communicationResourceManager->getCreateResourceViewModel();
        $preselectedType = $request->preselect_type_name ?: null;
        $displayResourceViewModel = $this->resourceManager->getDisplayResourcesViewModel([
            'preselect_type_name' => $preselectedType
        ]);
        $displayResourceViewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());
        return view('exercise-page')->with(['viewModel' => $displayResourceViewModel,  'user' => Auth::user()]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $createResourceViewModel = $this->resourceManager->getCreateResourcesViewModel();
        return view('form-new-exercise')->with(['viewModel' => $createResourceViewModel]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:100',
            'image' => 'mimes:jpg,png,jpeg|file|between:3,1000|nullable',
            'pdf' => "required|mimes:pdf|max:10000",
            'type_id' => "required|integer|gt:0",
            'difficulty_id' =>  "required|integer|gt:0",
            'lang' => "required|integer|gt:0",
            'description' => "required|string|max:1000",
            'terms' => "required"
        ]);
        try {
            $resource = $this->resourceManager->storeResource($request);
            return redirect()->route('resources.display')->with('flash_message_success','The exercise has been successfully created');
        } catch (Exception $e) {
            return redirect()->route('resources.display')->with('flash_message_failure','Failure - the exercise has not been created');
        }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse#after submit, (action-route submit button directs here)
    {
        $this->validate($request, [
            'name' => 'string|max:100',
            'image' => 'mimes:jpg,png|file|between:3,1000|nullable',
            'type_id' => 'required'
        ]);


//        $id = intval($request->id);
        $type_id = intval($request->type_id);
        if ($type_id === ResourceTypesLkp::COMMUNICATION) {
            $this->validate($request, ['sound' => 'mimes:mp3|file|between:10,2000|nullable']);
            $ret_route = "patient_resources.edit";
        } else if (in_array($type_id, [
            ResourceTypesLkp::SIMILAR_GAME,
            ResourceTypesLkp::TIME_GAME,
            ResourceTypesLkp::RESPONSE_GAME
        ])) {
            $ret_route = "carer_resources.edit";
        } else {
            throw(new \ValueError("Type not supported"));
        }
        try {
            $ret = $this->resourceManager->updateResource($request, $id);
            #$redirect_id = $ret['resource_parent_id'] ?: $ret->id;
            #$resourcePackage = $this->resourcesPackageManager->getResourcesPackage ();
            #return redirect()->route($ret_route, $resourcePackage->id)->with('flash_message_success', 'The resource package has been successfully updated');
            return redirect()->back()->with('flash_message_success', 'The resource package has been successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'The resource package has not been updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */

    public function destroy(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->resourceManager->destroyResource($id);
            return redirect()->back()->with('flash_message_success', 'Success! The resource has been deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! The resource has not been deleted');
        }

        //
        #Manager get id of card
        #Manager calls repository
    }


    public function submit(int $id): \Illuminate\Http\RedirectResponse
    {
        return $this->approve($id); //TODO: uncomment to enable pending package approval by admin
        $package = $this->resourcesPackageManager->getResourcesPackage($id);
        $redirect_route = $package->type_id===ResourceTypesLkp::COMMUNICATION ? 'patient_resources.index' : 'carer_resources.index';
        $admins = $this->userManager->get_admin_users();
        $coverResourceCardName = $this->resourceManager->getResource($package->card_id)->name;
        Notification::send($admins, new AdminNotice($package, $coverResourceCardName));

        try {
            $this->resourcesPackageManager->submitResourcesPackage($id);
            return redirect()->route($redirect_route)->with('flash_message_success', 'Success! The resource package has been submitted');

        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! The resource package has not been submitted');
        }

        //
        #Manager get id of card
        #Manager calls repository
    }


    public function approve(int $id):\Illuminate\Http\RedirectResponse{
        $package = $this->resourcesPackageManager->getResourcesPackage($id);
        $redirect_route = $package->type_id===ResourceTypesLkp::COMMUNICATION ? 'patient_resources.index' : 'carer_resources.index';
        try {
            $this->resourcesPackageManager->approveResourcesPackage($id);
            return redirect()->route($redirect_route)->with('flash_message_success', 'Success! The resource package has been approved');

        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! The resource package has not been approved');
        }
    }

    public function reject(Request $request):\Illuminate\Http\RedirectResponse{
        $data = $request->all();
        $package = $this->resourcesPackageManager->getResourcesPackage($data['id']);
        $rejectionMessage = $data['rejection_message'];
        $redirect_route = $package->type_id===ResourceTypesLkp::COMMUNICATION ? 'patient_resources.index' : 'carer_resources.index';

        try {
            $this->resourcesPackageManager->rejectResourcesPackage($data['id']);
            return redirect()->route($redirect_route)->with('flash_message_success', 'Success! The resource package has been rejected');

        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! The resource package has not been rejected');
        }
    }



    public function my_profile()
    {
        try {
            $viewModel = $this->resourceManager->getDisplayResourcesViewModel([
                'preselect_type_name' => null
            ]);
            $viewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());
            $viewModel->user_id_to_get_content = Auth::id();
            $viewModel->resourcesPackagesStatuses = [ResourceStatusesLkp::APPROVED];
            $viewModel->isAdmin = $this->userManager->isAdmin(Auth::user());
            return view('profile-page')->with(['viewModel' => $viewModel,  'user' => Auth::user()]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getResources(Request $request)
    {
        $user_id = null;
        if ($request->user_id_to_get_content) {
            $user_id = intval($request->user_id_to_get_content);
        }
        $status_ids = explode(',', $request->status_ids);
        $type_ids = null;
        if($request->type_ids){
            $type_ids = explode(',', $request->type_ids);
        }
        $difficulties = explode(',', $request->difficulties);
        $ratings = explode(',', $request->ratings);
        return $this->resourceManager->getResources(
            $request->lang_id,
            $user_id,
            $status_ids,
            $difficulties,
            $type_ids,
            $ratings
        );
    }


    public function approve_pending_packages()
    {
        try {
            $userId = Auth::id();
            $adminIds = $this->userManager->get_admin_users()->map(
                function($admin){
                    return $admin->id;
                }
            );

            if(!$adminIds->contains($userId)){
                return response('Unauthorized.', 401);
            }


            $viewModel = $this->carerResourcesPackageManager->getCarerResourcesPackageIndexPageVM();

            $viewModel->resourcesPackagesStatuses = [ResourceStatusesLkp::CREATED_PENDING_APPROVAL];
            $viewModel->user_id_to_get_content = null;

            $viewModel->isAdmin = $this->userManager->isAdmin(Auth::user());
            return view('resources_packages.approve-pending-packages')->with(
                ['viewModel' => $viewModel, 'user' => Auth::user()]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function delete_package($package_id)
    {
        try {
            $this->resourcesPackageManager->destroyResourcesPackage($package_id);
        }
        catch (ModelNotFoundException $e) {
            abort(404);
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! The resource package has not been deleted');
        }
        return redirect()->back()->with('flash_message_success',  'Success! The resource package has been deleted');
    }


    public function clone_package($package_id){

        $package = $this->resourcesPackageManager->getResourcesPackage($package_id);
        $resource = $this->resourceManager->cloneResource($package->card_id, null);
        return redirect()->route("resources.edit",$resource->id)->with('flash_message_success',  'Success! The resource package has been copied');
    }



    public function getContentLanguages()
    {
        return $this->resourceManager->getContentLanguagesForResources();
    }


    public function getContentTypes()
    {
        $ret = $this->resourceManager->getResourceTypes();
        return $ret;
    }

    public function getContentDifficulties()
    {
        $ret = $this->resourceManager->getDifficultiesForResources();
        return $ret;
    }

    public function getUsers()
    {
        $ret = $this->userManager->getUsers();
        return $ret;
    }



}
