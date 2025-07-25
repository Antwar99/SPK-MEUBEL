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

// Auth
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Admin-only Resource Routes
    Route::middleware('admin')->group(function () {
        Route::resources([
            'kriteria' => CriteriaController::class,
            'wood' => WoodController::class,
            'users' => UserController::class,
        ], ['except' => 'show']);

        // Category
        Route::prefix('wood')->group(function () {
            Route::resource('category', CategoryController::class);
            Route::get('category/{category:slug}/woods', [CategoryController::class, 'woods'])->name('category.woods');
        });
    });

    // Criteria
    Route::delete('/dashboard/kriteria/destroy-all', [CriteriaController::class, 'destroyAll'])->name('kriteria.destroyAll');
    Route::post('kriteria/import', [CriteriaController::class, 'import'])->name('kriteria.import');
    Route::get('kriteria/export', [CriteriaController::class, 'export'])->name('kriteria.export');

    // Sub Criteria
    Route::get('sub-criteria', [SubCriteriaController::class, 'index'])->name('sub-criteria.index');
    Route::get('sub-criteria/create', [SubCriteriaController::class, 'create'])->name('sub-criteria.create');
    Route::post('sub-criteria', [SubCriteriaController::class, 'store'])->name('sub-criteria.store');
    Route::get('sub-criteria/{id}/edit', [SubCriteriaController::class, 'edit'])->name('sub-criteria.edit');
    Route::put('sub-criteria/{id}', [SubCriteriaController::class, 'update'])->name('sub-criteria.update');
    Route::delete('sub-criteria/{id}', [SubCriteriaController::class, 'destroy'])->name('sub-criteria.destroy');
    Route::delete('/dashboard/sub-criteria/destroy-all', [SubCriteriaController::class, 'destroyAll'])->name('sub-criteria.destroyAll');
    Route::post('sub-criteria/import', [SubCriteriaController::class, 'import'])->name('sub-criteria.import');
    Route::get('sub-criteria/export', [SubCriteriaController::class, 'export'])->name('sub-criteria.export');

    // Alternative
    Route::resource('alternatif', AlternativeController::class)->except(['show']);
    Route::post('alternatif/import', [AlternativeController::class, 'import'])->name('alternatives.import');
    Route::get('alternatif/export', [AlternativeController::class, 'export'])->name('alternatives.export');
    Route::delete('/dashboard/alternatif/destroy-all', [AlternativeController::class, 'destroyAll'])->name('alternatif.destroyAll');
    Route::get('alternatif/wood-by-category/{id}', [AlternativeController::class, 'getWoodByCategory'])->name('alternatif.wood-by-category');

    // Wood Import/Export
    Route::post('wood/import', [WoodController::class, 'import'])->name('wood.import');
    Route::get('wood/export', [WoodController::class, 'export'])->name('wood.export');
    Route::delete('/dashboard/wood/destroy-all', [WoodController::class, 'destroyAll'])->name('wood.destroyAll');

    // User Import/Export
    Route::delete('users/destroy-all', [UserController::class, 'destroyAll'])->name('users.destroyAll');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/{users}', [ProfileController::class, 'update'])->name('profile.update');

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
});
