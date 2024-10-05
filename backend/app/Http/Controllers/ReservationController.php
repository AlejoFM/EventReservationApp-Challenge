<?php

namespace App\Http\Controllers;

use App\Exceptions\ResponseValidationException;
use App\Http\Requests\CreateReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Response\JsonErrorResponse;
use App\Http\Response\JsonSuccesfulBodyResponse;
use App\Http\Response\JsonSuccesfulResponse;
use App\Http\Services\ReservationService;
use App\Models\Reservation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    private ReservationService $reservationService; 
    public function __construct(ReservationService $reservationService) {
        $this->reservationService = $reservationService;
    }
/**
     * @OA\Get(
     *     path="/api/reservations",
     *     summary="Obtiene una lista de reservas del usuario autenticado",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reservas"
     *     )
     * )
     */
    public function index()
    {
        try{
           return (new JsonSuccesfulBodyResponse($this->reservationService->index(), 200))->send();
        }catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     summary="Crea una nueva reserva",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"event_name", "space_id", "start_time", "end_time"},
     *             @OA\Property(property="event_name", type="string", example="Reunión de Proyecto"),
     *             @OA\Property(property="space_id", type="integer", example=1),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2024-09-30T10:00:00"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2024-09-30T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reserva creada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function store(CreateReservationRequest $request)
    {
        try{
        $this->reservationService->store($request->validated());
        return (new JsonSuccesfulResponse('Reservation booked succesfully.', 201))->send();
        }
        catch(ResponseValidationException $e){
            return (new JsonErrorResponse($e->getMessage(), $e->getCode()))->send();
        }
        catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
        catch (ValidationException $e) {
            return (new JsonErrorResponse($e->validator->errors()->first(), 422))->send();
        }
    }

    /**
     * @OA\Get(
     *     path="/api/reservations/{id}",
     *     summary="Obtiene los detalles de una reserva",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la reserva"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reserva no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        try{

        $reservation = $this->reservationService->show($id);
        return (new JsonSuccesfulBodyResponse($reservation))->send();
        }catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
    }

    /**
     * @OA\Put(
     *     path="/api/reservations/{id}",
     *     summary="Actualiza una reserva existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"event_name", "start_time", "end_time"},
     *             @OA\Property(property="event_name", type="string", example="Reunión de Proyecto Actualizada"),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2024-09-30T11:00:00"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2024-09-30T13:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserva actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reserva no encontrada"
     *     )
     * )
     */
    public function update(UpdateReservationRequest $request, $id)
    {
        try{
            $this->reservationService->update($id, $request->validated());
            return (new JsonSuccesfulResponse("Reservation updated succesfully.", 200))->send();
        }catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
        catch (ValidationException $e) {
            return (new JsonErrorResponse($e->validator->errors()->first(), 422))->send();
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{id}",
     *     summary="Elimina una reserva",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Reserva eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reserva no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        try{
            $this->reservationService->destroy($id);
            
            return (new JsonSuccesfulResponse("Reservation deleted succesfully.", 204))->send();
        }catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
    }


    public function getOccupiedDates(Request $request)
    {
        try{
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            $occupiedDates = $this->reservationService->getOccupiedDates($startDate, $endDate);

            return (new JsonSuccesfulBodyResponse(['occupied_dates' => $occupiedDates]))->send();
        }catch(Exception $e){
            Log::channel('reservations')->info($e->getMessage(). "\n" . $e->getLine() . "\n" . $e->getFile());
            return (new JsonErrorResponse("Something gone wrong with reservations.", 500))->send();
        }
    }
}
