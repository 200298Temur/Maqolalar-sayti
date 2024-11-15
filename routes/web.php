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
use App\Http\Middleware\PermissionMiddleware;
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

Route::prefix('admin')->middleware(['auth', LocalizationMiddleware::class,PermissionMiddleware::class])->group(function () {
    Route::get('/', action: function () {
        return view('dashboard');
    })->middleware('verified')->name('admin.dashboard');

    Route::get('posts/show/{id}', [PostController::class, 'show'])->name('post.show');
    Route::get('posts', [PostController::class, 'index'])->name('post.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('posts', [PostController::class, 'store'])->name('post.store');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::post('posts/{id}', [PostController::class, 'update'])->name('post.update');
    Route::get('posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');

    Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('categories/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
    Route::get('/roles',[RoleController::class,'index'])->name('role.index');
    Route::get('/roles/create',[RoleController::class,'create'])->name('role.create');
    Route::post('/roles',[RoleController::class,'store'])->name('role.store');
    Route::get('/roles/{id}/edit',[RoleController::class,'edit'])->name('role.edit');
    Route::post('/roles/{id}',[RoleController::class,'update'])->name('role.update');
    Route::get('/roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Route::get('/permissions',[PermissionController::class,'index'])->name('permissions.index');
    // Route::get('/permissions/create',[PermissionController::class,'create'])->name('permissions.create');
    // Route::post('/permissions',[PermissionController::class,'store'])->name('permissions.store');
    // Route::get('/permissions/{id}/edit',[PermissionController::class,'edit'])->name('permissions.edit');
    // Route::post('/permissions/{id}',[PermissionController::class,'update'])->name('permissions.update');
    // Route::get('/permissions/{role}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


    Route::get('/users',[UserController::class,'index'])->name('user.index');
    Route::get('/users/create',[UserController::class,'create'])->name('user.create');
    Route::post('/users',[UserController::class,'store'])->name('user.store');
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::post('/users/{id}',[UserController::class,'update'])->name('user.update');
    Route::get('/users/{role}', [UserController::class, 'destroy'])->name('user.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('posts/search', [PostController::class, 'search'])->name('post.search');
Route::post('posts/upload', [PostController::class, 'upload'])->name('post.uploadMedia');

// Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|uz'], 'middleware' => 'auth'], function () {
//     Route::prefix('admin')->group(function () {
        
//     });
// });

// Require authentication routes
require __DIR__.'/auth.php';
