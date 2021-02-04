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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {return view('one.login.login');});
    Route::post('/login', 'one\LoginController@login')->name('post.login');
});



Route::group(['middleware' => ['login.check']], function () {
    Route::post('/logout', 'one\LoginController@logout');
        Route::group(['middleware' => ['get.menu']], function () {
            Route::prefix('dashboard')->group(function () {
                Route::get('/', function () {return view('one.home.homepage'); });
                Route::get('/location/city/show/{id}', 'one\General\LocationController@get_city');

                //Jobs Page
                Route::get('/jobs', 'one\jobs\JobsController@index');
                Route::get('/jobs/create', 'one\jobs\JobsController@create');
                Route::post('/jobs/store', 'one\jobs\JobsController@store');
                Route::get('/jobs/edit/{id}', 'one\jobs\JobsController@edit');
                Route::put('/jobs/update/{id}', 'one\jobs\JobsController@update');
                Route::get('/jobs/delete/{id}', 'one\jobs\JobsController@destroy');

                //News Page
                Route::get('/news-article', 'one\News\NewsController@index');
                Route::get('/news-article/view/{id}', 'one\News\NewsController@show');
                Route::get('/news-article/create', 'one\News\NewsController@create');
                Route::post('/news/store', 'one\News\NewsController@store');
                Route::get('/news-article/edit/{id}', 'one\News\NewsController@edit');
                Route::post('/news-article/update/{id}', 'one\News\NewsController@update');
                Route::get('/news-article/delete/{id}', 'one\News\NewsController@destroy');
                Route::post('/news-article/addcomment', 'one\News\NewsController@addcomment');
                Route::get('/news-article/deletecomment/{id}', 'one\News\NewsController@deletecomment');
                Route::post('/news-article/replycomment', 'one\News\NewsController@replycomment');
                Route::get('/news-article/del-replycomment/{id}', 'one\News\NewsController@deletereplycomment');

                //Event Page
                Route::get('/event', 'one\Event\EventController@index');
                Route::get('/event/view/{id}', 'one\Event\EventController@show');
                Route::get('/event/create', 'one\Event\EventController@create');
                Route::post('/event/store', 'one\Event\EventController@store');
                Route::get('/event/edit/{id}', 'one\Event\EventController@edit');
                Route::post('/event/update/{id}', 'one\Event\EventController@update');
                Route::get('/event/delete/{id}', 'one\Event\EventController@destroy');
                Route::post('/event/register-status/{id}', 'one\Event\EventController@registerStatus');

                Route::prefix('settings')->group(function () {
                    Route::get('/roles', 'one\Settings\RolesController@index');
                    Route::get('/roles/view/{id}','one\Settings\RolesController@show');
                    Route::get('/roles/create','one\Settings\RolesController@formcreate');
                    Route::post('/roles/store','one\Settings\RolesController@store');
                    Route::get('/roles/edit/{id}','one\Settings\RolesController@edit');
                    Route::put('/roles/update/{id}','one\Settings\RolesController@update');
                    Route::get('/roles/delete/{id}','one\Settings\RolesController@destroy');
                });

                Route::prefix('user-management')->group(function () {
                    Route::get('/admin', 'one\Admin\AdminController@index');
                    Route::get('/admin/view/{id}','one\Admin\AdminController@show');
                    Route::get('/admin/create', 'one\Admin\AdminController@formcreate');
                    Route::post('/admin/store', 'one\Admin\AdminController@store');
                    Route::get('/admin/edit/{id}','one\Admin\AdminController@edit');
                    Route::put('/admin/update/{id}','one\Admin\AdminController@update');
                    Route::get('/admin/delete/{id}','one\Admin\AdminController@destroy');
                    Route::get('/employee', 'one\Employee\EmployeeController@index');
                    Route::get('/employee/view/{id}', 'one\Employee\EmployeeController@show');
                    Route::get('/employee/edit/{id}', 'one\Employee\EmployeeController@edit');
                    Route::put('/employee/update/{id}', 'one\Employee\EmployeeController@update');
                    Route::get('/employee/delete/{id}', 'one\Employee\EmployeeController@destroy');
                    Route::get('/employee-level', 'one\Level\LevelController@index');
                    Route::get('/employee-level/view/{id}', 'one\Level\LevelController@show');
                    Route::post('/employee-level/create', 'one\Level\LevelController@store');
                });

                Route::prefix('log')->group(function () {
                    Route::get('/dashboard-log', 'one\Log\LogController@dashboardLog');
                    Route::get('/dashboard-log/show/{id}', 'one\Log\LogController@dashboardLogShow');
                    Route::get('/mobile-log', 'one\Log\LogController@mobileLog');
                    Route::get('/mobile-log/show/{id}', 'one\Log\LogController@mobileLogShow');
                });
            });
            
            // Route::prefix('base')->group(function () {  
            //     Route::get('/breadcrumb', function(){   return view('dashboard.base.breadcrumb'); });
            //     Route::get('/cards', function(){        return view('dashboard.base.cards'); });
            //     Route::get('/carousel', function(){     return view('dashboard.base.carousel'); });
            //     Route::get('/collapse', function(){     return view('dashboard.base.collapse'); });

            //     Route::get('/forms', function(){        return view('dashboard.base.forms'); });
            //     Route::get('/jumbotron', function(){    return view('dashboard.base.jumbotron'); });
            //     Route::get('/list-group', function(){   return view('dashboard.base.list-group'); });
            //     Route::get('/navs', function(){         return view('dashboard.base.navs'); });

            //     Route::get('/pagination', function(){   return view('dashboard.base.pagination'); });
            //     Route::get('/popovers', function(){     return view('dashboard.base.popovers'); });
            //     Route::get('/progress', function(){     return view('dashboard.base.progress'); });
            //     Route::get('/scrollspy', function(){    return view('dashboard.base.scrollspy'); });

            //     Route::get('/switches', function(){     return view('dashboard.base.switches'); });
            //     Route::get('/tables', function () {     return view('dashboard.base.tables'); });
            //     Route::get('/tabs', function () {       return view('dashboard.base.tabs'); });
            //     Route::get('/tooltips', function () {   return view('dashboard.base.tooltips'); });
            // });
        });
});

