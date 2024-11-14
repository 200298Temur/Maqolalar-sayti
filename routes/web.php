<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FronController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LocalizationMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

// Route::get('setwebhook',function(){
//     $response = Telegram::setWebhook(['url' => 'https://5387-93-188-83-205.ngrok-free.app/api/telegram/webhook']);
// });




Route::get('locale/{lang}', [LocaleController::class, 'setLocale'])->name('locale.set');
Route::get('prefix/{lang}', [LocaleController::class, 'setPrefix'])->name('prefix.set');

Route::get('/', function () {
    $locale = config('app.locale');
    return redirect($locale);
});

Route::group(['prefix' => '/en', 'middleware' =>SetLocale::class], function () {
    group_routes();
});
Route::group(['prefix' => '/uz', 'middleware' =>SetLocale::class], function () {
    group_routes();
});

function group_routes () {
    Route::get('/', [FronController::class, 'index'])->name('front.index');
    Route::get('posts/show/{id}', [FronController::class, 'show'])->name('front.show');
    Route::get('posts/see/{id}', [FronController::class, 'PostSee'])->name('front.see');
}

Route::prefix('admin')->middleware(['auth', LocalizationMiddleware::class])->group(function () {
    Route::get('/', action: function () {
        return view('dashboard');
    })->middleware('verified')->name('admin.dashboard');

    Route::get('posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
    Route::get('/roles/create',[RoleController::class,'create'])->name('roles.create');
    Route::post('/roles',[RoleController::class,'store'])->name('roles.store');
    Route::get('/roles/{id}/edit',[RoleController::class,'edit'])->name('roles.edit');
    Route::post('/roles/{id}',[RoleController::class,'update'])->name('roles.update');
    Route::get('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Route::get('/permissions',[PermissionController::class,'index'])->name('permissions.index');
    // Route::get('/permissions/create',[PermissionController::class,'create'])->name('permissions.create');
    // Route::post('/permissions',[PermissionController::class,'store'])->name('permissions.store');
    // Route::get('/permissions/{id}/edit',[PermissionController::class,'edit'])->name('permissions.edit');
    // Route::post('/permissions/{id}',[PermissionController::class,'update'])->name('permissions.update');
    // Route::get('/permissions/{role}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


    Route::get('/users',[UserController::class,'index'])->name('users.index');
    Route::get('/users/create',[UserController::class,'create'])->name('users.create');
    Route::post('/users',[UserController::class,'store'])->name('users.store');
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
    Route::post('/users/{id}',[UserController::class,'update'])->name('users.update');
    Route::get('/users/{role}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');
Route::post('posts/upload', [PostController::class, 'upload'])->name('posts.uploadMedia');

// Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|uz'], 'middleware' => 'auth'], function () {
//     Route::prefix('admin')->group(function () {
        
//     });
// });

// Require authentication routes
require __DIR__.'/auth.php';
