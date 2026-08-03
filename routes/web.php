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
use App\Livewire\Dashboard\IndexComponent;
use App\Livewire\Dashboard\OfferComponent;
use App\Livewire\Dashboard\Order\ListOrders;
use App\Livewire\Dashboard\Order\ViewOrder;
use App\Livewire\Dashboard\ProductComponent;
use App\Livewire\Dashboard\ProductViewComponent;
use App\Livewire\Dashboard\ReportsComponent;
use App\Livewire\Dashboard\Settings\DesignComponent;
use App\Livewire\Dashboard\Settings\OfferCardComponent;
use App\Livewire\Dashboard\Settings\LogoAndLinks;
use App\Livewire\Dashboard\ShippingManager;
use App\Livewire\Dashboard\UserManagementComponent;
use App\Livewire\Web\AboutUs;
use App\Livewire\Web\CartComponent;
use App\Livewire\Web\CheckOutComponent;
use App\Livewire\Web\Components\CartComponent as ComponentsCartComponent;
use App\Livewire\Web\Components\Wish\WishManager;
use App\Livewire\Web\ContactUs;
use App\Livewire\Web\Dashboard\UserDashboard;
use App\Livewire\Web\HomeComponent;
use App\Livewire\Web\Dashboard\OrderDetailComponent;

use App\Livewire\Web\ShopComponent;
use App\Livewire\Web\ThanksComponent;
use App\Livewire\Web\User\OrderDetail;
use App\Livewire\Web\User\OrderList;
use App\Livewire\Web\WebProductComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


// Public admin auth routes
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/register', RegisterComponent::class)->name('dev-register');
    Route::get('/login', LoginComponent::class)->name('dev-login');
});

// Protected admin dashboard and management routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', IndexComponent::class)->name('admin.dashboard');
    Route::get('/reports', ReportsComponent::class)->name('reports');
    Route::get('/users', UserManagementComponent::class)->name('users');
    Route::get('/category', CategoryComponent::class)->name('dev-category');
    Route::get('/brands', BrandComponent::class)->name('dev-content');
    Route::get('/product', ProductComponent::class)->name('dev.product');
    Route::get('/products/{id}/view', ProductViewComponent::class)->name('products.view');

    Route::get('/add/product', AddProductComponent::class)->name('dev-add-product');
    Route::get('/edit/product/{id}', AddProductComponent::class)->name('dev-edit-product');
    Route::get('/shipping/manage', ShippingManager::class)->name('dev-shipping');

    Route::get('/orders/list', ListOrders::class)->name('dev-order.lists');
    Route::get('/orders/show/{order}', ViewOrder::class)->name('dev-order.show');
    Route::get('/orders/{order}/invoice', [AdminOrderPdfController::class, 'invoice'])->name('admin.orders.invoice');
    Route::get('/orders/{order}/packing-slip', [OrderPdfController::class, 'packingSlip'])->name('admin.orders.packingSlip');
    // settigns routes
    Route::get('/settings/design', DesignComponent::class)->name('dev-settings.design');
    Route::get('/settings/offercard', OfferCardComponent::class)->name('dev-settings.offer');
    Route::get('/settings/general', LogoAndLinks::class)->name('dev-settings.general');
});

// Protected dashboard route
Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('admin');
    // })->name('dashboard');

    Route::get('/dashboard/offers', OfferComponent::class)->name('dev-discounts');
    Route::get('/dashboard/coupons', CouponsComponent::class)->name('dev-coupons');
});

// web routes
Route::get('/', HomeComponent::class)->name('home');
Route::get('/cart', CartComponent::class)->name('web-cart');
Route::get('/checkout', CheckOutComponent::class)->name('web-check-out');
Route::get('/order-confirmation', ThanksComponent::class)->name('web-order-confirmation');
Route::get('/wishlist', WishManager::class)->name('web.wish');
Route::get('/shop', ShopComponent::class)->name('web.shop');
Route::get('/filter', [ShopController::class, 'index'])->name('web.filter');
Route::get('/contact-us', ContactUs::class)->name('web.contact-us');
Route::get('/about-us', AboutUs::class)->name('web.about-us');
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
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/order/{invoice}', OrderDetailComponent::class)->name('order.detail');

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

// Coming soon page
Route::view('/coming-soon', 'coming-soon')->name('coming-soon');
// notification
Route::post('/save-fcm-token', [NotificationController::class, 'saveToken']);

// Route::post('/send-notification', [NotificationController::class, 'testNotification'])->name('send.noti');


// user pages

require __DIR__.'/auth.php';
