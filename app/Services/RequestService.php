<?php

namespace App\Services;

use App\Events\NewRequestSubmitted;
use App\Events\RequestStatusUpdated;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class RequestService
{
    public function getUserRequests(): Collection
    {
        return Request::where('user_id', Auth::id())->get();
    }

    public function getUserRequestById(int $id): Request
    {
        return Request::where('user_id', Auth::id())->findOrFail($id);
    }

    public function createRequest(array $data): Request
    {
        $data['user_id'] = auth()->id();

        $request = Request::create($data);

        NewRequestSubmitted::dispatch($request);

        return $request;
    }

    public function updateRequestStatus(int $id, string $status): Request
    {
        $request = Request::findOrFail($id);
        $request->update(['status' => $status]);

        RequestStatusUpdated::dispatch($request);

        return $request;
    }

    public function deleteRequest(int $id): void
    {
        $request = Request::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $request->delete();
    }
}
