<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// middleware
use App\Http\Middleware\AuthAsAdmin;
use App\Http\Middleware\CheckExpiryDate;

// controllers
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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TermsController;

// credentials
Route::post('/register', [CredentialController::class, 'register']);
Route::post('/login', [CredentialController::class, 'login']);

// create transaction
Route::post('/transactions', [TransactionController::class, 'createTransaction']);

// user details
Route::post('/user-details', [UserDetailsController::class, 'createUserDetails']);

// get all public articles
Route::get('/articles/public', [ArticleController::class, 'getAllPublicArticles']);

// Events
Route::get('/events', [EventController::class, 'getAllEvents']);
Route::get('/events/{id}', [EventController::class, 'getEventById']);

// Participants
Route::get('/participants/{id}', [ParticipantController::class, 'getParticipantById']);
Route::post('/participants', [ParticipantController::class, 'createParticipant']);

// Sliders
Route::get('/sliders', [SliderController::class, 'getAllSliders']);

// Announcements
Route::get('/announcements', [AnnouncementController::class, 'getAllAnnouncements']);

// latest announcement
Route::get('/announcements/latest', [AnnouncementController::class, 'getLatestAnnouncement']);
Route::get('/announcements/{id}', [AnnouncementController::class, 'getAnnouncementById']);

// Managements
Route::get('/managements', [ManagementController::class, 'getAllManagements']);
Route::get('/managements/{id}', [ManagementController::class, 'getManagementById']);

// Terms
Route::get('/terms', [TermsController::class, 'getAllTerms']);
Route::get('/terms/{id}', [TermsController::class, 'getTermById']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // logout
    Route::post('/logout', [CredentialController::class, 'logout']);

    // subscriptions update request
    Route::put('/subscriptions/{id}', [UserController::class, 'updateSubExpDate']);

    // middleware check expiry date
    Route::group(['middleware' => [CheckExpiryDate::class]], function () {
        // users
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);

        // user details
        Route::get('/user-details/{user_id}', [UserDetailsController::class, 'getUserDetailsByUserId']);
        Route::put('/user-details/{user_id}', [UserDetailsController::class, 'updateUserDetails']);

        // Articles
        Route::get('/articles', [ArticleController::class, 'getAllArticles']);
        Route::get('/articles/{id}', [ArticleController::class, 'getArticleById']);
        Route::get('/articles/category/{category}', [ArticleController::class, 'getArticlesByCategory']);

        // Galleries
        Route::get('/galleries', [GalleryController::class, 'getAllGalleries']);
        Route::get('/galleries/{id}', [GalleryController::class, 'getGalleryById']);
    });

    // middleware auth as admin
    Route::group(['middleware' => [AuthAsAdmin::class]], function () {
        // users
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::post('/users', [UserController::class, 'createUser']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

        // user details
        Route::get('/user-details', [UserDetailsController::class, 'getAllUserDetails']);
        Route::delete('/user-details/{user_id}', [UserDetailsController::class, 'deleteUserDetails']);

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
        Route::get('/sub-categories', [SubCategoryController::class, 'getAllSubCategories']);
        Route::get('/sub-categories/{id}', [SubCategoryController::class, 'getSubCategoryById']);
        Route::post('/sub-categories', [SubCategoryController::class, 'createSubCategory']);
        Route::put('/sub-categories/{id}', [SubCategoryController::class, 'updateSubCategory']);
        Route::delete('/sub-categories/{id}', [SubCategoryController::class, 'deleteSubCategory']);

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

        // Transaction
        Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);
        Route::get('/transactions/{id}', [TransactionController::class, 'getTransactionById']);
        Route::get('/transactions/user/{id}', [TransactionController::class, 'getTransactionsByUserId']);
        Route::get('/transactions/participant/{id}', [TransactionController::class, 'getTransactionsByParticipantId']);
        Route::put('/transactions/{id}', [TransactionController::class, 'updateTransaction']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'deleteTransaction']);

        // Payments
        Route::get('/payments', [PaymentController::class, 'getAllPayments']);
        Route::get('/payments/{id}', [PaymentController::class, 'getPaymentById']);
        Route::post('/payments', [PaymentController::class, 'createPayment']);
        Route::put('/payments/{id}', [PaymentController::class, 'updatePayment']);
        Route::delete('/payments/{id}', [PaymentController::class, 'deletePayment']);

        // Events
        Route::post('/events', [EventController::class, 'createEvent']);
        Route::put('/events/{id}', [EventController::class, 'updateEvent']);
        Route::delete('/events/{id}', [EventController::class, 'deleteEvent']);

        // Participants
        Route::get('/participants', [ParticipantController::class, 'getAllParticipants']);
        Route::put('/participants/{id}', [ParticipantController::class, 'updateParticipant']);
        Route::delete('/participants/{id}', [ParticipantController::class, 'deleteParticipant']);

        // Sliders
        Route::post('/sliders', [SliderController::class, 'createSlider']);
        Route::put('/sliders/{id}', [SliderController::class, 'updateSliderById']);
        Route::delete('/sliders/{id}', [SliderController::class, 'deleteSliderById']);

        // Terms
        Route::post('/terms', [TermsController::class, 'createTerm']);
        Route::put('/terms/{id}', [TermsController::class, 'updateTerm']);
        Route::delete('/terms/{id}', [TermsController::class, 'deleteTerm']);
    });
});