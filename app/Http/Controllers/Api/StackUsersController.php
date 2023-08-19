<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class StackUsersController extends Controller
{
    public function index(Request $request, Stack $stack): UserCollection
    {
        $this->authorize('view', $stack);

        $search = $request->get('search', '');

        $users = $stack
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Stack $stack, User $user): Response
    {
        $this->authorize('update', $stack);

        $stack->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Stack $stack,
        User $user
    ): Response {
        $this->authorize('update', $stack);

        $stack->users()->detach($user);

        return response()->noContent();
    }
}
