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



Auth::routes();

Route::group(['middleware'=>['authenticate','active']],function (){

    Route::get('/', function () {
//        return view('welcome');
        return redirect('home');
    });

    Route::get('/home', 'HomeController@index')->name('home');

//    Employee CRUD
    Route::get('employee','EmployeeController@index');
    Route::get('/employee/{id}/edit','EmployeeController@edit');
    Route::get('/employee/{id}/show','EmployeeController@show');
    Route::patch('/employee/update/{id}','EmployeeController@update');
    Route::get('/employee/create','EmployeeController@create');
    Route::post('/employee/store','EmployeeController@store');
    Route::delete('/employee/{id}','EmployeeController@destroy')->name('employee.destroy');

//    User CRUD
    Route::get('user','UserController@index');
    Route::get('/user/{id}/edit','UserController@edit');
    Route::get('/user/{id}/show','UserController@show');
    Route::patch('/user/update/{id}','UserController@update');
    Route::get('/user/{id}/create/','UserController@create');
    Route::post('/user/store','UserController@store');
    Route::get('/user/create/select','UserController@userSelect');

    /*Role Crud*/
    Route::get('/user/roles','RoleController@index');

    /*Assign new Module To  Existing Role*/
    Route::get('/user/role/{id}/module/assign','RoleController@assignNewModule');
    Route::post('/user/role/module/store','RoleController@storeNewModule');

    Route::get('/user/role/module/{id}/permissions','RoleController@getPermissionsByModuleId');
    Route::get('/user/role/module/permissions','RoleController@getPermissionsByModule');

    /*Edit Module Assigned to Existing Role*/
    Route::get('/user/role/{rId}/module/{mId}/edit','RoleController@editPerimssionsByModule');
    /*Update Module Assigned to Existing Role*/
    Route::patch('/user/role/module/permissions/update','RoleController@updatePermissionsByModule');
    /*Delete Module Assigned to Existing Role*/
    Route::get('/user/role/privilege/{id}/delete','RoleController@deletePrivilege');
    /*Create new Role*/
    Route::get('/role/create','RoleController@create');
    Route::post('/user/role/store','RoleController@store');

    Route::get('/user/role/{id}/delete','RoleController@deleteRole');

    //    Supplier CRUD
    Route::get('/supplier/','SupplierController@index');
    Route::get('/supplier/create','SupplierController@create');
    Route::post('/supplier/store','SupplierController@store');
    Route::get('/supplier/{id}/edit','SupplierController@edit');
    Route::patch('/supplier/update/{id}','SupplierController@update');
    Route::delete('/supplier/{id}','SupplierController@destroy');
    Route::get('/supplier/{id}/products','SupplierController@products');
//    Product CRUD
    Route::get('/product/','ProductController@index');
    Route::get('/product/create','ProductController@create');
    Route::post('/product/store','ProductController@store');
    Route::get('/product/{id}/edit','ProductController@edit');
    Route::patch('/product/update/{id}','ProductController@update');
    Route::delete('/product/{id}','ProductController@destroy');

    Route::get('/product/category/{id}/sub_categories','ProductController@getSubcategoryByCategoryId');
    Route::get('/product/sub_category/{id}/category','ProductController@getCategoryBySubcategoryId');
    Route::get('/product/request','ProductController@getCategoryBySubcategoryId');

    Route::get('/stock/request/create','StockRequestController@create');
    Route::post('/stock/request/store','StockRequestController@store');

    Route::get('/stock/requests','StockRequestController@requests');
    Route::post('/stock/request/approve','StockRequestController@approve');
    Route::get('/stock/request/{id}/download','StockRequestController@downloadStockRequest');

    Route::get('/stock/','StockController@index');
    Route::get('/stock/create/','StockController@getStockRequests');
    Route::get('/stock/{stockRequestId}/create/','StockController@create');
    Route::post('/stock/store','StockController@store');

    Route::get('/inventory/','InventoryController@index');

    Route::get('/product/request','ProductRequestController@create');
    Route::post('/product/request/store','ProductRequestController@store');

    Route::get('/product/requests/approve','ProductRequestController@getRequestsForApprove');
    Route::post('/product/requests/approve','ProductRequestController@approve');

    Route::get('/product/requests/confirm','ProductRequestController@getRequestsForConfirm');
    Route::get('/product/requests','ProductRequestController@index');

    Route::get('/product/issue/select','ProductIssueController@select');
    Route::get('/product/issue/{id}/create','ProductIssueController@create');
    Route::post('/inventory/issue/store','ProductIssueController@store');

    Route::get('/log','LogController@index');

    Route::get('/admin','AdminController@index');

    Route::get('/division/{id}/edit','DivisionController@edit');
    Route::get('/division','DivisionController@index');
    Route::post('/division','DivisionController@store');
    Route::patch('/division/{id}','DivisionController@update');
    
    Route::get('/designation/{id}/edit','DesignationController@edit');
    Route::get('/designation','DesignationController@index');
    Route::post('/designation','DesignationController@store');
    Route::patch('/designation/{id}','DesignationController@update');
    
    Route::get('/productCategory/{id}/edit','ProductCategoryController@edit');
    Route::get('/productCategory','ProductCategoryController@index');
    Route::post('/productCategory','ProductCategoryController@store');
    Route::patch('/productCategory/{id}','ProductCategoryController@update');

    Route::get('/productSubCategory/{id}/edit','ProductSubCategoryController@edit');
    Route::get('/productSubCategory','ProductSubCategoryController@index');
    Route::post('/productSubCategory','ProductSubCategoryController@store');
    Route::patch('/productSubCategory/{id}','ProductSubCategoryController@update');

    Route::get('/department_bill','ReportController@getDepartmentBill');
    Route::post('/department_bill','ReportController@generateDepartmentBill');

    Route::get('/products_received_issued','ReportController@productWiseReceivedIssued');
    Route::get('/product_analysing','ReportController@Chart');
});

//Route::get('test',function (){
//    return view('reports.productIssuedRecieved');
//});
