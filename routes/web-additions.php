
use App\Http\Controllers\CareerProfileController;

// ===== CV PORTAL PROFILE 2.0 =====
Route::middleware('auth')->group(function () {
    Route::post('/candidate/profile/settings', [CareerProfileController::class, 'saveSettings'])->name('candidate.profile.settings');

    Route::post('/candidate/profile/section/{section}', [CareerProfileController::class, 'saveSection'])->name('candidate.profile.section.save');
    Route::delete('/candidate/profile/section/{section}/{id}', [CareerProfileController::class, 'deleteSection'])->name('candidate.profile.section.delete');

    Route::post('/companies/{company}/follow', [CareerProfileController::class, 'followCompany'])->name('company.follow');
    Route::delete('/companies/{company}/follow', [CareerProfileController::class, 'unfollowCompany'])->name('company.unfollow');

    Route::get('/cover-letters', [CareerProfileController::class, 'coverLetters'])->name('cover-letters.index');
    Route::post('/cover-letters', [CareerProfileController::class, 'saveCoverLetter'])->name('cover-letters.save');
    Route::delete('/cover-letters/{id}', [CareerProfileController::class, 'deleteCoverLetter'])->name('cover-letters.delete');
});

Route::get('/profile/{userId}', [CareerProfileController::class, 'publicProfile'])->name('profile.public');
