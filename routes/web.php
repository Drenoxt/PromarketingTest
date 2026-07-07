<?php

use App\Enums\Locale;
use App\Enums\PermissionName;
use App\Models\Player;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Switches the UI language for the current session. Kept outside 'auth' so it
// works from the login page too.
Route::post('/locale/{locale}', function (Locale $locale, Request $request) {
    $request->session()->put('locale', $locale->value);

    return back();
})->name('locale.switch');

// Minimal session auth: enough to sign in and let the module react to the user's
// permissions. A full starter kit (Breeze/Fortify) can replace this if needed.
Route::view('/login', 'auth.login')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors(['email' => __('notes.invalid_credentials')])->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended('/');
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// Players index: pick a player to review. Reachable once authenticated.
Route::get('/', function () {
    return view('players.index', [
        'players' => Player::withCount('notes')->orderBy('username')->get(),
    ]);
})->middleware('auth')->name('players.index');

// Notes for one specific player (bound by uuid). The form inside is further
// gated by the 'create player notes' permission.
Route::get('/players/{player}', function (Player $player) {
    return view('players.show', ['player' => $player]);
})->middleware('auth')->name('players.show');

// Admin-only dashboard listing every note across all players.
Route::get('/dashboard', function (PlayerNoteRepositoryInterface $notes) {
    abort_unless(auth()->user()->can(PermissionName::ViewDashboard->value), 403);

    return view('dashboard', ['notes' => $notes->getAll()]);
})->middleware('auth')->name('dashboard');
