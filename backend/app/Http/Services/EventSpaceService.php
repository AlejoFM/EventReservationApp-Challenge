<?php 

namespace App\Http\Services;

use App\Models\EventSpace;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventSpaceService {

    public function filterEventSpaces(?string $type, ?int $capacity, ?string $startDate, ?string $endDate, int $size)
        {
        $query = EventSpace::query();
        
        if ($type) {
            $query->where('type', $type);
        }
        if ($capacity) {
            $query->where('capacity', '<=', $capacity);
        }

        if ($startDate && $endDate) {
            $query->whereDoesntHave('reservations', function ($q) use ($startDate, $endDate) {
                $q->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('start_time', [$startDate, $endDate])
                      ->orWhereBetween('end_time', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_time', '<=', $startDate)
                            ->where('end_time', '>=', $endDate);
                      });
                });
            });
        }

        return $query->paginate($size);
    }
    public function createEventSpace(array $data): EventSpace
    {
        return EventSpace::create($data);
    }

    public function getEventspaceById($id): EventSpace
    {
        try{
        return EventSpace::findOrFail($id);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function updateEventSpace($id, array $data){
        try{
        $eventSpace = EventSpace::findOrFail($id);
        $eventSpace->update($data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function deleteEventSpace(int $id): void
    {
        $eventSpace = EventSpace::find($id);
        
        if (!$eventSpace) {
            throw new ModelNotFoundException("Event Space not found");
        }

        $eventSpace->delete();
    }
}