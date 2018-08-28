<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection(
            $this->userService->getAll()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->get($id);
        return $user
            ? $this->getUser($user)
            : parent::notFound();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserRequest
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->get($id);
        if ($user) {
            $user = $this->userService->save(
                $request->validated(),
                $user
            );
            return $this->getUser($user);
        } else {
            return parent::notFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->userService->destroy($id)
            ? parent::ok()
            : parent::notFound();
    }

    /**
     * Display the current user.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return $this->getUser($request->user());
    }

    /**
     * Update the current user.
     * @param \App\Http\Requests\UserRequest
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserRequest $request)
    {
        $user = $this->userService->save(
            $request->validated(),
            $request->user()
        );
        return $this->getUser($user);
    }

    /* Si el usuario no es admin se lo hace admin. Si lo es, se le quita el rol.
     * @param $id El id del usuario
     * @return \Illuminate\Http\Response
     */
    public function cambiarRol($id)
    {
        $user = $this->userService->get($id);
        if ($user) {
            $this->userService->cambiarRol($user);
            return parent::ok();
        } else {
            return parent::notFound();
        }
    }

    private function getUser($user)
    {
        return response()->json([
            'user' => (new UserResource($user))
        ], 200);
    }
}
