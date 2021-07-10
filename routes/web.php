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
        Route::prefix('users')->name('users.')->middleware('owner')->group(function () {
            Route::get('/', 'UserController@index')->middleware('modules')->name('index');
            Route::get('/create', 'UserController@create')->name('create');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/{id}/edit', 'UserController@edit')->name('edit');
            Route::put('/{id}', 'UserController@update')->name('update');
            Route::delete('/{id}', 'UserController@destroy')->name('destroy');
        });

        Route::prefix('/suppliers')->name('suppliers.')->middleware('owner')->group(function () {
            Route::get('/', 'SupplierController@index')->name('index')->middleware('modules');
            Route::get('/create', 'SupplierController@create')->name('create');
            Route::get('/{supplier}', 'SupplierController@show')->name('show');
            Route::post('/supplier', 'SupplierController@store')->name('store');
            Route::delete('/{supplier}', 'SupplierController@destroy')->name('destroy');
            Route::post('/{supplier}/salesmans', 'SupplierController@createSalesman')->name('createSalesman');
            Route::delete('/{supplier}/salesmans/{salesman}', 'SupplierController@destroySalesman')->name('destroy_salesman');
            Route::patch('/{supplier}', 'SupplierController@update')->name('update');
            Route::get('/{supplier}/edit', 'SupplierController@edit')->name('edit');
        });

        Route::prefix('patients')->name('patients.')->middleware('cashier')->group(function () {
            Route::get('/', 'PatientController@index')->name('index')->middleware('modules');
            Route::get('/create', 'PatientController@create')->name('create');
            Route::get('/{patient}', 'PatientController@show')->name('show');
            Route::post('/patients', 'PatientController@store')->name('store');
            Route::delete('/{patient}', 'PatientController@destroy')->name('destroy');
            Route::patch('/{patient}', 'PatientController@update')->name('update');
            Route::get('/{patient}/edit', 'PatientController@edit')->name('edit');
            Route::get('/{patient}/service/{service}', 'PatientController@service')->name('service');
            Route::post('/{patient}/active-deactive', 'PatientController@activeDeactiveStatus');
            Route::get('export-patients', 'PatientController@patientExport')->name('excel');
        });

        Route::prefix('medics')->name('medics.')->middleware('cashier')->group(function () {
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
            Route::get('/{medic}/service/{service}', 'MedicController@service')->name('service');
            Route::post('/{medic}/active-deactive', 'MedicController@activeDeactiveStatus');
            Route::get('export-patients', 'MedicController@patientExport')->name('patient.excel');
        });

        Route::prefix('categories')->name('categories.')->middleware('owner')->group(function () {
            Route::get('/', 'ProductCategoryController@index')->middleware('modules')->name('index');
            Route::get('/create', 'ProductCategoryController@create')->name('create');
            Route::post('/', 'ProductCategoryController@store')->name('store');
            Route::get('/{id}/edit', 'ProductCategoryController@edit')->name('edit');
            Route::put('/{id}', 'ProductCategoryController@update')->name('update');
            Route::delete('/{id}', 'ProductCategoryController@destroy')->name('destroy');
        });

        Route::prefix('brands')->name('brands.')->middleware('owner')->group(function () {
            Route::get('/', 'ProductBrandController@index')->name('index')->middleware('modules');
            Route::get('/create', 'ProductBrandController@create')->name('create');
            Route::get('/{brand}', 'ProductBrandController@show')->name('show');
            Route::post('/', 'ProductBrandController@store')->name('store');
            Route::delete('/{brand}', 'ProductBrandController@destroy')->name('destroy');
            Route::put('/{brand}', 'ProductBrandController@update')->name('update');
            Route::get('/{brand}/edit', 'ProductBrandController@edit')->name('edit');
        });
        Route::prefix('products')->name('products.')->middleware('cashier')->group(function () {
            Route::get('/', 'ProductController@index')->name('index')->middleware('modules');
            Route::get('/create', 'ProductController@create')->name('create');
            Route::post('/', 'ProductController@store')->name('store');
            Route::delete('/{product}', 'ProductController@destroy')->name('destroy');
            Route::put('/{product}', 'ProductController@update')->name('update');
            Route::get('/{product}/edit', 'ProductController@edit')->name('edit');
        });

        Route::prefix('services')->name('services.')->middleware('cashier')->group(function () {
            Route::prefix('generals')->name('generals.')->group(function () {
                Route::get('/', 'GeneralServiceController@index')->name('index');
                Route::get('/create', 'GeneralServiceController@create')->name('create');
                Route::get('/{id}', 'GeneralServiceController@show')->name('show');
                Route::get('/{id}/edit', 'GeneralServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'GeneralServiceController@print')->name('print');
                Route::put('/{id}', 'GeneralServiceController@update')->name('update');
                Route::delete('/{id}', 'GeneralServiceController@destroy')->name('destroy');
                Route::post('/', 'GeneralServiceController@store')->name('store');
            });
            Route::prefix('pregnancies')->name('pregnancies.')->group(function () {
                Route::get('/', 'PregnancyServiceController@index')->name('index');
                Route::get('/create', 'PregnancyServiceController@create')->name('create');
                Route::get('/{id}', 'PregnancyServiceController@show')->name('show');
                Route::get('/{id}/edit', 'PregnancyServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'PregnancyServiceController@print')->name('print');
                Route::put('/{id}', 'PregnancyServiceController@update')->name('update');
                Route::delete('/{id}', 'PregnancyServiceController@destroy')->name('destroy');
                Route::post('/', 'PregnancyServiceController@store')->name('store');
            });
            Route::prefix('family-plannings')->name('family_plannings.')->group(function () {
                Route::get('/', 'FamilyPlanningServiceController@index')->name('index');
                Route::get('/create', 'FamilyPlanningServiceController@create')->name('create');
                Route::get('/{id}', 'FamilyPlanningServiceController@show')->name('show');
                Route::get('/{id}/edit', 'FamilyPlanningServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'FamilyPlanningServiceController@print')->name('print');
                Route::put('/{id}', 'FamilyPlanningServiceController@update')->name('update');
                Route::delete('/{id}', 'FamilyPlanningServiceController@destroy')->name('destroy');
                Route::post('/', 'FamilyPlanningServiceController@store')->name('store');
            });
            Route::prefix('laboratories')->name('laboratories.')->group(function () {
                Route::get('/', 'LaboratoryServiceController@index')->name('index');
                Route::get('/create', 'LaboratoryServiceController@create')->name('create');
                Route::get('/{id}', 'LaboratoryServiceController@show')->name('show');
                Route::get('/{id}/edit', 'LaboratoryServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'LaboratoryServiceController@print')->name('print');
                Route::put('/{id}', 'LaboratoryServiceController@update')->name('update');
                Route::delete('/{id}', 'LaboratoryServiceController@destroy')->name('destroy');
                Route::post('/', 'LaboratoryServiceController@store')->name('store');
            });
            Route::prefix('parturitions')->name('parturitions.')->group(function () {
                Route::get('/', 'ParturitionServiceController@index')->name('index');
                Route::get('/create', 'ParturitionServiceController@create')->name('create');
                Route::get('/{id}', 'ParturitionServiceController@show')->name('show');
                Route::get('/{id}/edit', 'ParturitionServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'ParturitionServiceController@print')->name('print');
                Route::put('/{id}', 'ParturitionServiceController@update')->name('update');
                Route::delete('/{id}', 'ParturitionServiceController@destroy')->name('destroy');
                Route::post('/', 'ParturitionServiceController@store')->name('store');
            });
            Route::prefix('inpatients')->name('inpatients.')->group(function () {
                Route::get('/', 'InpatientServiceController@index')->name('index');
                Route::get('/create', 'InpatientServiceController@create')->name('create');
                Route::get('/{id}', 'InpatientServiceController@show')->name('show');
                Route::get('/{id}/edit', 'InpatientServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'InpatientServiceController@print')->name('print');
                Route::put('/{id}', 'InpatientServiceController@update')->name('update');
                Route::delete('/{id}', 'InpatientServiceController@destroy')->name('destroy');
                Route::post('/', 'InpatientServiceController@store')->name('store');
            });
            Route::prefix('immunizations')->name('immunizations.')->group(function () {
                Route::get('/', 'ImmunizationServiceController@index')->name('index');
                Route::get('/create', 'ImmunizationServiceController@create')->name('create');
                Route::get('/{id}', 'ImmunizationServiceController@show')->name('show');
                Route::get('/{id}/edit', 'ImmunizationServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'ImmunizationServiceController@print')->name('print');
                Route::put('/{id}', 'ImmunizationServiceController@update')->name('update');
                Route::delete('/{id}', 'ImmunizationServiceController@destroy')->name('destroy');
                Route::post('/', 'ImmunizationServiceController@store')->name('store');
            });
            Route::prefix('electrocardiograms')->name('electrocardiograms.')->group(function () {
                Route::get('/', 'ElectrocardiogramServiceController@index')->name('index');
                Route::get('/create', 'ElectrocardiogramServiceController@create')->name('create');
                Route::get('/{id}', 'ElectrocardiogramServiceController@show')->name('show');
                Route::get('/{id}/edit', 'ElectrocardiogramServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'ElectrocardiogramServiceController@print')->name('print');
                Route::put('/{id}', 'ElectrocardiogramServiceController@update')->name('update');
                Route::delete('/{id}', 'ElectrocardiogramServiceController@destroy')->name('destroy');
                Route::post('/', 'ElectrocardiogramServiceController@store')->name('store');
            });
            Route::prefix('administrations')->name('administrations.')->group(function () {
                Route::get('/', 'AdministrationServiceController@index')->name('index');
                Route::get('/create', 'AdministrationServiceController@create')->name('create');
                Route::get('/{id}', 'AdministrationServiceController@show')->name('show');
                Route::get('/{id}/edit', 'AdministrationServiceController@edit')->name('edit');
                Route::get('/{id}/print', 'AdministrationServiceController@print')->name('print');
                Route::put('/{id}', 'AdministrationServiceController@update')->name('update');
                Route::delete('/{id}', 'AdministrationServiceController@destroy')->name('destroy');
                Route::post('/', 'AdministrationServiceController@store')->name('store');
            });
        });

        Route::prefix('sales')->name('sales.')->middleware('cashier')->group(function () {
            Route::prefix('cashiers')->name('cashiers.')->middleware('cashier_shift')->group(function () {
                Route::get('/', 'CashierController@index')->name('index');
                Route::post('/', 'CashierController@store')->name('store');
                Route::get('/cart-table', 'CashierController@loadTable')->name('cart_table');
                Route::post('/cart', 'CashierController@addCart')->name('cart_add');
                Route::delete('/cart/{key}', 'CashierController@deleteCart')->name('cart_delete');
            });

            Route::prefix('data')->name('datas.')->group(function () {
                Route::get('/', 'SalesDataController@index')->name('index');
                Route::put('/{id}', 'SalesDataController@update')->name('update');
                Route::get('/{id}', 'SalesDataController@show')->name('show');
                Route::get('/{id}/edit', 'SalesDataController@edit')->name('edit');
                Route::get('/{sale_id}/print', 'SalesDataController@print')->name('print');
            });
        });

        Route::prefix('purchases')->name('purchases.')->middleware('owner')->group(function () {
            Route::get('/', 'PurchaseController@index')->name('index');
            Route::get('/create', 'PurchaseController@create')->name('create');
            Route::post('/', 'PurchaseController@store')->name('store');
            Route::put('/{purchase_id}', 'PurchaseController@update')->name('update');
            Route::delete('/{purchase_id}', 'PurchaseController@destroy')->name('destroy');
            Route::get('/{purchase_id}/print', 'PurchaseController@print')->name('print');
            Route::get('/{purchase_id}/edit', 'PurchaseController@edit')->name('edit');
            Route::get('/{suppleir_id}/salesman', 'PurchaseController@getSalesmans')->name('get_salesman');
            Route::get('/get-products', 'PurchaseController@getProducts')->name('get_products');
            // cart create
            Route::get('/cart-table', 'PurchaseController@loadTable')->name('cart_table');
            Route::post('/cart', 'PurchaseController@addCart')->name('cart_add');
            Route::delete('/cart/{key}', 'PurchaseController@deleteCart')->name('cart_delete');

            // edit
            Route::get('/cart-table-edit/{purchase_id}', 'PurchaseController@loadTableEdit')->name('cart_table_edit');
            // Route::post('/cart/{purchase_id}', 'PurchaseController@addCartOnEdit')->name('cart_add_on_edit');
            // Route::delete('/cart/{key}', 'PurchaseController@deleteCart')->name('cart_delete_on_edit');
        });

        Route::prefix('spendings')->name('spendings.')->group(function () {
            Route::get('/', 'SpendingController@index')->name('index');
            Route::get('/create', 'SpendingController@create')->name('create');
            Route::post('/', 'SpendingController@store')->name('store');
            Route::get('/{spending_id}/edit', 'SpendingController@edit')->name('edit');
            Route::get('/{spending_id}/print', 'SpendingController@print')->name('print');
            Route::put('/{spending_id}', 'SpendingController@update')->name('update');
        });
        Route::prefix('shift-logs')->name('shift_logs.')->group(function () {
            Route::get('/', 'ShiftLogController@index')->name('index');
        });
        Route::prefix('stock-adjusments')->name('stock_adjusments.')->group(function () {
            Route::get('/', 'StockAdjustmentController@index')->name('index');
            Route::post('/', 'StockAdjustmentController@store')->name('store');
            Route::put('/{id}', 'StockAdjustmentController@update')->name('update');
            Route::delete('/{id}', 'StockAdjustmentController@destroy')->name('destroy');
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
        Route::get('/chart', 'HomeController@getChart')->name('chart');
        Route::get('/report', 'HomeController@report')->name('report');
        Route::post('/shift', 'HomeController@startShift')->name('shift');

        Route::post('/trasnfer', 'HomeController@transfer')->name('transfer');
        Route::post('/cash-add', 'HomeController@cashAdd')->name('cash_add');
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
