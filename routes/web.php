<?php

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

// Routes for Landing Page starts
Route::get('/', 'Web\WebController@index')->name('front');
Route::get('/demo', 'Web\WebController@demo')->name('demo');
Route::get('/modules-of-hms', 'Web\WebController@modulesOfHms')->name('modules-of-hms');
// Routes for Landing Page ends

// Routes for Enquiry Form
Route::post('send-enquiry', 'EnquiryController@store')->name('send.enquiry');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified');

Route::group(['middleware' => ['auth']], function () {
    Route::get('profile', 'ProfileController@editProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::post('profile-update', 'ProfileController@profileUpdate');
    Route::post('update-language', 'ProfileController@updateLanguage');


    Route::group(['middleware' => ['xss']], function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', 'UserController@index')->middleware('modules')->name('index');
            Route::get('/create', 'UserController@create')->name('create');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/{id}/edit', 'UserController@edit')->name('edit');
            Route::put('/{id}', 'UserController@update')->name('update');
            Route::delete('/{id}', 'UserController@destroy')->name('destroy');
        });



        Route::prefix('/suppliers')->name('suppliers.')->group(function () {
            Route::get('/', 'SupplierController@index')->name('index')->middleware('modules');
            Route::get('/create', 'SupplierController@create')->name('create');
            Route::get('/{supplier}', 'SupplierController@show')->name('show');
            Route::post('/patients', 'SupplierController@store')->name('store');
            Route::delete('/{supplier}', 'SupplierController@destroy')->name('destroy');
            Route::post('/{supplier}/salesmans', 'SupplierController@createSalesman')->name('createSalesman');
            Route::delete('/{supplier}/salesmans/{salesman}', 'SupplierController@destroySalesman')->name('destroy_salesman');
            Route::patch('/{supplier}', 'SupplierController@update')->name('update');
            Route::get('/{supplier}/edit', 'SupplierController@edit')->name('edit');
        });

        Route::prefix('patients')->name('patients.')->group(function () {
            Route::get('/', 'PatientController@index')->name('index')->middleware('modules');
            Route::get('/create', 'PatientController@create')->name('create');
            Route::get('/{patient}', 'PatientController@show')->name('show');
            Route::post('/patients', 'PatientController@store')->name('store');
            Route::delete('/{patient}', 'PatientController@destroy')->name('destroy');
            Route::patch('/{patient}', 'PatientController@update')->name('update');
            Route::get('/{patient}/edit', 'PatientController@edit')->name('edit');
            Route::post('/{patient}/active-deactive', 'PatientController@activeDeactiveStatus');
            Route::get('export-patients', 'PatientController@patientExport')->name('excel');
        });

        Route::prefix('medics')->name('medics.')->group(function () {
            Route::get('/', 'MedicController@index')->name('index')->middleware('modules');
            Route::post('/', 'MedicController@store')->name('store');
            Route::get('/create', 'MedicController@create')->name('create');
            Route::get('/{medic}', 'MedicController@show')->name('show');
            Route::delete('/{medic}', 'MedicController@destroy')
                ->name('destroy');
            Route::patch('/{medic}', 'MedicController@update')
                ->name('update');
            Route::get('/{medic}/edit', 'MedicController@edit')
                ->name('edit');
            Route::post('/{medic}/active-deactive', 'MedicController@activeDeactiveStatus');
            Route::get('export-patients', 'MedicController@patientExport')->name('patient.excel');
        });

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', 'ProductCategoryController@index')->middleware('modules')->name('index');
            Route::get('/create', 'ProductCategoryController@create')->name('create');
            Route::post('/', 'ProductCategoryController@store')->name('store');
            Route::get('/{id}/edit', 'ProductCategoryController@edit')->name('edit');
            Route::put('/{id}', 'ProductCategoryController@update')->name('update');
            Route::delete('/{id}', 'ProductCategoryController@destroy')->name('destroy');
        });

        Route::prefix('brands')->name('brands.')->group(function () {
            Route::get('/', 'ProductBrandController@index')->name('index')->middleware('modules');
            Route::get('/create', 'ProductBrandController@create')->name('create');
            Route::get('/{brand}', 'ProductBrandController@show')->name('show');
            Route::post('/', 'ProductBrandController@store')->name('store');
            Route::delete('/{brand}', 'ProductBrandController@destroy')->name('destroy');
            Route::put('/{brand}', 'ProductBrandController@update')->name('update');
            Route::get('/{brand}/edit', 'ProductBrandController@edit')->name('edit');
        });
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', 'ProductController@index')->name('index')->middleware('modules');
            Route::get('/create', 'ProductController@create')->name('create');
            Route::post('/', 'ProductController@store')->name('store');
            Route::delete('/{product}', 'ProductController@destroy')->name('destroy');
            Route::put('/{product}', 'ProductController@update')->name('update');
            Route::get('/{product}/edit', 'ProductController@edit')->name('edit');
        });

        Route::prefix('services')->name('services.')->group(function () {
            Route::prefix('generals')->name('generals.')->group(function () {
                Route::get('/', 'GeneralServiceController@index')->name('index');
                Route::get('/create', 'GeneralServiceController@create')->name('create');
                Route::get('/{id}', 'GeneralServiceController@show')->name('show');
                Route::get('/{id}/edit', 'GeneralServiceController@edit')->name('edit');
                Route::put('/{id}', 'GeneralServiceController@update')->name('update');
                Route::delete('/{id}', 'GeneralServiceController@destroy')->name('destroy');
                Route::post('/', 'GeneralServiceController@store')->name('store');
            });
            Route::prefix('pregnancies')->name('pregnancies.')->group(function () {
                Route::get('/', 'PregnancyServiceController@index')->name('index');
                Route::post('/', 'PregnancyServiceController@store')->name('store');
                Route::get('/create', 'PregnancyServiceController@create')->name('create');
            });
            Route::prefix('family-plannings')->name('family_plannings.')->group(function () {
                Route::get('/', 'FamilyPlanningServiceController@index')->name('index');
                Route::post('/', 'FamilyPlanningServiceController@store')->name('store');
                Route::get('/create', 'FamilyPlanningServiceController@create')->name('create');
            });
            Route::prefix('laboratories')->name('laboratories.')->group(function () {
                Route::get('/', 'LaboratoryServiceController@index')->name('index');
                Route::post('/', 'LaboratoryServiceController@store')->name('store');
                Route::get('/create', 'LaboratoryServiceController@create')->name('create');
            });
        });


        Route::get('testimonials', 'TestimonialController@index')->name('testimonials.index')->middleware('modules');
        Route::post('testimonials', 'TestimonialController@store')->name('testimonials.store');
        Route::get('testimonials/{testimonial}/edit', 'TestimonialController@edit')->name('testimonials.edit');
        Route::post('testimonials/{testimonial}', 'TestimonialController@update')->name('testimonials.update');
        Route::delete('testimonials/{testimonial}', 'TestimonialController@destroy')->name('testimonials.destroy');
    });



    Route::group(['middleware' => ['xss']], function () {
        //        Route::resource('departments', 'DepartmentController');
        //        Route::post('departments/{department}/active-deactive', 'DepartmentController@activeDeactiveDepartment');

        Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');


        Route::get('settings', 'SettingController@edit')->name('settings.edit');
        Route::post('settings', 'SettingController@update')->name('settings.update');
        Route::get('modules', 'SettingController@getModule')->name('module.index');
        Route::post('modules/{module}/active-deactive', 'SettingController@activeDeactiveStatus')
            ->name('module.activeDeactiveStatus');
    });



    Route::group(
        ['middleware' => ['xss']],
        function () {

            //Notification routes
            Route::get(
                '/notification/{notification}/read',
                'NotificationController@readNotification'
            )->name('read.notification');
            Route::post(
                '/read-all-notification',
                'NotificationController@readAllNotification'
            )->name('read.all.notification');
        }
    );
});
