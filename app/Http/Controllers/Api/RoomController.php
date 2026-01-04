<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        $perPage = (int) $request->input('per_page', 15);

        $rooms = $query->paginate($perPage);

        return RoomResource::collection($rooms)->response();
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());

        return (new RoomResource($room))->response()->setStatusCode(201);
    }

    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return new RoomResource($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->noContent();
    }
}