<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Boarding House 
Route::get('/boarding-houses', [BoardingHouseController::class, 'seeMore'])->name('boarding_house.see_more');
// Boarding house creation form route
Route::middleware(['auth', 'verify.user', 'checkTrial'])->group(function () {
Route::get('/list-boarding-house', [BoardingHouseController::class, 'create'])->middleware(EnsureUserIsAuthenticated::class)->name('boarding_house.create');
Route::post('/boarding-house/store', [BoardingHouseController::class, 'store'])->middleware('auth')->name('boarding_house.store');
});
//Boarding-house-owner POV
Route::get('/boardinghouse/{boardingHouse}/rooms', [RoomController::class, 'index'])->name('boarding_house-rooms.index');
//Display near boarding houses
Route::get('/api/nearest-boarding-houses', [UserController::class, 'getNearestBoardingHouses']);
//Rooms
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
//Room create
Route::post('/boarding-house/{boardingHouse}/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

//Room Reservation
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

//User UI when clicking listing their BH (Guide)
Route::get('/listing-guide', [BoardingHouseController::class,'listingGuide'])->name('boarding_house.guide'); 

Route::get('/my-boarding-houses/{id}/house-profile', [BoardingHouseController::class, 'showHouse'])->name('boarding_house.show');
Route::middleware('auth')->group(function () {
//house owner users
Route::get('/my-boarding-houses', [BoardingHouseController::class, 'viewHouses'])->name('boarding_house.view');
Route::get('/my-boarding-houses/create', [BoardingHouseController::class, 'create'])->name('boardinghouse.create');
Route::post('/my-boarding-houses', [BoardingHouseController::class, 'store'])->name('boardinghouse.store');
Route::get('/my-boarding-houses/{id}/House-Info', [BoardingHouseController::class, 'show'])->name('boarding_house.edit');
Route::post('/upload-house-images', [ImageController::class, 'store'])->name('house-image.store');

//Owner Reservation
Route::get('/owner/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('my-reservations', [ReservationController::class, 'myReservations'])->name('reservations.myReservations');
Route::get('/reservation/{id}/download', [ReservationController::class, 'download'])->name('reservation.download');
Route::get('/reservation/{id}/receipt/download', [ReservationController::class, 'downloadReceipt'])->name('reservation.receipt.download');

Route::delete('reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
Route::post('/owner/reservations/{reservation}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');
Route::post('/owner/reservations/{reservation}/decline', [ReservationController::class, 'decline'])->name('reservations.decline');
Route::delete('/owner/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
// Route to display accepted reservations
Route::get('/reservations/accepted', [ReservationController::class, 'showAcceptedReservations'])->name('reservations.accepted');
Route::delete('/owner/reservations/{reservation}/delete', [ReservationController::class, 'acceptedDestroy'])->name('reservations.accepted_destroy');

//Verifications
Route::get('/verification', [VerificationController::class, 'show'])->name('verification.page');
Route::post('/verification/photo', [VerificationController::class, 'uploadPhoto'])->name('verification.photo');
Route::post('/verification/business-permit/upload', [VerificationController::class, 'uploadBusinessPermit'])->name('verification.business_permit');
Route::post('/verification/phone', [VerificationController::class, 'verifyPhone'])->name('verification.phone');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware('auth')->name('verification.send');
//property updates
Route::post('/my-boarding-houses/{id}/update-info', [BoardingHouseController::class, 'updateInfo'])->name('boardinghouse.update-info');
Route::put('/my-boarding-houses/{id}/update-amenities', [BoardingHouseController::class, 'updateAmenities'])->name('boardinghouse.update-amenities');
Route::post('/my-boarding-houses/{id}/update-description', [BoardingHouseController::class, 'updateDescription'])->name('boardinghouse.update-description');
Route::post('/my-boarding-houses/{id}/update-policies', [BoardingHouseController::class, 'updatePolicies'])->name('boardinghouse.update-policies');
Route::post('/images/{boardingHouseId}', [ImageController::class, 'storeImages'])->name('moreImages.store');
    //comments and ratings
Route::post('/boarding-houses/{boardingHouse}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
//Not logged in users
Route::get('/', [UserController::class,'index'])->name('homepage');   
Route::get('/dashboard', [UserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard'); 
Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload_photo'); 
//show all rooms in the homepage
Route::get('/rooms', [RoomController::class, 'allRooms'])->name('rooms.index');
Route::get('/search', [UserController::class, 'search'])->name('boarding_house.search');
Route::get('/search-filter', [UserController::class, 'searchAndFilter'])->name('boarding_house.search_filter');

//report
Route::get('/user/reports/create', [ReportController::class, 'create'])->name('user.reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/user/reports', [ReportController::class, 'index'])->name('user.reports.index');


//User Routes
Route::middleware(['auth', 'userMiddleware'])->group(function(){
Route::get('/profile', [ProfileController::class,'index'])->name('profile'); 
});
//Admin routes
Route::middleware(['auth', 'adminMiddleware'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class,'index'])->name('admin.dashboard');   
    Route::get('/admin/profile', [AdminController::class,'profile'])->name('admin.profile'); 
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.manage.users'); 
    Route::get('/admin/listings', [AdminController::class, 'manageListings'])->name('admin.manage.listings');
    Route::delete('/admin/dashboard/{id}', [AdminController::class, 'destroy'])->name('admin_users.destroy');     
    Route::patch('/admin/business-permit/{id}', [AdminController::class, 'updateBusinessPermitStatus'])->name('business-permit.update');
    Route::get('/admin/pending-permits', [AdminController::class, 'showPendingPermits'])->name('admin.pending-permits');
    Route::delete('/admin/dashboard/boarding-houses/{id}', [AdminController::class, 'destroyBoardingHouse'])->name('admin_properties.destroy');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{report}', [ReportController::class, 'show'])->name('admin.reports.show');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');

});


//WishLists
Route::middleware('auth')->group(function () {
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::delete('/wishlist/remove/{boardingHouseId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

//Subscription
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
Route::post('/webhook/paymongo', [SubscriptionController::class, 'handle'])->name('webhook.paymongo');


//Payment


});


Route::get('/free-trial', [SubscriptionController::class, 'freeTrial'])->name('free-trial')->middleware('auth');