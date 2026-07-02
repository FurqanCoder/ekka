<?php

use App\Http\Controllers\Admin\OrderPdfController;
use App\Http\Controllers\Admin\OrderPdfController as AdminOrderPdfController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShopController;
use App\Livewire\Dashboard\AddProductComponent;
use App\Livewire\Dashboard\Auth\LoginComponent;
use App\Livewire\Dashboard\Auth\RegisterComponent;
use App\Livewire\Dashboard\BrandComponent;
use App\Livewire\Dashboard\CategoryComponent;
use App\Livewire\Dashboard\CouponsComponent;
use App\Livewire\Dashboard\DiscountComponent;
use App\Livewire\Dashboard\OfferComponent;
use App\Livewire\Dashboard\Order\ListOrders;
use App\Livewire\Dashboard\Order\ViewOrder;
use App\Livewire\Dashboard\ProductComponent;
use App\Livewire\Dashboard\ShippingManager;
use App\Livewire\Web\CartComponent;
use App\Livewire\Web\CheckOutComponent;
use App\Livewire\Web\Components\CartComponent as ComponentsCartComponent;
use App\Livewire\Web\Components\Wish\WishManager;
use App\Livewire\Web\HomeComponent;
use App\Livewire\Web\ShopComponent;
use App\Livewire\Web\ThanksComponent;
use App\Livewire\Web\User\OrderDetail;
use App\Livewire\Web\User\OrderList;
use App\Livewire\Web\WebProductComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


// dasboard routes
// Authentications routes
Route::get('admin/register',RegisterComponent::class)->name('dev-register');
Route::get('admin/login', LoginComponent::class)->name('dev-login');

//other routes
Route::get('admin/category', CategoryComponent::class)->name('dev-category');
Route::get('admin/brands',BrandComponent::class)->name('dev-content');
Route::get('admin/product', ProductComponent::class)->name('dev.product');
Route::get('admin/add/product',AddProductComponent::class)->name('dev-add-product');
Route::get('admin/edit/product/{id}', AddProductComponent::class)->name('dev-edit-product');
Route::get('/dashboard/offers', OfferComponent::class)
        ->name('dev-discounts');
Route::get('/dashboard/coupons', CouponsComponent::class)->name('dev-coupons');
Route::get('admin/shipping/manage', ShippingManager::class)->name('dev-shipping');
Route::get('/dashboard/orders/list', ListOrders::class)->name('dev-order.lists');
Route::get('/dashboard/orders/show/{order}', ViewOrder::class)->name('dev-order.show');
Route::get('/orders/{order}/invoice', [AdminOrderPdfController::class, 'invoice'])->name('admin.orders.invoice');
Route::get('/orders/{order}/packing-slip', [OrderPdfController::class, 'packingSlip'])->name('admin.orders.packingSlip');
// Route::get('test', [AdminOrderPdfControllerd]);
// web routes
Route::get('/', HomeComponent::class)->name('home');
Route::get('/cart', CartComponent::class)->name('web-cart');
Route::get('/checkout', CheckOutComponent::class)->name('web-check-out');
Route::get('/order-confirmation', ThanksComponent::class)->name('web-order-confirmation');
Route::get('/wishlist', WishManager::class)->name('web.wish');
Route::get('/shop', ShopComponent::class)->name('web.shop');
Route::get('/filter', [ShopController::class, 'index'])->name('web.filter');
// login users pages
Route::get('/orders', OrderList::class)->name('web.user.order');
Route::get('/user/orders/{orderId}', OrderDetail::class)
        ->name('user.orders.show');
// google auth routes

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Route::get('/test', function () {
//     return view('website');
// });
Route::get('admin',function(){
    return view('admin');
});
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::get('/{slug}', WebProductComponent::class)->name('web-product');

// services worker  route
Route::get('/service-worker.js', function () {
    return response()->file(public_path('service-worker.js'), [
        'Content-Type' => 'application/javascript'
    ]);
});
// offile
Route::view('/offline', 'offline')->name('offline');
// notification
Route::post('/save-fcm-token', [NotificationController::class, 'saveToken']);

// Route::post('/send-notification', [NotificationController::class, 'testNotification'])->name('send.noti');


// user pages

require __DIR__.'/auth.php';
