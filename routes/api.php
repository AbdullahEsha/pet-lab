<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthAsAdmin;
use App\Http\Middleware\CheckExpiryDate;

use App\Http\Controllers\CredentialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TransactionController;


Route::post('/register', [CredentialController::class, 'register']);
Route::post('/login', [CredentialController::class, 'login']);

// create transaction
Route::post('/transactions', [TransactionController::class, 'createTransaction']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [CredentialController::class, 'logout']);

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'getAllAnnouncements']);
    Route::get('/announcements/{id}', [AnnouncementController::class, 'getAnnouncementById']);

    // Articles
    Route::get('/articles', [ArticleController::class, 'getAllArticles']);
    Route::get('/articles/{id}', [ArticleController::class, 'getArticleById']);

    // Galleries
    Route::get('/galleries', [GalleryController::class, 'getAllGalleries']);
    Route::get('/galleries/{id}', [GalleryController::class, 'getGalleryById']);

    // Managements
    Route::get('/managements', [ManagementController::class, 'getAllManagements']);
    Route::get('/managements/{id}', [ManagementController::class, 'getManagementById']);

    Route::group(['middleware' => [AuthAsAdmin::class]], function () {
        // users
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::post('/users', [UserController::class, 'createUser']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

        // Announcements
        Route::post('/announcements', [AnnouncementController::class, 'createAnnouncement']);
        Route::put('/announcements/{id}', [AnnouncementController::class, 'updateAnnouncement']);
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'deleteAnnouncement']);

        // Articles
        Route::post('/articles', [ArticleController::class, 'createArticle']);
        Route::put('/articles/{id}', [ArticleController::class, 'updateArticle']);
        Route::delete('/articles/{id}', [ArticleController::class, 'deleteArticle']);

        // Categories   
        Route::get('/categories', [CategoryController::class, 'getAllCategories']);
        Route::get('/categories/{id}', [CategoryController::class, 'getCategoryById']);
        Route::post('/categories', [CategoryController::class, 'createCategory']);
        Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
        Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

        // SubCategories
        Route::get('/subcategories', [SubCategoryController::class, 'getAllSubCategories']);
        Route::get('/subcategories/{id}', [SubCategoryController::class, 'getSubCategoryById']);
        Route::post('/subcategories', [SubCategoryController::class, 'createSubCategory']);
        Route::put('/subcategories/{id}', [SubCategoryController::class, 'updateSubCategory']);
        Route::delete('/subcategories/{id}', [SubCategoryController::class, 'deleteSubCategory']);

        // Folders
        Route::get('/folders', [FolderController::class, 'getAllFolders']);
        Route::get('/folders/{id}', [FolderController::class, 'getFolderById']);
        Route::post('/folders', [FolderController::class, 'createFolder']);
        Route::put('/folders/{id}', [FolderController::class, 'updateFolder']);
        Route::delete('/folders/{id}', [FolderController::class, 'deleteFolder']);

        // Galleries
        Route::post('/galleries', [GalleryController::class, 'createGallery']);
        Route::put('/galleries/{id}', [GalleryController::class, 'updateGallery']);
        Route::delete('/galleries/{id}', [GalleryController::class, 'deleteGallery']);

        // Managements
        Route::get('/managements', [ManagementController::class, 'getAllManagements']);
        Route::get('/managements/{id}', [ManagementController::class, 'getManagementById']);
        Route::post('/managements', [ManagementController::class, 'createManagement']);
        Route::put('/managements/{id}', [ManagementController::class, 'updateManagement']);
        Route::delete('/managements/{id}', [ManagementController::class, 'deleteManagement']);

        // Positions
        Route::get('/positions', [PositionController::class, 'getAllPositions']);
        Route::get('/positions/{id}', [PositionController::class, 'getPositionById']);
        Route::post('/positions', [PositionController::class, 'createPosition']);
        Route::put('/positions/{id}', [PositionController::class, 'updatePosition']);
        Route::delete('/positions/{id}', [PositionController::class, 'deletePosition']);

        // transaction
        Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);
        Route::get('/transactions/{id}', [TransactionController::class, 'getTransactionById']);
        Route::get('/transactions/user/{id}', [TransactionController::class, 'getTransactionsByUserId']);
        Route::put('/transactions/{id}', [TransactionController::class, 'updateTransaction']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'deleteTransaction']);

        // payments
        Route::get('/payments', [PaymentController::class, 'getAllPayments']);
        Route::get('/payments/{id}', [PaymentController::class, 'getPaymentById']);
        Route::post('/payments', [PaymentController::class, 'createPayment']);
        Route::put('/payments/{id}', [PaymentController::class, 'updatePayment']);
        Route::delete('/payments/{id}', [PaymentController::class, 'deletePayment']);
    });
});