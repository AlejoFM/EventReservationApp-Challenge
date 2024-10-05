<?php

namespace App\Http\Services;

use App\Exceptions\ResponseValidationException;
use App\Http\Response\JsonErrorResponse;
use App\Models\Reservation;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use Exception;
use DB;


class ReservationService{
    public function index(){
        return auth()->user()->reservations;
    }
    public function update($id, $validatedData){
        try{
        $reservation = Reservation::findOrFail($id);
        $reservation->update($validatedData);
        }catch(Exception $e){
            throw $e;
        }
    }
    public function destroy($id){
        try{
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
        }catch(Exception $e){
            throw $e;
        }
    }
    public function store($validatedData){
        try{
            $overlappingReservation = Reservation::where('event_space_id', $validatedData['event_space_id'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                      ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']])
                      ->orWhere(function ($query) use ($validatedData) {
                          $query->where('start_time', '<=', $validatedData['start_time'])
                                ->where('end_time', '>=', $validatedData['end_time']);
                      });
            })
            ->exists();

        if ($overlappingReservation) {
            throw new ResponseValidationException('This time slot is already booked.', 409);
        }
        DB::beginTransaction();
            Reservation::create([
                'event_space_id' => $validatedData['event_space_id'],
                'event_name' => $validatedData['event_name'],
                'start_time' => $validatedData['start_time'],
                'end_time' => $validatedData['end_time'],
                'status' => $validatedData['status'],
                'user_id' => auth()->id(),
            ]);

        DB::commit();
        
        }catch(Exception $e){ 
            DB::rollBack();
            throw $e;
        }
    }
    public function show($id){
        try{
        return Reservation::findOrFail($id);
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getOccupiedDates($startDate, $endDate){
        return Reservation::where(function($query) use ($startDate, $endDate) {
            $query->whereBetween('start_time', [$startDate, $endDate])
                  ->orWhereBetween('end_time', [$startDate, $endDate])
                  ->orWhere(function($query) use ($startDate, $endDate) {
                      $query->where('start_time', '<=', $startDate)
                            ->where('end_time', '>=', $endDate);
                  });
        })
        ->get(['start_time', 'end_time']);
    }
}