<?php

use App\Http\Controllers\Admin\AlternativeController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\CriteriaPerbandinganController;
use App\Http\Controllers\Admin\SubCriteriaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RankingController;
use App\Http\Controllers\Admin\WoodController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('portal.index');

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Resource Routes (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resources([
            'kriteria' => CriteriaController::class,
            'wood' => WoodController::class,
            'wood/category' => CategoryController::class,
            'users' => UserController::class,
        ], ['except' => 'show']);
    });
    Route::delete('/dashboard/kriteria/destroy-all', [CriteriaController::class, 'destroyAll'])->name('kriteria.destroyAll');
    Route::delete('/dashboard/wood/destroy-all', [WoodController::class, 'destroyAll'])->name('wood.destroyAll');
    Route::post('kriteria/import', [CriteriaController::class, 'import'])->name('kriteria.import');
    Route::get('kriteria/export', [CriteriaController::class, 'export'])->name('kriteria.export');





    Route::get('/dashboard/sub-criteria', [SubCriteriaController::class, 'index'])->name('sub-criteria.index');
    Route::get('/dashboard/sub-criteria/create', [SubCriteriaController::class, 'create'])->name('sub-criteria.create');
    Route::post('/dashboard/sub-criteria', [SubCriteriaController::class, 'store'])->name('sub-criteria.store');
    Route::delete('/sub-criteria/{id}', [SubCriteriaController::class, 'destroy'])->name('sub-criteria.destroy');
    Route::get('/dashboard/sub-criteria/{id}/edit', [SubCriteriaController::class, 'edit'])->name('sub-criteria.edit');
    Route::put('/sub-criteria/{id}', [SubCriteriaController::class, 'update'])->name('sub-criteria.update');
    Route::delete('/dashboard/sub-criteria/destroy-all', [UserController::class, 'destroyAll'])->name('sub-criteria.destroyAll');
    Route::get('/dashboard/sub-criteria/export', [SubCriteriaController::class, 'export'])->name('sub-criteria.export');
    Route::post('/dashboard/sub-criteria/import', [SubCriteriaController::class, 'import'])->name('sub-criteria.import');


    Route::prefix('dashboard/wood')->middleware(['auth', 'admin'])->group(function () {
    // Route untuk resource category
    Route::resource('category', CategoryController::class);

    // Tambahan: route untuk menampilkan data kayu berdasarkan kategori
    Route::get('category/{category:slug}/woods', [CategoryController::class, 'woods'])->name('category.woods');
    Route::put('/dashboard/wood/category/{id}', [CategoryController::class, 'update'])->name('category.update');

});
    // Alternative (Alternatif) Routes
    Route::resource('alternatif', AlternativeController::class)->except(['show']);
    Route::get('alternatif/{wood_id}/edit', [AlternativeController::class, 'edit'])->name('alternatif.edit');
    Route::delete('alternatif/{wood_id}', [AlternativeController::class, 'destroy'])->name('alternatif.destroy');
    Route::put('/alternatif/{wood_id}', [AlternativeController::class, 'update'])->name('alternatif.update');
    Route::post('/alternatif/import', [AlternativeController::class, 'import'])->name('import');
    Route::get('/alternatif/export', [AlternativeController::class, 'export'])->name('export');

    Route::get('/alternatif/wood-by-category/{id}', [AlternativeController::class, 'getWoodByCategory']);
    Route::delete('/dashboard/alternatif/destroy-all', [AlternativeController::class, 'destroyAll'])->name('alternatif.destroyAll');



    // Wood update override
    Route::put('wood/{wood}', [WoodController::class, 'update'])->name('wood.update');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/{users}', [ProfileController::class, 'update'])->name('profile.update');

    // Category and Woods
    Route::get('wood/category/{category:slug}', [CategoryController::class, 'woods'])->name('category.woods');


    // Criteria Comparison
    Route::prefix('perbandingan')->group(function () {
        Route::get('/', [CriteriaPerbandinganController::class, 'index'])->name('perbandingan.index');
        Route::post('/', [CriteriaPerbandinganController::class, 'store'])->name('perbandingan.store');
        Route::get('{criteria_analysis}', [CriteriaPerbandinganController::class, 'show'])->name('perbandingan.show');
        Route::put('{criteria_analysis}', [CriteriaPerbandinganController::class, 'update'])->name('perbandingan.update');
        Route::delete('{criteria_analysis}', [CriteriaPerbandinganController::class, 'destroy'])->name('perbandingan.destroy');
        Route::get('result/{criteria_analysis}', [CriteriaPerbandinganController::class, 'result'])->name('perbandingan.result');
        Route::get('result/detailr/{criteria_analysis}', [CriteriaPerbandinganController::class, 'detailr'])->name('perbandingan.detailr');
    });

    // Ranking
    Route::prefix('ranking')->group(function () {
        Route::get('/', [RankingController::class, 'index'])->name('rank.index');
        Route::get('{criteria_analysis}', [RankingController::class, 'show'])->name('rank.show');
        Route::get('wood/{criteria_analysis}', [RankingController::class, 'final'])->name('rank.final');
        Route::get('wood/detailr/{criteria_analysis}', [RankingController::class, 'detailr'])->name('rank.detailr');
        Route::get('export/{criteria_analysis}', [RankingController::class, 'export'])->name('rank.export');
    });
Route::get('/dashboard/kayu/export', [WoodController::class, 'export'])->name('wood.export');
Route::post('/dashboard/kayu/import', [WoodController::class, 'import'])->name('wood.import');


    Route::delete('/dashboard/users/destroy-all', [UserController::class, 'destroyAll'])->name('users.destroyAll');

    // Import & Export
    Route::post('/dashboard/users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('/dashboard/users/export', [UserController::class, 'export'])->name('users.export');

    Route::post('alternatives/import', [AlternativeController::class, 'import'])->name('alternatives.import');
    Route::get('alternatives/export', [AlternativeController::class, 'export'])->name('alternatives.export');
});
