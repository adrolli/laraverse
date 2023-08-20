<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StackCollection;

class UserStacksController extends Controller
{
    public function index(Request $request, User $user): StackCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $stacks = $user
            ->stacks()
            ->search($search)
            ->latest()
            ->paginate();

        return new StackCollection($stacks);
    }

    public function store(Request $request, User $user, Stack $stack): Response
    {
        $this->authorize('update', $user);

        $user->stacks()->syncWithoutDetaching([$stack->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        User $user,
        Stack $stack
    ): Response {
        $this->authorize('update', $user);

        $user->stacks()->detach($stack);

        return response()->noContent();
    }
}
