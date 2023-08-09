<?php

namespace App\Http\Controllers\Api;

use App\Models\NpmPackage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\NpmPackageResource;
use App\Http\Resources\NpmPackageCollection;
use App\Http\Requests\NpmPackageStoreRequest;
use App\Http\Requests\NpmPackageUpdateRequest;

class NpmPackageController extends Controller
{
    public function index(Request $request): NpmPackageCollection
    {
        $this->authorize('view-any', NpmPackage::class);

        $search = $request->get('search', '');

        $npmPackages = NpmPackage::search($search)
            ->latest()
            ->paginate();

        return new NpmPackageCollection($npmPackages);
    }

    public function store(NpmPackageStoreRequest $request): NpmPackageResource
    {
        $this->authorize('create', NpmPackage::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $npmPackage = NpmPackage::create($validated);

        return new NpmPackageResource($npmPackage);
    }

    public function show(
        Request $request,
        NpmPackage $npmPackage
    ): NpmPackageResource {
        $this->authorize('view', $npmPackage);

        return new NpmPackageResource($npmPackage);
    }

    public function update(
        NpmPackageUpdateRequest $request,
        NpmPackage $npmPackage
    ): NpmPackageResource {
        $this->authorize('update', $npmPackage);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $npmPackage->update($validated);

        return new NpmPackageResource($npmPackage);
    }

    public function destroy(Request $request, NpmPackage $npmPackage): Response
    {
        $this->authorize('delete', $npmPackage);

        $npmPackage->delete();

        return response()->noContent();
    }
}
