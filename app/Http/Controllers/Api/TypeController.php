<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TypeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeCollection;
use App\Http\Requests\TypeStoreRequest;
use App\Http\Requests\TypeUpdateRequest;

class TypeController extends Controller
{
    public function index(Request $request): TypeCollection
    {
        $this->authorize('view-any', Type::class);

        $search = $request->get('search', '');

        $types = Type::search($search)
            ->latest()
            ->paginate();

        return new TypeCollection($types);
    }

    public function store(TypeStoreRequest $request): TypeResource
    {
        $this->authorize('create', Type::class);

        $validated = $request->validated();

        $type = Type::create($validated);

        return new TypeResource($type);
    }

    public function show(Request $request, Type $type): TypeResource
    {
        $this->authorize('view', $type);

        return new TypeResource($type);
    }

    public function update(TypeUpdateRequest $request, Type $type): TypeResource
    {
        $this->authorize('update', $type);

        $validated = $request->validated();

        $type->update($validated);

        return new TypeResource($type);
    }

    public function destroy(Request $request, Type $type): Response
    {
        $this->authorize('delete', $type);

        $type->delete();

        return response()->noContent();
    }
}
