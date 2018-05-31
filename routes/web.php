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

$admin = 'admin';

Route::any('/', [
    'as'   => 'auth.login', 
    'uses' => 'AuthController@login'
]);

Route::any('forgot-password/{token?}', [
    'as'   => 'auth.forgot-password', 
    'uses' => 'AuthController@forgotPassword'
]);

Route::group(['prefix' => 'app', 'middleware' => ['auth']], function() {

	Route::any('dashboard', [
	    'as'   => 'app.general.dashboard', 
	    'uses' => 'GeneralController@dashboard'
	]);

	/* START USERS */
	Route::group(['prefix' => 'users'], function() {

		Route::any('/', [
		    'as'   => 'app.users.index', 
		    'uses' => 'UserController@index'
		]);
		Route::any('add', [
		    'as'   => 'app.users.add', 
		    'uses' => 'UserController@add'
		]);
		Route::any('edit/{id?}', [
		    'as'   => 'app.users.edit', 
		    'uses' => 'UserController@edit'
		]);
		Route::any('delete/{id?}', [
		    'as'   => 'app.users.delete', 
		    'uses' => 'UserController@delete'
		]);
		Route::any('restore/{id?}', [
		    'as'   => 'app.users.restore', 
		    'uses' => 'UserController@restore'
		]);
		Route::any('destroy/{id?}', [
		    'as'   => 'app.users.destroy', 
		    'uses' => 'UserController@destroy'
		]);
		Route::any('profile', [
		    'as'   => 'app.users.profile', 
		    'uses' => 'UserController@profile'
		]);
		Route::any('login/{id?}', [
		    'as'   => 'app.users.login', 
		    'uses' => 'UserController@login'
		]);
	});
	/* END USERS */


	/* START GROUPS */
	Route::group(['prefix' => 'groups'], function() {

		Route::any('/', [
		    'as'   => 'app.groups.index', 
		    'uses' => 'GroupController@index'
		]);
		Route::any('add', [
		    'as'   => 'app.groups.add', 
		    'uses' => 'GroupController@add'
		]);
		Route::any('edit/{id?}', [
		    'as'   => 'app.groups.edit', 
		    'uses' => 'GroupController@edit'
		]);
		Route::any('delete/{id?}', [
		    'as'   => 'app.groups.delete', 
		    'uses' => 'GroupController@delete'
		]);
		Route::any('restore/{id?}', [
		    'as'   => 'app.groups.restore', 
		    'uses' => 'GroupController@restore'
		]);
		Route::any('destroy/{id?}', [
		    'as'   => 'app.groups.destroy', 
		    'uses' => 'GroupController@destroy'
		]);

		Route::any('permissions/{id?}', [
		    'as'   => 'app.groups.permissions', 
		    'uses' => 'GroupController@permissions'
		]);
	});
	/* END GROUPS */

	/* START POST TYPES */
	Route::group(['prefix' => 'posts'], function() {

		Route::any('/', [
		    'as'   => 'app.posts.index', 
		    'uses' => 'PostController@index'
		]);
		Route::any('add', [
		    'as'   => 'app.posts.add', 
		    'uses' => 'PostController@add'
		]);
		Route::any('edit/{id?}', [
		    'as'   => 'app.posts.edit', 
		    'uses' => 'PostController@edit'
		]);
		Route::any('delete/{id?}', [
		    'as'   => 'app.posts.delete', 
		    'uses' => 'PostController@delete'
		]);
		Route::any('restore/{id?}', [
		    'as'   => 'app.posts.restore', 
		    'uses' => 'PostController@restore'
		]);
		Route::any('destroy/{id?}', [
		    'as'   => 'app.posts.destroy', 
		    'uses' => 'PostController@destroy'
		]);

	});
	/* END POST TYPES */


	/* START Contributions */
	Route::group(['prefix' => 'deductions'], function() {

	    Route::any('/', [
	        'as'   => 'app.deductions.index', 
	        'uses' => 'DeductionController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.deductions.add', 
	        'uses' => 'DeductionController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.deductions.edit', 
	        'uses' => 'DeductionController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.deductions.delete', 
	        'uses' => 'DeductionController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.deductions.restore', 
	        'uses' => 'DeductionController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.deductions.destroy', 
	        'uses' => 'DeductionController@destroy'
	    ]);
	    Route::any('table/{id?}', [
	        'as'   => 'app.deductions.table', 
	        'uses' => 'DeductionController@table'
	    ]);
		Route::any('government/calculator', [
		    'as'   => 'app.deductions.govenrment.calculator', 
		    'uses' => 'DeductionController@calculator'
		]);
	});
	/* END Contributions */

	/* START leaves */
	Route::group(['prefix' => 'leaves'], function() {

	    Route::any('/', [
	        'as'   => 'app.leaves.index', 
	        'uses' => 'LeaveController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.leaves.add', 
	        'uses' => 'LeaveController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.leaves.edit', 
	        'uses' => 'LeaveController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.leaves.delete', 
	        'uses' => 'LeaveController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.leaves.restore', 
	        'uses' => 'LeaveController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.leaves.destroy', 
	        'uses' => 'LeaveController@destroy'
	    ]);

	});
	/* END leaves */

	/* START leaves manager */
	Route::group(['prefix' => 'leaves/manager'], function() {

	    Route::any('/', [
	        'as'   => 'app.leaves.manager.index', 
	        'uses' => 'LeaveManagerController@index'
	    ]);
	    Route::any('file', [
	        'as'   => 'app.leaves.manager.file', 
	        'uses' => 'LeaveManagerController@file'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.leaves.manager.edit', 
	        'uses' => 'LeaveManagerController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.leaves.manager.delete', 
	        'uses' => 'LeaveManagerController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.leaves.manager.restore', 
	        'uses' => 'LeaveManagerController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.leaves.manager.destroy', 
	        'uses' => 'LeaveManagerController@destroy'
	    ]);

	});
	/* END leaves manager */

	/* START earnings */
	Route::group(['prefix' => 'earnings'], function() {

	    Route::any('/', [
	        'as'   => 'app.earnings.index', 
	        'uses' => 'EarningController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.earnings.add', 
	        'uses' => 'EarningController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.earnings.edit', 
	        'uses' => 'EarningController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.earnings.delete', 
	        'uses' => 'EarningController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.earnings.restore', 
	        'uses' => 'EarningController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.earnings.destroy', 
	        'uses' => 'EarningController@destroy'
	    ]);

	});
	/* END earnings */


	/* START earnings */
	Route::group(['prefix' => 'allowances'], function() {

	    Route::any('/', [
	        'as'   => 'app.allowances.index', 
	        'uses' => 'AllowanceController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.allowances.add', 
	        'uses' => 'AllowanceController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.allowances.edit', 
	        'uses' => 'AllowanceController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.allowances.delete', 
	        'uses' => 'AllowanceController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.allowances.restore', 
	        'uses' => 'AllowanceController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.allowances.destroy', 
	        'uses' => 'AllowanceController@destroy'
	    ]);

	});
	/* END earnings */

	/* START tax tables */
	Route::group(['prefix' => 'taxes'], function() {

	    Route::any('/', [
	        'as'   => 'app.taxes.index', 
	        'uses' => 'TaxController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.taxes.add', 
	        'uses' => 'TaxController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.taxes.edit', 
	        'uses' => 'TaxController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.taxes.delete', 
	        'uses' => 'TaxController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.taxes.restore', 
	        'uses' => 'TaxController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.taxes.destroy', 
	        'uses' => 'TaxController@destroy'
	    ]);
	    Route::any('tables', [
	        'as'   => 'app.taxes.tables', 
	        'uses' => 'TaxController@tables'
	    ]);
		Route::any('tables/update', [
	        'as'   => 'app.taxes.tables.update', 
	        'uses' => 'TaxController@tables_update'
		]);
		Route::any('calculator', [
		    'as'   => 'app.taxes.calculator', 
		    'uses' => 'TaxController@calculator'
		]);
	});
	/* END tax tables */

	/* START events */
	Route::group(['prefix' => 'events'], function() {

	    Route::any('/', [
	        'as'   => 'app.events.index', 
	        'uses' => 'EventController@index'
	    ]);
	    Route::any('add', [
	        'as'   => 'app.events.add', 
	        'uses' => 'EventController@add'
	    ]);
	    Route::any('edit/{id?}', [
	        'as'   => 'app.events.edit', 
	        'uses' => 'EventController@edit'
	    ]);
	    Route::any('delete/{id?}', [
	        'as'   => 'app.events.delete', 
	        'uses' => 'EventController@delete'
	    ]);
	    Route::any('restore/{id?}', [
	        'as'   => 'app.events.restore', 
	        'uses' => 'EventController@restore'
	    ]);
	    Route::any('destroy/{id?}', [
	        'as'   => 'app.events.destroy', 
	        'uses' => 'EventController@destroy'
	    ]);

	});
	/* END events */

	/* START EMPLOYEES */
	Route::group(['prefix' => 'employees'], function() {

		Route::any('/', [
		    'as'   => 'app.employees.index', 
		    'uses' => 'EmployeeController@index'
		]);
		Route::any('add', [
		    'as'   => 'app.employees.add', 
		    'uses' => 'EmployeeController@add'
		]);
		Route::any('edit/{id?}', [
		    'as'   => 'app.employees.edit', 
		    'uses' => 'EmployeeController@edit'
		]);
		Route::any('delete/{id?}', [
		    'as'   => 'app.employees.delete', 
		    'uses' => 'EmployeeController@delete'
		]);
		Route::any('restore/{id?}', [
		    'as'   => 'app.employees.restore', 
		    'uses' => 'EmployeeController@restore'
		]);
		Route::any('destroy/{id?}', [
		    'as'   => 'app.employees.destroy', 
		    'uses' => 'EmployeeController@destroy'
		]);
		Route::any('ajax/update', [
	        'as'   => 'app.employees.ajax.update', 
	        'uses' => 'EmployeeController@ajax_update'
		]);
	});
	/* END EMPLOYEES */


	/* START ATTENDANCE */
	Route::group(['prefix' => 'attendance'], function() {

		Route::any('/', [
		    'as'   => 'app.attendance.index', 
		    'uses' => 'AttendanceController@index'
		]);
		Route::any('manual', [
		    'as'   => 'app.attendance.manual', 
		    'uses' => 'AttendanceController@manual'
		]);
	});
	/* END ATTENDANCE */

	/* START PAYROLL */
	Route::group(['prefix' => 'payroll'], function() {

		Route::any('/', [
		    'as'   => 'app.payroll.index', 
		    'uses' => 'PayrollController@index'
		]);
		Route::any('view/{id?}', [
		    'as'   => 'app.payroll.view', 
		    'uses' => 'PayrollController@view'
		]);
		Route::any('payslip', [
		    'as'   => 'app.payroll.payslip', 
		    'uses' => 'PayrollController@payslip'
		]);

	});
	/* END PAYROLL */

	Route::group(['prefix' => 'settings'], function() {
		Route::any('/', [
		    'as'   => 'app.general.settings', 
		    'uses' => 'GeneralController@settings'
		]);
		Route::any('ajax/update', [
	        'as'   => 'app.general.settings.ajax.update', 
	        'uses' => 'GeneralController@ajax_update_settings'
		]);
	});

	Route::any('lock', [
	    'as'   => 'auth.lock', 
	    'uses' => 'AuthController@lock'
	]);


	Route::any('logout', [
	    'as'   => 'auth.logout', 
	    'uses' => 'AuthController@logout'
	]);

});



Route::any('unlock', [
    'as'   => 'auth.unlock', 
    'uses' => 'AuthController@unlock'
]);