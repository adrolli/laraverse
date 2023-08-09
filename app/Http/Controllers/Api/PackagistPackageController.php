<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PackagistPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackagistPackageResource;
use App\Http\Resources\PackagistPackageCollection;
use App\Http\Requests\PackagistPackageStoreRequest;
use App\Http\Requests\PackagistPackageUpdateRequest;

class PackagistPackageController extends Controller
{
    public function index(Request $request): PackagistPackageCollection
    {
        $this->authorize('view-any', PackagistPackage::class);

        $search = $request->get('search', '');

        $packagistPackages = PackagistPackage::search($search)
            ->latest()
            ->paginate();

        return new PackagistPackageCollection($packagistPackages);
    }

    public function store(
        PackagistPackageStoreRequest $request
    ): PackagistPackageResource {
        $this->authorize('create', PackagistPackage::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $packagistPackage = PackagistPackage::create($validated);

        return new PackagistPackageResource($packagistPackage);
    }

    public function show(
        Request $request,
        PackagistPackage $packagistPackage
    ): PackagistPackageResource {
        $this->authorize('view', $packagistPackage);

        return new PackagistPackageResource($packagistPackage);
    }

    public function update(
        PackagistPackageUpdateRequest $request,
        PackagistPackage $packagistPackage
    ): PackagistPackageResource {
        $this->authorize('update', $packagistPackage);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $packagistPackage->update($validated);

        return new PackagistPackageResource($packagistPackage);
    }

    public function destroy(
        Request $request,
        PackagistPackage $packagistPackage
    ): Response {
        $this->authorize('delete', $packagistPackage);

        $packagistPackage->delete();

        return response()->noContent();
    }
}
