<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AgeGroupController;
use App\Http\Controllers\GameTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/data', [CartController::class, 'data'])->name('cart.data');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/payment/{order}', [CheckoutController::class, 'processPayment'])->name('checkout.process-payment');
Route::get('/checkout/verify/{order}', [CheckoutController::class, 'verifyPayment'])->name('checkout.verify');
Route::post('/guest-register', [CheckoutController::class, 'guestRegister'])->name('guest.register');

// صفحه اصلی (landing page) - بدون نیاز به authentication
Route::get('/', function () {
    $query = \App\Models\Product::query();

    // جستجو
    if (request()->filled('search')) {
        $search = request()->search;
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }

    // فیلتر دسته‌بندی
    if (request()->filled('category')) {
        $category = request()->category;
        $query->where(function($q) use ($category) {
            $q->whereJsonContains('category', $category)
              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(category, '$[0]')) = ?", [$category])
              ->orWhere('category', 'like', "%{$category}%");
        });
    }

    // فیلتر گروه سنی
    if (request()->filled('age_group')) {
        $ageGroup = request()->age_group;
        $query->where(function($q) use ($ageGroup) {
            $q->whereJsonContains('age_group', $ageGroup)
              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(age_group, '$[0]')) = ?", [$ageGroup])
              ->orWhere('age_group', 'like', "%{$ageGroup}%");
        });
    }

    // فیلتر نوع بازی
    if (request()->filled('game_type')) {
        $gameType = request()->game_type;
        $query->where(function($q) use ($gameType) {
            $q->whereJsonContains('game_type', $gameType)
              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(game_type, '$[0]')) = ?", [$gameType])
              ->orWhere('game_type', 'like', "%{$gameType}%");
        });
    }

    // فیلتر جنسیت
    if (request()->filled('gender')) {
        $query->byGender(request()->gender);
    }

    // مرتب‌سازی
    $sort = request()->get('sort', 'newest');
    switch ($sort) {
        case 'oldest':
            $query->oldest();
            break;
        case 'name-asc':
            $query->orderBy('title', 'asc');
            break;
        case 'name-desc':
            $query->orderBy('title', 'desc');
            break;
        case 'price-asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price-desc':
            $query->orderBy('price', 'desc');
            break;
        case 'newest':
        default:
            $query->latest();
            break;
    }

    $products = $query->paginate(12)->withQueryString();
    $categories = \App\Models\Category::all();
    $ageGroups = \App\Models\AgeGroup::all();
    $gameTypes = \App\Models\GameType::all();
    $sliders = \App\Models\Slider::active()->ordered()->get();
    $siteSettings = \App\Models\SiteSetting::current();

    // Check if this is an Ajax request
    if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
        return view('products-partial', compact('products', 'categories', 'ageGroups', 'gameTypes'));
    }

        return view('welcome', compact('products', 'categories', 'ageGroups', 'gameTypes', 'sliders', 'siteSettings'));
})->name('welcome');

// صفحه جزئیات محصول - بدون نیاز به authentication
Route::get('/product/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    $relatedProducts = \App\Models\Product::where('id', '!=', $id)
                                         ->limit(4)
                                         ->latest()
                                         ->get();

    return view('product-detail', compact('product', 'relatedProducts'));
})->name('product.show');

// Authentication Routes - بدون نیاز به authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// Logout route - نیاز به authentication
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Profile Routes for regular users - نیاز به authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Admin Panel Routes - نیاز به authentication
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        $products = \App\Models\Product::latest()->take(5)->get();
        return view('admin.dashboard', compact('products'));
    })->name('dashboard');

    // Profile Management - همه ادمین ها
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Products Management
    Route::resource('products', ProductController::class);

    // Lookup Tables Management
    Route::resource('age-groups', AgeGroupController::class);
    Route::resource('game-types', GameTypeController::class);
    Route::resource('categories', CategoryController::class);

    // Discounts Management
    Route::resource('discounts', DiscountController::class);
    Route::post('/discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggle-status');
    Route::get('/api/target-options', [DiscountController::class, 'getTargetOptions'])->name('discounts.target-options');

    // Slider Management
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::post('/sliders/{slider}/toggle-status', [\App\Http\Controllers\Admin\SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');

    // Site Settings
    Route::get('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('/site-settings/preview', [\App\Http\Controllers\Admin\SiteSettingController::class, 'show'])->name('site-settings.show');

    // Super Admin Only Routes
    Route::middleware('super_admin')->group(function () {
        // User Management
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    });
});
