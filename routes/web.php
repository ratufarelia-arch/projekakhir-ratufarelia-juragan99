<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminRecipeController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Route::aliasMiddleware('role', admin\App\Http\Middleware\EnsureUserHasRole::class);

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/product', [ShopController::class, 'showProducts'])->name('shop.products.index');
Route::get('/product/{product:slug}', [ShopController::class, 'showProduct'])->name('shop.products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('shop.checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout.store');
Route::get('/cart', [ShopController::class, 'showCart'])->name('shop.cart.index');
Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('shop.cart.add');
Route::patch('/cart/{product}', [ShopController::class, 'updateCart'])->name('shop.cart.update');
Route::delete('/cart/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

Route::post('/wishlist/add', [ShopController::class, 'addToWishlist'])->name('shop.wishlist.add');
Route::delete('/wishlist/{product}', [ShopController::class, 'removeFromWishlist'])->name('shop.wishlist.remove');
Route::get('/wishlist', [ShopController::class, 'showWishlist'])->name('shop.wishlist.index');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('shop.orders.index');
        Route::get('/orders/{order}/invoice', [CustomerOrderController::class, 'invoice'])->name('shop.orders.invoice');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('shop.orders.show');
        Route::post('/orders/{order}/reviews', [CustomerOrderController::class, 'storeReview'])->name('shop.orders.reviews.store');

        Volt::route('settings/profile', 'settings.profile')->name('profile.edit');

    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
 
    Volt::route('settings/two-factor', 'settings.two-factor')
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

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('reports/sales', [AdminOrderController::class, 'salesReport'])->name('admin.reports.sales');
    Route::resource('products', AdminProductController::class)
        ->except(['show'])
        ->names('admin.products');
    Route::resource('recipes', AdminRecipeController::class)
        ->except(['show'])
        ->names('admin.recipes');
    Route::resource('orders', AdminOrderController::class)
        ->only(['index', 'show', 'update'])
        ->names('admin.orders');
    Route::get('orders/{order}/invoice', [AdminOrderController::class, 'invoice'])
        ->name('admin.orders.invoice');
});

