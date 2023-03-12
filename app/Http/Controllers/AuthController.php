<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidEmailOrPasswordException;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    private AuthService $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Login The User
     * @param AuthRequest $request
     * @return JsonResponse
     * @throws InvalidEmailOrPasswordException
     */
    public function login(AuthRequest $request): JsonResponse
    {
            $user = $this->authService->login($request->email, $request->password);

            return response()->json(new AuthResource($user), Response::HTTP_OK);
    }
}
