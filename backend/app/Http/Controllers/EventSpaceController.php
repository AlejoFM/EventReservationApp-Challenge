<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventSpaceRequest;
use App\Http\Requests\EventSpaceFilterRequest;
use App\Http\Requests\UpdateEventSpaceRequest;
use App\Http\Response\JsonErrorResponse;
use App\Http\Response\JsonSuccesfulBodyResponse;
use App\Http\Response\JsonSuccesfulPaginatedBodyResponse;
use App\Http\Response\JsonSuccesfulResponse;
use App\Http\Services\EventSpaceService;
use App\Models\EventSpace;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
/**
 * @OA\Tag(
 *     name="Event spaces", 
 *     description="API relacionada a los espacios de eventos"
 * )
 */
class EventSpaceController extends Controller
{
    private $eventSpaceService;
    public function __construct(EventSpaceService $eventSpaceService){
        $this->eventSpaceService = $eventSpaceService;
    }

        /**
     * @OA\Get(
     *     path="/api/event_spaces",
     *     summary="Obtiene una lista de espacios",
     *     tags={"Event spaces"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de espacios"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function index(EventSpaceFilterRequest $request)
    {
        try {
            $validated = $request->validated();

            $eventSpaces = $this->eventSpaceService->filterEventSpaces(
                $validated['type'] ?? null,
                $validated['capacity'] ?? null,
                $validated['start_date'] ?? null,
                $validated['end_date'] ?? null,
                $validated['size'] ?? 15 
            );

            return (new JsonSuccesfulPaginatedBodyResponse([
                'event_spaces' => $eventSpaces->items(),
                'total' => $eventSpaces->total(),
            ]))->send();
        } catch (Exception $e) {
            Log::channel('event_spaces')->error($e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return (new JsonErrorResponse('An error occurred while retrieving event spaces.', 500))->send();
        }
    }
 /**
     * @OA\Post(
     *     path="/api/event_spaces",
     *     summary="Crea un nuevo espacio",
     *      tags={"Event spaces"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","capacity","type"},
     *             @OA\Property(property="name", type="string", example="Auditorio Central"),
     *             @OA\Property(property="capacity", type="integer", example=100),
     *             @OA\Property(property="type", type="string", example="Auditorio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Espacio creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     ),
         *     security={
    *         {"bearerAuth": {}}
    *     }
     * )
     */
    public function store(CreateEventSpaceRequest $request)
    {
        try {
            $this->eventSpaceService->createEventSpace($request->validated());

            return (new JsonSuccesfulResponse("Event space created successfully.", 201))->send();
        } catch (Exception $e) {
            Log::channel('event_spaces')->error($e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return (new JsonErrorResponse("An error occurred while creating the event space.", 500))->send();
        }
    }

    /**
     * @OA\Get(
     *     path="/api/event_spaces/{id}",
     *     summary="Obtiene los detalles de un espacio",
     *      tags={"Event spaces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del espacio"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado"
     *     ),
         *     security={
    *         {"bearerAuth": {}}
    *     }
     * )
     */
    public function show($id)
    {
        try{
        return (new JsonSuccesfulBodyResponse($this->eventSpaceService->getEventSpaceById($id)))->send();
        }catch(Exception $e){
            return (new JsonErrorResponse("No se encontró el espacio de evento", 401))->send();
        }
    }

    /**
     * @OA\Put(
     *     path="/api/event_spaces/{id}",
     *     summary="Actualiza un espacio existente",
     *      tags={"Event spaces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Auditorio Renovado"),
     *             @OA\Property(property="capacity", type="integer", example=150),
     *             @OA\Property(property="type", type="string", example="Auditorio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espacio actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado"
     *     ),
         *     security={
    *         {"bearerAuth": {}}
    *     }
     * )
     */
    public function update(UpdateEventSpaceRequest $request, $id)
    {
        try{
            $validatedData = $request->validated();
        $this->eventSpaceService->updateEventSpace($id, $validatedData);
            return (new JsonSuccesfulBodyResponse("Event Space updated succesfully.", 200))->send();
        }catch (ModelNotFoundException $e) {
            return (new JsonErrorResponse("Event space not found.", 404))->send(); 
        } catch (Exception $e) {
            Log::error($e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return (new JsonErrorResponse("An error occurred while updating the event space.", 500))->send();
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/event_spaces/{id}",
     *     summary="Elimina un espacio",
     *      tags={"Event spaces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Espacio eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function destroy($id)
    {
        try {
            $this->eventSpaceService->deleteEventSpace($id);
            return (new JsonSuccesfulResponse("Event Space deleted successfully.", 204))->send();
        } catch (ModelNotFoundException $e) {
            return (new JsonErrorResponse("Event Space not found.", 404))->send(); 
        } catch (Exception $e) {
            Log::error($e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return (new JsonErrorResponse("An error occurred while deleting the event space.", 500))->send();
        }
    }
}
