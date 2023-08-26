<?php

namespace App\Http\Controllers\Api;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\OwnerCollection;
use App\Http\Requests\OwnerStoreRequest;
use App\Http\Requests\OwnerUpdateRequest;

class OwnerController extends Controller
{
    public function index(Request $request): OwnerCollection
    {
        $this->authorize('view-any', Owner::class);

        $search = $request->get('search', '');

        $owners = Owner::search($search)
            ->latest()
            ->paginate();

        return new OwnerCollection($owners);
    }

    public function store(OwnerStoreRequest $request): OwnerResource
    {
        $this->authorize('create', Owner::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $owner = Owner::create($validated);

        return new OwnerResource($owner);
    }

    public function show(Request $request, Owner $owner): OwnerResource
    {
        $this->authorize('view', $owner);

        return new OwnerResource($owner);
    }

    public function update(
        OwnerUpdateRequest $request,
        Owner $owner
    ): OwnerResource {
        $this->authorize('update', $owner);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $owner->update($validated);

        return new OwnerResource($owner);
    }

    public function destroy(Request $request, Owner $owner): Response
    {
        $this->authorize('delete', $owner);

        $owner->delete();

        return response()->noContent();
    }
}
