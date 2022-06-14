<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Models\Resource\Resource;
use App\Notifications\AcceptanceNotice;
use App\Notifications\ReportNotice;
use App\Notifications\AdminNotice;
use App\Notifications\RejectionNotice;
use App\Notifications\ReportResponseNotice;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypesLkp;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

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
     * Show the form for creating a new resource.
     *
     * @param int $resource_id
     * @return View
     */
    public function edit(int $resource_id): View
    {
        $resource = $this->resourceManager->getResource($resource_id);
        $editResourceViewModel = $this->resourceManager->getEditResourcesViewModel($resource);
        return view('form-new-exercise')->with(['viewModel' => $editResourceViewModel]);
    }


    /**
     * Show the resources listing page.
     *
     * @param Request $request
     * @return View
     */
    public function display(Request $request): View
    {
        $preselectedType = $request->preselect_type_name ?: null;
        $displayResourceViewModel = $this->resourceManager->getDisplayResourcesViewModel([
            'preselect_type_name' => $preselectedType
        ]);
        $displayResourceViewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());
        $displayResourceViewModel->resourceStatuses = array(
            'accepted' => ResourceStatusesLkp::APPROVED
        );
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
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:100',
            'image' => 'mimes:jpg,png,jpeg|file|between:3,10000|nullable',
            'pdf' => "required|mimes:pdf|max:50000",
            'type_id' => "required|integer|gt:0",
            'difficulty_id' =>  "required|integer|gt:0",
            'lang' => "required|integer|gt:0",
            'description' => "required|string|max:1000",
            'accept-guideline-terms' => "required",
            'accept-privacy-terms' => 'required'
        ]);
        try {
            $request['status_id'] = ResourceStatusesLkp::CREATED_PENDING_APPROVAL;
            $resource = $this->resourceManager->storeResource($request);
            $request['slug'] = Str::slug($request['name'], '_') . '_'. $resource->id;
            $this->resourceManager->updateResource($request, $resource['id']);

            $this->submit($resource);//todo comment to pause exercise submission notifications
            return redirect()->route('resources.my_profile')->with('flash_message_success',__('messages.exercise-submit-success'));
        } catch (Exception $e) {
            return redirect()->route('resources.my_profile')->with('flash_message_failure',__('messages.exercise-submit-failure'));
        }
    }





    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */

    public function update(Request $request, int $id): RedirectResponse#after submit, (action-route submit button directs here)
    {
        $this->validate($request, [
            'name' => 'string|max:100',
            'image' => 'mimes:jpg,png|file|between:3,1000|nullable',
            'pdf' => "mimes:pdf|max:10000|nullable",
            'description' => "string|max:1000",
            'accept-guideline-terms' => "required",
            'accept-privacy-terms' => 'required',
            'type_id' => "required"
        ]);
        try {
            $request['slug'] = Str::slug($request['name'], '_') . '_'. $id;
            $request['status_id'] = ResourceStatusesLkp::CREATED_PENDING_APPROVAL;
            $this->resourceManager->updateResource($request, $id);
            return redirect()->route('resources.my_profile')->with('flash_message_success', __('messages.exercise-update-success'));
        } catch (\Exception $e) {
            return redirect()->route('resources.my_profile')->with('flash_message_failure', __('messages.exercise-update-failure'));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */

    public function delete_exercise(Request $request, int $id): RedirectResponse
    {
        try {
            $this->resourceManager->destroyResource($id);
            return redirect()->back()->with('flash_message_success',  __('messages.exercise-delete-success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure',  __('messages.exercise-delete-failure'));
        }

        //
        #Manager get id of card
        #Manager calls repository
    }


    public function submit($resource): RedirectResponse
    {
        $admins = $this->userManager->get_admin_users();
        Notification::send($admins, new AdminNotice($resource));//Todo when dianoia email for admin has been setup
        try {
            return redirect()->route('resources.display')->with('flash_message_success',  __('messages.exercise-submit-success'));

        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('messages.exercise-submit-failure'));
        }
    }


    public function reject(Request $request): RedirectResponse{
        $data = $request->all();
        $rejectionMessage = $data['rejection_comment'];
        $rejectionReason = $data['rejection_reason'];
        $resource = $this->resourceManager->getResource($data['id']);try {
            $creator = $this->userManager->getUser($resource['creator_user_id']);
            $this->resourceManager->rejectResource($data['id']);
            Notification::send( $creator, new RejectionNotice($resource, $rejectionMessage, $rejectionReason, $creator->name));
            return redirect()->back()->with('flash_message_success',__('messages.exercise-reject-success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('messages.exercise-reject-failure'));
        }

    }


    public function approve(Request $request): RedirectResponse{
        $data = $request->all();
        $resource = $this->resourceManager->getResource($data['id']);try {
            $this->resourceManager->approveResource($data['id']);
            $creator = $this->userManager->getUser($resource['creator_user_id']);
            Notification::send( $creator, new AcceptanceNotice($resource,$creator->name));
            return redirect()->back()->with('flash_message_success', __('messages.exercise-approve-success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('messages.exercise-approve-failure'));
        }
    }

    public function report(Request $request): RedirectResponse{
        $data = $request->all();
        $reportComment = $data['report_comment'];
        $reportReason= $data['report_reason'];
        $resource = $this->resourceManager->getResource($data['id']);
        try {
            $creator = $this->userManager->getUser($resource->creator_user_id);
            $reporter = Auth::user();
            $admins = $this->userManager->get_admin_users();
            $this->resourceManager->reportResource($data['id'], $reporter['id'], $reportReason, $reportComment);
            Notification::send( $admins, new ReportNotice($resource, $reportComment, $reportReason, $creator, $reporter));
            return redirect()->back()->with('flash_message_success','Reported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('Failed to report'));
        }

    }

    public function respond(Request $request): RedirectResponse{
        $data = $request->all();
        $response = $data['response'];
        $resource_name = $data['resource_name'];
        $reporting_user_id = $data['reporting_user_id'];
        try {
            $reporter = $this->userManager->getUser($reporting_user_id);
            Notification::send( $reporter, new ReportResponseNotice($resource_name, $response, $reporter->name));
            return redirect()->back()->with('flash_message_success','Responded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('Failed to report'));
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
            $viewModel->resourceStatuses = array(
                'accepted' => ResourceStatusesLkp::APPROVED,
                'pending' => ResourceStatusesLkp::CREATED_PENDING_APPROVAL,
                'rejected' => ResourceStatusesLkp::REJECTED,
            );
            $user = Auth::user();
            $userRoleMap = $this->userManager->getUserRolesMapping()->filter(
                function ($entry) use ($user) {
                    return $entry->user_id === $user->id;
                }
            );
            $userRoleId = $userRoleMap->first()->role_id;
            if($viewModel->isAdmin ){
                $user->type = $this->userManager->get_admin_users()->filter(
                    function ($entry) use ($userRoleId) {
                        return $entry->id=== $userRoleId;
                    }
                )->first();
            }
            else{
                $user->type = $this->userManager->getUserRoles()->filter(
                    function ($entry) use ($userRoleId) {
                        return $entry->id=== $userRoleId;
                    }
                )->first();
            }
            return view('profile-page')->with(['viewModel' => $viewModel,  'user' => $user]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function manage_exercises()
    {
        try {
            $viewModel = $this->resourceManager->getDisplayResourcesViewModel([
                'preselect_type_name' => null
            ]);
            $viewModel->isAdmin = Auth::check() && $this->userManager->isAdmin(Auth::user());
            $viewModel->user_id_to_get_content = Auth::id();
            $viewModel->resourceStatuses = array(
                'accepted' => ResourceStatusesLkp::APPROVED,
                'pending' => ResourceStatusesLkp::CREATED_PENDING_APPROVAL,
                'rejected' => ResourceStatusesLkp::REJECTED,
            );

            $user = Auth::user();
            $userRoleMap = $this->userManager->getUserRolesMapping()->filter(
                function ($entry) use ($user) {
                    return $entry->user_id === $user->id;
                }
            );
            $userRoleId = $userRoleMap->first()->role_id;
            if($viewModel->isAdmin ){
                $user->type = $this->userManager->get_admin_users()->filter(
                    function ($entry) use ($userRoleId) {
                        return $entry->id=== $userRoleId;
                    }
                )->first();
            }
            else{
                $user->type = $this->userManager->getUserRoles()->filter(
                    function ($entry) use ($userRoleId) {
                        return $entry->id=== $userRoleId;
                    }
                )->first();
            }
            return view('admin.admin-page')->with(['viewModel' => $viewModel,  'user' => $user]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function getResources(Request $request)
    {
        $lang_id = null;
        if($request->lang_id){
            $lang_id = intval($request->lang_id);
        }
        $user_id = null;
        if ($request->user_id_to_get_content) {
            $user_id = intval($request->user_id_to_get_content);
        }
        $status_ids = [];
        if($request->status_ids){
            $status_ids = explode(',', $request->status_ids);
        }
        $type_ids = null;
        if($request->type_ids){
            $type_ids = explode(',', $request->type_ids);
        }
        $difficulties = explode(',', $request->difficulties);
        $ratings = explode(',', $request->ratings);
        return $this->resourceManager->getResources(
            $lang_id,
            $user_id,
            $status_ids,
            $difficulties,
            $type_ids,
            $ratings
        );
    }


    public function getReports(Request $request)
    {
        $reportedResourcesWithMetadata = $this->resourceManager->getReportedExercises();
        return $reportedResourcesWithMetadata;

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

    public function coming_soon(): View
    {
        return view('coming-soon');
    }


    public function getTransformAllExercisesForMobileApp(Request $request){
        try {
            return $this->resourceManager->getPaginatedResourcesForMobile($request->lang,$request->category);
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', 'Warning! Failed to form JSON output');
        }
    }

}
