<?php




\Illuminate\Support\Facades\Route::get('/', function () {
    //  return redirect('/admin');

    $user = \Illuminate\Support\Facades\Auth::user();

    $oldestMovement = \App\Models\CashMovement::getOldestMovement($user);
    $newestMovement = \App\Models\CashMovement::getNewestMovement($user);

    return response()->json([
        'status' => 'API is running',
        'oldest_movement' => $oldestMovement,
        'newest_movement' => $newestMovement,
    ]);
});



require __DIR__ . '/auth.php';
