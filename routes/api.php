<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PriorityApiController;
use App\Http\Controllers\Api\StatusApiController;
use App\Http\Controllers\Api\TaskUserController;

// Register
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'User registered successfully']);
});

// Login
Route::post('/login', function (Request $request) {
    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->group(function () {
    // Protected route example
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Protected tasks routes
    Route::apiResource('tasks', TaskApiController::class);
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('priorities', PriorityApiController::class);
    Route::apiResource('statuses', StatusApiController::class);
    Route::apiResource('task-users', TaskUserController::class);

});

