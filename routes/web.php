<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Admin\ShippingCargesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Front\CMSPageController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaypalController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\RatingsController as FrontRatingsController;
use App\Http\Controllers\Front\UserController;
use App\Models\Category;
use App\Models\CmsPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->group(function () {
    // Admin all route here
    Route::any('/', [AdminController::class, 'login']);

    // Admin all routes protecetd form admin guard
    Route::group(['middleware' => ['admin']], function(){
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/settings', [AdminController::class, 'settings']);
        Route::get('/logout', [AdminController::class, 'logout']);
        Route::post('/check-current-pwd', [AdminController::class, 'chkCurrentPassword']);
        Route::any('/update-admin-details', [AdminController::class, 'updateAdminDetails']);


        // Section Route
        Route::get('/sections', [SectionController::class, 'sections'])->name('sections');
        Route::post('/update-section-status', [SectionController::class, 'updateSectionStatus']);


        // Brand Route
        Route::get('/brands', [BrandController::class, 'brands'])->name('brands');
        Route::post('/update-brand-status', [BrandController::class, 'updateBrandstatus']);
        Route::any('/add-edit-brand/{id?}', [BrandController::class, 'addEditBrand']);
        Route::get('/delete-brand/{id}', [BrandController::class, 'deleteBrand']);


        // Category Route
        Route::get('/categories', [CategoryController::class, 'categories']);
        Route::post('/update-categories-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::any('/add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
        Route::post('/append-category-level', [CategoryController::class, 'appendCategoryLevel']);
        Route::get('/delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);
        Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);

        // Product Route
        Route::get('/products', [ProductController::class, 'products']);
        Route::post('/update-products-status', [ProductController::class, 'updateProductStatus']);
        Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
        Route::any('/add-edit-product/{id?}', [ProductController::class, 'addEditProduct']);
        Route::get('/delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);
        Route::get('/delete-product-video/{id}', [ProductController::class, 'deleteProductVideo']);

        // Attributes
        Route::any('/add-attribute/{id?}', [ProductController::class, 'addAttribute']);
        Route::post('/edit-attribute', [ProductController::class, 'editAttribute']);
        Route::post('/update-attributes-status', [ProductController::class, 'updateAttributeStatus']);
        Route::get('/delete-attribute/{id}', [ProductController::class, 'deleteAttribute']);

        // Add Images
        Route::any('/add-images/{id?}', [ProductController::class, 'addImages']);
        Route::post('/update-images-status', [ProductController::class, 'updateImageStatus']);
        Route::get('/delete-image/{id}', [ProductController::class, 'deleteImage']);


        // Banner Route
        Route::get('/banners', [BannerController::class, 'banners'])->name('banners');
        Route::post('/update-banner-status', [BannerController::class, 'updateBannerstatus']);
        Route::any('/add-edit-banner/{id?}', [BannerController::class, 'addEditBanner']);
        Route::get('/delete-banner/{id}', [BannerController::class, 'deleteBanner']);
        Route::get('/delete-banner-image/{id}', [BannerController::class, 'deleteBannerImage']);


        // Coupon Route
        Route::get('/coupons', [CouponController::class, 'coupons'])->name('coupons');
        Route::post('/update-coupon-status', [CouponController::class, 'updateCouponstatus']);
        Route::any('/add-edit-coupon/{id?}', [CouponController::class, 'addEditCoupon']);
        Route::get('/delete-coupon/{id}', [CouponController::class, 'deleteCoupon']);
        Route::get('/delete-coupon-image/{id}', [CouponController::class, 'deleteCouponImage']);


        // Order Route
        Route::get('/orders', [AdminOrdersController::class, 'orders']);
        Route::get('/orders/{id}', [AdminOrdersController::class, 'orderDetails']);
        Route::post('/update-order-status', [AdminOrdersController::class, 'updateOrderStatus']);
        Route::get('/view-order-invoice/{id}', [AdminOrdersController::class, 'viewOrderInvoice']);
        Route::get('/print-pdf-invoice/{id}', [AdminOrdersController::class, 'printPDFInvoice']);

        // View Orders Charts Report Route
        Route::get('/view-orders-charts', [AdminOrdersController::class, 'viewOrdersCharts']);


        // Shipping Charges Route
        Route::get('/shipping-charges', [ShippingCargesController::class, 'viewShippingCharges']);
        Route::any('/edit-shipping-charges/{id}', [ShippingCargesController::class, 'editShippingCharges']);
        Route::post('/update-shipping-status', [ShippingCargesController::class, 'updateShippingStatus']);

        // Users Route
        Route::get('/users', [UsersController::class, 'users']);
        Route::post('/update-user-status', [UsersController::class, 'updateUserStatus']);

        // View Users Charts Report Route
        Route::get('/view-users-charts', [UsersController::class, 'viewUsersCharts']);
        // View User countries Pie Charts Route
        Route::get('/view-users-countries', [UsersController::class, 'viewUsersCountries']);

        // CMS Pages Route
        Route::get('/cms-pages', [CmsController::class, 'cmsPages']);
        Route::post('/update-cms-page-status', [CmsController::class, 'updateCmsPagetatus']);
        Route::any('/add-edit-cms-page/{id?}', [CmsController::class, 'addEditCmsPage']);
        Route::get('/delete-cms-page/{id}', [CmsController::class, 'deleteCmsPage']);


        // Admins / SubAdmins Route
        Route::get('/admins-subadmins', [AdminController::class, 'adminsSubadmins']);
        Route::post('/update-admins-subadmins-status', [AdminController::class, 'updateAdminsSubadminsstatus']);
        Route::any('/add-edit-admins-subadmins/{id?}', [AdminController::class, 'addEditAdminsSubadmins']);
        Route::get('/delete-admins-subadmins/{id}', [AdminController::class, 'deleteAdminsSubadmins']);
        Route::any('/update-roles/{id}', [AdminController::class, 'UpdateRoles']);

        // Other Settings Route
        Route::any('/update-other-settings', [AdminController::class, 'updateOtherSettings']);

        // Currency Route
        Route::get('/currencies', [CurrencyController::class, 'currencies']);
        Route::post('/update-currency-status', [CurrencyController::class, 'updateCurrencyStatus']);
        Route::any('/add-edit-currency/{id?}', [CurrencyController::class, 'addEditCurrency']);
        Route::get('/delete-currency/{id}', [CurrencyController::class, 'deleteCurrency']);

        // Rating Route
        Route::get('/ratings', [RatingsController::class, 'ratings']);
        Route::post('/update-rating-status', [RatingsController::class, 'updateRatingStatus']);

        // Return Request
        Route::get('/return-request', [AdminOrdersController::class, 'returnRequest']);
        Route::post('/return-request/update', [AdminOrdersController::class, 'returnRequestUpdate']);

    });
});


Route::namespace('Front')->group(function(){
    Route::get('/', [IndexController::class, 'index']);

    //Listing/Cotegories Route
    // Route::get('/{url}', [ProductsController::class, 'listing']);
    $catURL = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach($catURL as $url){
        Route::get('/'.$url, [ProductsController::class, 'listing']);
    }

    //CMS Page Route;
    $cmsURL = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach($cmsURL as $url){
        Route::get('/'.$url, [CMSPageController::class, 'cmsPage']);
    }

    // product detail page
    Route::get('/product/{id}', [ProductsController::class, 'detail']);

    // get product attribute price
    Route::post('/get-product-price', [ProductsController::class, 'getProductPrice']);

    // Add To Cart
    Route::post('/add-to-cart', [ProductsController::class, 'addToCart']);

    // Shopping Cart Page
    Route::get('/cart', [ProductsController::class, 'cart']);

    // Update cart item qty
    Route::post('/update-cart-item-qty', [ProductsController::class, 'updateCartItemQty']);

    // Delete cart item qty
    Route::post('/delete-cart-item-qty', [ProductsController::class, 'deleteCartItem']);


    // Login / Register Page
    Route::get('/login-register', ['as'=>'login','uses'=>'\App\Http\Controllers\Front\UserController@loginRegister']);

    // Login User
    Route::post('/login', [UserController::class, 'loginUser']);

    // Register User
    Route::post('/register', [UserController::class, 'registerUser']);

    // confirm email active account
    Route::any('/confirm/{email}', [UserController::class, 'confirmAccount']);

    // Check if email already exists or not
    Route::any('/check-email', [UserController::class, 'checkEmail']);

    // User Forgot Password
    Route::any('/forgot_password', [UserController::class, 'forgotPassword']);

    // Check Delivery Pincode
    Route::post('/check-pincode', [ProductsController::class, 'checkPincode']);

    // Search Product
    Route::get('/search-products', [ProductsController::class, 'listing']);

    // Contact Route
    Route::any('/contact', [CMSPageController::class, 'contact']);

    // Review & Rating Route
    Route::any('/add-rating', [FrontRatingsController::class, 'addRating']);

    Route::group(['middleware' => ['auth']], function(){
        // User Logout
        Route::get('/logout', [UserController::class, 'logout']);

        // User Account
        Route::any('/account', [UserController::class, 'account']);

        // User Orders
        Route::get('/orders', [OrdersController::class, 'orders']);

        // User Order Details
        Route::get('order-details/{id}', [OrdersController::class, 'orderDetials']);

        // User Cancel Orders
        Route::any('/orders/{id}/cancel', [OrdersController::class, 'cancelOrder']);

        // User Return Orders
        Route::any('/orders/{id}/return', [OrdersController::class, 'returnOrder']);

        // Check user password
        Route::post('/check-user-password', [UserController::class, 'checkUserPassword']);

        // Update user password
        Route::post('/update-user-password', [UserController::class, 'updateUserPassword']);

        // Apply Coupon
        Route::post('/apply-coupon', [ProductsController::class, 'applyCoupon']);

        // Checkout
        Route::any('/checkout', [ProductsController::class, 'checkout']);

        // Add Edit Delivery Address
        Route::any('/add-edit-delivery-address/{id?}', [ProductsController::class, 'addEditDeliveryAddress']);

        // Delete Delivery Address
        Route::get('/delete-delivery-address/{id}', [ProductsController::class, 'deleteDeliveryAddress']);

        // Thanks
        Route::get('/thanks', [ProductsController::class, 'thanks']);

        // Paypal
        Route::get('/paypal', [PaypalController::class, 'paypal']);

        // Paypal Success
        Route::get('/paypal/success', [PaypalController::class, 'success']);

        // Paypal Fail
        Route::get('/paypal/fail', [PaypalController::class, 'fail']);

        // Paypal IPN (instant payment notification)
        Route::any('/paypal/ipn', [PaypalController::class, 'ipn']);

        // Update Wishlist Route
        Route::post('/update-wishlist', [ProductsController::class, 'updateWishlist']);

        // Wishlist
        Route::get('/wishlist', [ProductsController::class, 'wishlist']);

        // Delete Wishlist item
        Route::post('/delete-wishlist-item', [ProductsController::class, 'deleteWishlistItem']);
    });


});
