<?php


namespace App\BusinessLogicLayer\Shapes;


use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\Repository\Shapes\UserTokensRepository;
use App\Repository\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;

class ShapesIntegrationManager {

    protected UserRepository $userRepository;
    protected UserRoleManager $userRoleManager;
    protected UserTokensRepository $userTokensRepository;

    public function __construct(UserRoleManager $userRoleManager, UserRepository $userRepository,
                                UserTokensRepository $userTokensRepository) {
        $this->userRoleManager = $userRoleManager;
        $this->userRepository = $userRepository;
        $this->userTokensRepository = $userTokensRepository;
    }


    public function createShapes(Request $request)
    {

        $response = Http::withHeaders([
            'X-Shapes-Key' => '7Msbb3w^SjVG%j',
            'Accept' => "application/json"
        ])->post('https://kubernetes.pasiphae.eu/shapes/asapa/auth/register', [
            'email' => $request['email'],
            'password' => $request['password'],
            'first_name' => 'Tester',
            'last_name' => 'Test',
        ]);
        $requestData = $request->all();
        $requestData['name']  = 'Dianoia_user_' . $this->userRepository->getLastId();
        $this->userRepository->create($requestData);
    }

    public function loginShapes(Request $request)
    {

        $response = Http::withHeaders([
            'X-Shapes-Key' => '7Msbb3w^SjVG%j',
            'Accept' => "application/json"
        ])->post('https://kubernetes.pasiphae.eu/shapes/asapa/auth/login', [
            'email' => $request['email'],
            'password' => $request['password'],
        ]);
        if(!$response->ok()){
            abort(404);
        }

        return $response->json();
    }

    public function storeUserToken($user_id, $token){
        $storeArr = array(
            "user_id" => $user_id,
            "token" => $token
        );
        $this->userTokensRepository->create($storeArr);
    }

    public function findUserByEmail($email)
    {
        return $this->userRepository->findBy('email', $email);
    }

}