// Route::group(['middleware' => ['get.menu']], function () {
    // Route::get('/dashboard', function () {           return view('dashboard.homepage'); });
    // Route::get('/', function () {           return view('dashboard.authBase'); });

    // Route::group(['middleware' => ['role:user']], function () {
        // Route::get('/colors', function () {     return view('dashboard.colors'); });
        // Route::get('/typography', function () { return view('dashboard.typography'); });
        // Route::get('/charts', function () {     return view('dashboard.charts'); });
        // Route::get('/widgets', function () {    return view('dashboard.widgets'); });
        // Route::get('/404', function () {        return view('dashboard.404'); });
        // Route::get('/500', function () {        return view('dashboard.500'); });
        // Route::prefix('base')->group(function () {  
        //     Route::get('/breadcrumb', function(){   return view('dashboard.base.breadcrumb'); });
        //     Route::get('/cards', function(){        return view('dashboard.base.cards'); });
        //     Route::get('/carousel', function(){     return view('dashboard.base.carousel'); });
        //     Route::get('/collapse', function(){     return view('dashboard.base.collapse'); });

        //     Route::get('/forms', function(){        return view('dashboard.base.forms'); });
        //     Route::get('/jumbotron', function(){    return view('dashboard.base.jumbotron'); });
        //     Route::get('/list-group', function(){   return view('dashboard.base.list-group'); });
        //     Route::get('/navs', function(){         return view('dashboard.base.navs'); });

        //     Route::get('/pagination', function(){   return view('dashboard.base.pagination'); });
        //     Route::get('/popovers', function(){     return view('dashboard.base.popovers'); });
        //     Route::get('/progress', function(){     return view('dashboard.base.progress'); });
        //     Route::get('/scrollspy', function(){    return view('dashboard.base.scrollspy'); });

        //     Route::get('/switches', function(){     return view('dashboard.base.switches'); });
        //     Route::get('/tables', function () {     return view('dashboard.base.tables'); });
        //     Route::get('/tabs', function () {       return view('dashboard.base.tabs'); });
        //     Route::get('/tooltips', function () {   return view('dashboard.base.tooltips'); });
        // });
        // Route::prefix('buttons')->group(function () {  
        //     Route::get('/buttons', function(){          return view('dashboard.buttons.buttons'); });
        //     Route::get('/button-group', function(){     return view('dashboard.buttons.button-group'); });
        //     Route::get('/dropdowns', function(){        return view('dashboard.buttons.dropdowns'); });
        //     Route::get('/brand-buttons', function(){    return view('dashboard.buttons.brand-buttons'); });
        // });
        // Route::prefix('icon')->group(function () {  // word: "icons" - not working as part of adress
        //     Route::get('/coreui-icons', function(){         return view('dashboard.icons.coreui-icons'); });
        //     Route::get('/flags', function(){                return view('dashboard.icons.flags'); });
        //     Route::get('/brands', function(){               return view('dashboard.icons.brands'); });
        // });
        // Route::prefix('notifications')->group(function () {  
        //     Route::get('/alerts', function(){   return view('dashboard.notifications.alerts'); });
        //     Route::get('/badge', function(){    return view('dashboard.notifications.badge'); });
        //     Route::get('/modals', function(){   return view('dashboard.notifications.modals'); });
        // });
        // Route::resource('notes', 'NotesController');
    // });
    // Auth::routes();

    // Route::resource('resource/{table}/resource', 'ResourceController')->names([
    //     'index'     => 'resource.index',
    //     'create'    => 'resource.create',
    //     'store'     => 'resource.store',
    //     'show'      => 'resource.show',
    //     'edit'      => 'resource.edit',
    //     'update'    => 'resource.update',
    //     'destroy'   => 'resource.destroy'
    // ]);

    // Route::group(['middleware' => ['role:admin']], function () {
    //     Route::resource('bread',  'BreadController');   //create BREAD (resource)
    //     Route::resource('users',        'UsersController')->except( ['create', 'store'] );
    //     Route::resource('roles',        'RolesController');
    //     Route::resource('mail',        'MailController');
    //     Route::get('prepareSend/{id}',        'MailController@prepareSend')->name('prepareSend');
    //     Route::post('mailSend/{id}',        'MailController@send')->name('mailSend');
    //     Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
    //     Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
    //     Route::prefix('menu/element')->group(function () { 
    //         Route::get('/',             'MenuElementController@index')->name('menu.index');
    //         Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
    //         Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
    //         Route::get('/create',       'MenuElementController@create')->name('menu.create');
    //         Route::post('/store',       'MenuElementController@store')->name('menu.store');
    //         Route::get('/get-parents',  'MenuElementController@getParents');
    //         Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
    //         Route::post('/update',      'MenuElementController@update')->name('menu.update');
    //         Route::get('/show',         'MenuElementController@show')->name('menu.show');
    //         Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
    //     });
        // Route::prefix('menu/menu')->group(function () { 
        //     Route::get('/',         'MenuController@index')->name('menu.menu.index');
        //     Route::get('/create',   'MenuController@create')->name('menu.menu.create');
        //     Route::post('/store',   'MenuController@store')->name('menu.menu.store');
        //     Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
        //     Route::post('/update',  'MenuController@update')->name('menu.menu.update');
        //     Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
        // });
        // Route::prefix('media')->group(function () {
        //     Route::get('/',                 'MediaController@index')->name('media.folder.index');
        //     Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
        //     Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
        //     Route::get('/folder',           'MediaController@folder')->name('media.folder');
        //     Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
        //     Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

        //     Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
        //     Route::get('/file',             'MediaController@file');
        //     Route::post('/file/delete',     'MediaController@fileDelete')->name('media.file.delete');
        //     Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
        //     Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
        //     Route::post('/file/cropp',      'MediaController@cropp');
        //     Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');
        // });
    // });
// });
