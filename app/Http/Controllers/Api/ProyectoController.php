<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 20:12
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProyectoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ProyectoCollection;
use App\Http\Resources\ProyectoResource;
use App\Http\Requests\ProyectoRequest;

class ProyectoController extends Controller
{
    protected $proyectoService;

    public function __construct(ProyectoService $proyectoService)
    {
        $this->proyectoService = $proyectoService;
    }

    /**
     * Display a listing of the resource owned by the Lider.
     *
     * @param Request $request
     * @return ProyectoCollection
     */
    public function index(Request $request)
    {
        return
            new ProyectoCollection(
                $this->proyectoService->getAll(
                    $request->user()
                )
            );
    }

    /**
     * Display a listing of the resource (all).
     *
     * @return ProyectoCollection
     */
    public function indexAll()
    {
        return
            new ProyectoCollection(
                $this->proyectoService->getAll()
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
        $proyecto = $this->proyectoService->get($id);
        return $proyecto
            ? $this->getProyecto($proyecto)
            : parent::notFound();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProyectoRequest $request
     * @return Response
     */
    public function store(ProyectoRequest $request)
    {
        $proyecto = $this->proyectoService->save($request->validated());
        return $this->getProyecto($proyecto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProyectoRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ProyectoRequest $request, $id)
    {
        $proyecto = $this->proyectoService->get($id);
        if ($proyecto) {
            $this->proyectoService->save(
                $request->validated(),
                $proyecto
            );
            return $this->getProyecto($proyecto);
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
        return $this->proyectoService->destroy($id)
            ? parent::ok()
            : parent::notFound();
    }

    private function getProyecto($proyecto)
    {
        return response()->json([
            'proyecto' => (new ProyectoResource($proyecto))
        ], 200);
    }
}
