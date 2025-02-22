<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\Usuario\Store\StoreUsuarioRequest as StoreStoreUsuarioRequest;
use App\Interface\Usuario\UsuariosRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthController extends Controller
{
    //
    protected $userRepo;

    public function __construct(UsuariosRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Users"},
     *     summary="Crear nuevo usuario",
     *     description="Crear nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="ejemplo@email.com"),
     *             @OA\Property(property="password", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Record created successfully"
     *     )
     * )
     */
    public function register(StoreStoreUsuarioRequest $request)
    {
        $user = $this->userRepo->store($request->all());
        return ApiResponseHelper::sendResponse($user, 'Registro insertado correctamente', 201);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Users"},
     *     summary="Iniciar Sesión",
     *     description="Iniciar Sesión",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example=""),
     *             @OA\Property(property="password", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sesión iniciada correctamente"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = $this->userRepo->findByEmailOrUser($request->user);
        $userresponse = $this->userRepo->responseUser($request->user);
        if ($user == null) {
            return response()->json(['message' => 'Credenciales no válidas '], 400);
        }

        if ($user->intentos >= 3) {
            return response()->json(['message' => 'Ha excedido el número de intentos de inicio de sesión, favor de contactar con el administrador '], 400);
        } else {

            if (!$user->habilitado == 1) {

                return response()->json(['message' => 'Usuario inhabilitado'], 400);
            } else {
                if (!$user || !Hash::check($request->password, $user->password)) {
                
                    DB::beginTransaction();
                    try {
                        $this->userRepo->aumentarIntento($user->intentos, $user->id);

                        DB::commit();
                    } catch (Exception $ex) {
                        DB::rollBack();
                        return ApiResponseHelper::rollback($ex);
                    }

                    return response()->json(['message' => 'Credenciales no válidas '], 400);
                }
            }
        }

        $token = $this->userRepo->generateToken($user);

        DB::beginTransaction();
        try {
            $this->userRepo->loginActive($user->id);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuario logueado correctamente',
            'data' => $userresponse,
            'token' => $token,

        ], 200);
        return ApiResponseHelper::sendResponse($userresponse, 'Record insert succesfull', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     tags={"Users"},
     *     summary="Cerrar Sesión",
     *     description="Cerrar Sesión",
     *     @OA\RequestBody(
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sesión iniciada correctamente"
     *     )
     * )
     */
    public function logout(Request $request, $id)
    {
        $request->user()->tokens()->delete();

        DB::beginTransaction();
        try {
            $this->userRepo->loginInactive($id);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
        return response()->json(['message' => 'Logged out'], 200);
    }
}
