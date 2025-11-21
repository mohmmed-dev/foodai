<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FoodController;

Route::get('/ss', function () {
    return view('welcome');
})->name('home');

Route::get('user', UserController::class)
    ->name('screen');

Route::get('app/{content:slug}', ContentController::class)->name('content.show');

Route::controller(FoodController::class)->group(function() {
    Route::get('ch', 'ch')->name('ch');
    Route::get('', 'analyzer')->name('analyzer');
    Route::get('creator', 'creator')->name('creator');
    Route::post('scan', 'make')->name('scan');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('auth/{provider}/redirect',[ProviderController::class,'providerRedirect']
)->name('provider.redirect');
Route::get('auth/{provider}/callback',[ProviderController::class,'providerCallback']);
