<?php

Route::get('404', 'ThemeAuthController@error');
Route::post('send_request', 'ThemeAuthController@send_request');

Route::group(array('middleware' => 'Subscribed'), function(){

	/*
	|--------------------------------------------------------------------------
	| Home Page Routes
	|--------------------------------------------------------------------------
	*/
	
		Route::get('/', 'ThemeHomeController@index')->name('login');
		Route::get('/logoutall', 'ThemeAuthController@logoutShow');
		Route::get('/do-logout', 'ThemeAuthController@logoutAll');

	/*
	|--------------------------------------------------------------------------
	| Video Page Routes
	|--------------------------------------------------------------------------
	*/

		Route::get('videos', array('uses' => 'ThemeVideoController@videos', 'as' => 'videos') );
		Route::get('videos/category/{category}', 'ThemeVideoController@category' );
		Route::get('live/{category}/{title}', 'ThemeVideoController@category_title' );
		Route::get('videos/tag/{tag}', 'ThemeVideoController@tag' );
		//Route::get('video/{id}', 'ThemeVideoController@index');
		Route::get('allvideos', 'ThemeVideoController@allvideos');
		Route::get('video/{id}/{title}', 'ThemeVideoController@video');
		Route::get('videos/{category}/{title}', 'ThemeVideoController@video_cate');
        Route::post('updatecurrentvideoview', 'ThemeVideoController@updateCurrentVideoViews');
		Route::post('live', 'ThemeFavoriteController@live');



	/*
	|--------------------------------------------------------------------------
	| Favorite Routes
	|--------------------------------------------------------------------------
	*/

		Route::post('favorite', 'ThemeFavoriteController@favorite');
		Route::get('favorites', 'ThemeFavoriteController@show_favorites');
		Route::get('addvideos', 'ThemeFavoriteController@addvideos');
		Route::get('edit_video', 'ThemeFavoriteController@edit_video');
		Route::get('viewvideo', 'ThemeFavoriteController@viewvideo');
		Route::post('create_video_user', 'ThemeFavoriteController@create_video_user');
		Route::post('edit_video_user', 'ThemeFavoriteController@edit_video_user');
		Route::get('my_video', 'ThemeFavoriteController@my_video');
//		Route::get('livevideo', 'ThemeFavoriteController@livevideo');
		Route::get('live', 'ThemeFavoriteController@livevideo');
		Route::get('policy', 'ThemeFavoriteController@policy');
		Route::get('about', 'ThemeFavoriteController@about');
		Route::get('show', 'ThemeFavoriteController@show');
		Route::get('admin_view_contribute_video', 'ThemeFavoriteController@admin_view_contribute_video');


	/*
	|--------------------------------------------------------------------------
	| Post Page Routes
	|--------------------------------------------------------------------------
	*/

		Route::get( 'posts', array('uses' => 'ThemePostController@posts', 'as' => 'posts') );
		Route::get( 'posts/category/{category}', 'ThemePostController@category' );
		Route::get( 'post/{slug}', 'ThemePostController@index' );


	/*
	|--------------------------------------------------------------------------
	| Page Routes
	|--------------------------------------------------------------------------
	*/

		Route::get('pages', 'ThemePageController@pages');
		Route::get('page/{slug}', 'ThemePageController@index');
		
	/*
	|--------------------------------------------------------------------------
	| Update Video view from wistia
	|--------------------------------------------------------------------------
	*/

		Route::get('videoviewupdate', 'UpdateVideoViewController@updateVideoViewsWistia');
		Route::get('createUpdateDb', 'UpdateVideoViewController@createUpdateDb');
		//Route::get('page/{slug}', 'ThemePageController@index');	


	/*
	|--------------------------------------------------------------------------
	| Search Routes
	|--------------------------------------------------------------------------
	*/

		Route::get('search', 'ThemeSearchController@index');

	/*
	|--------------------------------------------------------------------------
	| Auth and Password Reset Routes
	|--------------------------------------------------------------------------
	*/
		Route::get('check_email/{email}','ThemeAuthController@check_email');
		
		Route::get('login', 'ThemeAuthController@login_form');
		//Route::get('signup', 'ThemeAuthController@signup_form');
		Route::get('upload', 'ThemeAuthController@upload');
		Route::post('add_file', 'ThemeAuthController@add_file');

		Route::post('generate_coupon', 'ThemeAuthController@generate_coupon');
		Route::post('generate_coupon1', 'ThemeAuthController@generate_coupon1');

		Route::post('login', 'ThemeAuthController@login');
		Route::post('userregistration', 'ThemeAuthController@userregistration');
        Route::get('my_payment', 'ThemeAuthController@my_payment');
        Route::get('my_purchase', 'ThemeAuthController@my_purchase');
		Route::get('contribute', 'ThemeAuthController@contribute');
		Route::post('contributecreate', 'ThemeAuthController@contributecreate');
		Route::get('password/reset', array('middleware' => 'demo', 'uses' => 'ThemeAuthController@password_reset', 'as' => 'password.remind'));
		Route::post('password/reset', array('middleware' => 'demo', 'uses' => 'ThemeAuthController@password_request', 'as' => 'password.request'));
		Route::get('password/reset/{token}', array('middleware' => 'demo', 'uses' => 'ThemeAuthController@password_reset_token', 'as' => 'password.reset'));
		Route::post('password/reset/{token}', array('middleware' => 'demo', 'uses' => 'ThemeAuthController@password_reset_post', 'as' => 'password.update'));

		Route::get('verify/{activation_code}', 'ThemeAuthController@verify');
		Route::get('Admin/emailformate', 'AdminUsersController@emailformate');

	/*
	|--------------------------------------------------------------------------
	| User and User Edit Routes
	|--------------------------------------------------------------------------
	*/

		Route::get('user/{username}', 'ThemeUserController@index');
		Route::get('user/{username}/edit', 'ThemeUserController@edit');
		Route::post('user/{username}/update', array('middleware' => 'demo', 'uses' => 'ThemeUserController@update'));
		Route::get('user/{username}/billing', array('middleware' => 'demo', 'uses' => 'ThemeUserController@billing'));
		Route::get('user/{username}/cancel', array('middleware' => 'demo', 'uses' => 'ThemeUserController@cancel_account'));
		Route::get('user/{username}/resume', array('middleware' => 'demo', 'uses' => 'ThemeUserController@resume_account'));
		Route::get('user/{username}/update_cc', 'ThemeUserController@update_cc');

}); // End if_logged_in_must_be_subscribed route
Route::get('user/subscription', 'ThemeUserController@subscription');
Route::get('user/{username}/renew_subscription', 'ThemeUserController@renew');
Route::post('user/{username}/update_cc', array('middleware' => 'demo', 'uses' => 'ThemeUserController@update_cc_store'));

Route::get('user/{username}/upgrade_subscription', 'ThemeUserController@upgrade');
Route::post('user/{username}/upgrade_cc', array('middleware' => 'demo', 'uses' => 'ThemeUserController@upgrade_cc_store'));

Route::get('logout', 'ThemeAuthController@logout');
Route::get('success', 'ThemeAuthController@success');
Route::get('success1', 'ThemeAuthController@success1');
Route::get('subscription_plan', 'ThemeAuthController@subscription_plan');

Route::get('upgrade', 'UpgradeController@upgrade');

Route::get('upload_dir', function(){
	echo Config::get('site.uploads_dir');
});
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

	Route::group(array('middleware' => ['auth' , 'isAdmin'] ), function(){

		// Admin Dashboard
		Route::get('admin', 'AdminController@index');
		Route::get('admin/viewershipdashboard', 'AdminController@viwershipDashboard');

		// Admin Video Functionality
		Route::get('admin/videos', 'AdminVideosController@index');
		Route::get('admin/videos/{id}/publish', 'AdminVideosController@publish');
		Route::get('admin/videos/{id}/unpublish', 'AdminVideosController@unpublish');
		Route::get('admin/videos/index3', 'AdminVideosController@index3');
		Route::get('admin/videos/ad/edit/{id}', 'AdminVideosController@showEditAdd');
		Route::post('admin/videos/ad/edit/{id}', 'AdminVideosController@editAdd');
		Route::post('admin/videos/add_ads', 'AdminVideosController@add_ads');
		Route::post('admin/videos/post_add', 'AdminVideosController@post_add');
		Route::get('admin/videos/ad/{id}/disable', 'AdminVideosController@disable_add');

		Route::post('admin/videos/assignto', 'AdminVideosController@assignto');
		Route::get('admin/users/index4', 'AdminVideosController@index4');
		Route::get('admin/videos/index5', 'AdminVideosController@index5');
		Route::get('admin/videos/index6', 'AdminVideosController@index6');
		Route::post('admin/videos/thumbsection', 'AdminVideosController@thumbsection');
		Route::get('admin/videos/banner', 'AdminVideosController@banner');
		Route::post('admin/videos/addbanner', 'AdminVideosController@addbanner');



		Route::get('admin/videos/index1', 'AdminVideosController@index1');
		Route::get('admin/videos/edit/{id}', 'AdminVideosController@edit');
		Route::post('admin/videos/update', array('middleware' => 'demo', 'uses' => 'AdminVideosController@update'));
		Route::get('admin/videos/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminVideosController@destroy'));
		Route::get('admin/videos/create', 'AdminVideosController@create');
		Route::post('admin/videos/store', array('middleware' => 'demo', 'uses' => 'AdminVideosController@store'));

		Route::get('admin/videos/create1', 'AdminVideosController@create1');
		Route::post('admin/videos/store1', array('middleware' => 'demo', 'uses' => 'AdminVideosController@store1'));
		Route::get('admin/videos/edit1/{id}', 'AdminVideosController@edit1');
		Route::post('admin/videos/update1', array('middleware' => 'demo', 'uses' => 'AdminVideosController@update1'));

		Route::get('admin/videos/categories', 'AdminVideoCategoriesController@index');
		Route::post('admin/videos/categories/store', array('middleware' => 'demo', 'uses' => 'AdminVideoCategoriesController@store'));
		Route::post('admin/videos/categories/order', array('middleware' => 'demo', 'uses' => 'AdminVideoCategoriesController@order'));
		Route::get('admin/videos/categories/edit/{id}', 'AdminVideoCategoriesController@edit');
		Route::post('admin/videos/categories/update', array('middleware' => 'demo', 'uses' => 'AdminVideoCategoriesController@update'));
		Route::get('admin/videos/categories/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminVideoCategoriesController@destroy'));
        Route::get('admin/content/create1', 'AdminPostController@create1');
		Route::post('admin/content/editabout', 'AdminPostController@editabout');
		Route::get('admin/content/addpolicy', 'AdminPostController@addpolicy');
		Route::post('admin/content/editpolicy', 'AdminPostController@editpolicy');
		Route::get('admin/posts', 'AdminPostController@index');
		Route::get('admin/posts/create', 'AdminPostController@create');
		Route::post('admin/posts/store', array('middleware' => 'demo', 'uses' => 'AdminPostController@store'));
		Route::get('admin/Subscribe', 'AdminPostController@index');
		Route::get('admin/Subscribe/create', 'AdminPostController@create');
		Route::post('admin/Subscribe/store', array('middleware' => 'demo', 'uses' => 'AdminPostController@store'));
		Route::get('admin/Subscribe/edit/{id}', 'AdminPostController@edit');
		Route::post('admin/Subscribe/update', array('middleware' => 'demo', 'uses' => 'AdminPostController@update'));
		Route::get('admin/Subscribe/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminPostController@destroy'));
		Route::get('admin/posts/edit/{id}', 'AdminPostController@edit');
		Route::post('admin/posts/update', array('middleware' => 'demo', 'uses' => 'AdminPostController@update'));
		Route::get('admin/posts/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminPostController@destroy'));
		Route::get('admin/posts/categories', 'AdminPostCategoriesController@index');
		Route::post('admin/posts/categories/store', array('middleware' => 'demo', 'uses' => 'AdminPostCategoriesController@store'));
		Route::post('admin/posts/categories/order', array('middleware' => 'demo', 'uses' => 'AdminPostCategoriesController@order'));
		Route::get('admin/posts/categories/edit/{id}', 'AdminPostCategoriesController@edit');
		Route::get('admin/posts/categories/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminPostCategoriesController@destroy'));
		Route::post('admin/posts/categories/update', array('middleware' => 'demo', 'uses' => 'AdminPostCategoriesController@update'));

		Route::get('admin/media', 'AdminMediaController@index');
		Route::post('admin/media/files', 'AdminMediaController@files');
		Route::post('admin/media/new_folder', 'AdminMediaController@new_folder');
		Route::post('admin/media/delete_file_folder', 'AdminMediaController@delete_file_folder');
		Route::get('admin/media/directories', 'AdminMediaController@get_all_dirs');
		Route::post('admin/media/move_file', 'AdminMediaController@move_file');
		Route::post('admin/media/upload', 'AdminMediaController@upload');
		Route::get('admin/manage/manage', 'AdminMediaController@manage');
		Route::get('admin/manage/create', 'AdminMediaController@create');
		Route::post('admin/manage/add_revenue', 'AdminMediaController@add_revenue');
		Route::get('admin/manage/edit', 'AdminMediaController@edit');
		Route::get('admin/manage/delete', 'AdminMediaController@delete_revenue');
		Route::post('admin/manage/edit_revenue', 'AdminMediaController@edit_revenue');


		Route::get('admin/coupon', 'AdminMediaController@index2');
		Route::post('admin/coupon/create_coupon', 'AdminMediaController@create_coupon');
		Route::post('admin/coupon/edit_coupon', 'AdminMediaController@edit_coupon');

		Route::get('admin/payment/index1', 'AdminMediaController@index1');
		Route::get('admin/checkrevenue', 'AdminMediaController@checkRevenue');
		Route::get('admin/payment/contributorpay', 'AdminMediaController@contributorpay');
		Route::get('admin/payment/managecontributorpayment', 'AdminMediaController@managecontributorpayment');
		Route::post('admin/payment/make_contributor_payment', 'AdminMediaController@makecontributorpayment');
		Route::post('admin/payment/updatecontributoramount', 'AdminMediaController@updatecontributorpayment');
		Route::post('admin/payment/updatecontributorpaymentstatus', 'AdminMediaController@updatecontributorpaymentstatus');
		Route::get('admin/trackrevenue', 'AdminController@trackRevenue');

		Route::get('file_upload', function(){
			echo phpinfo();
		});

		Route::get('admin/pages', 'AdminPageController@index');
		Route::get('admin/pages/create', 'AdminPageController@create');
		Route::post('admin/pages/store', array('middleware' => 'demo', 'uses' => 'AdminPageController@store'));
		Route::get('admin/pages/edit/{id}', 'AdminPageController@edit');
		Route::post('admin/pages/update', array('middleware' => 'demo', 'uses' => 'AdminPageController@update'));
		Route::get('admin/pages/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminPageController@destroy'));


		Route::get('admin/users', 'AdminUsersController@index');
		Route::get('admin/user/contributor_req', 'AdminUsersController@contributor_req');
		Route::get('admin/user/create', 'AdminUsersController@create');
		Route::post('admin/user/store', array( 'uses' => 'AdminUsersController@store'));
		Route::get('admin/user/edit/{id}', 'AdminUsersController@edit');
		Route::get('admin/user/editstatus/{id}', 'AdminUsersController@editstatus');
		Route::get('admin/user/editstatus1/{id}', 'AdminUsersController@editstatus1');

		Route::get('admin/user/create1', 'AdminUsersController@create1');
		Route::post('admin/user/store1', array( 'uses' => 'AdminUsersController@store1'));

		Route::get('admin/user/upload', 'AdminUsersController@upload');
		Route::post('admin/user/add_file', 'AdminUsersController@add_file');
		Route::post('admin/users/user_actions', 'AdminUsersController@user_actions');

		Route::get('admin/user/edit1/{id}', 'AdminUsersController@edit1');
		Route::post('admin/user/update1', array('middleware' => 'demo', 'uses' => 'AdminUsersController@update1'));
		Route::get('admin/users/index1', 'AdminUsersController@index1');
		
		Route::get('admin/users/corporate_user', 'AdminUsersController@corporate_user');

		Route::get('admin/user/create2', 'AdminUsersController@create2');
		Route::post('admin/user/store2', array( 'uses' => 'AdminUsersController@store2'));
		Route::get('admin/user/editstatus2/{id}', 'AdminUsersController@editstatus2');
		Route::get('admin/user/editstatus3/{id}', 'AdminUsersController@editstatus3');
		Route::get('admin/user/edit2/{id}', 'AdminUsersController@edit2');
		Route::post('admin/user/update2', array('middleware' => 'demo', 'uses' => 'AdminUsersController@update2'));
		Route::post('admin/user/update', array('middleware' => 'demo', 'uses' => 'AdminUsersController@update'));

		Route::get('admin/user/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminUsersController@destroy'));

		Route::get('admin/menu', 'AdminMenuController@index');
		Route::post('admin/menu/store', array('middleware' => 'demo', 'uses' => 'AdminMenuController@store'));
		Route::get('admin/menu/edit/{id}', 'AdminMenuController@edit');
		Route::post('admin/menu/update', array('middleware' => 'demo', 'uses' => 'AdminMenuController@update'));
		Route::post('admin/menu/order', array('middleware' => 'demo', 'uses' => 'AdminMenuController@order'));
		Route::get('admin/menu/delete/{id}', array('middleware' => 'demo', 'uses' => 'AdminMenuController@destroy'));

		Route::get('admin/plugins', 'AdminPluginsController@index');
		Route::get('admin/plugin/deactivate/{plugin_name}', 'AdminPluginsController@deactivate');
		Route::get('admin/plugin/activate/{plugin_name}', 'AdminPluginsController@activate');

		Route::get('admin/themes', 'AdminThemesController@index');
		Route::get('admin/theme/activate/{slug}', array('middleware' => 'demo', 'uses' => 'AdminThemesController@activate'));

		Route::get('admin/settings', 'AdminSettingsController@index');
		Route::post('admin/settings', array('middleware' => 'demo', 'uses' => 'AdminSettingsController@save_settings'));

		Route::get('admin/payment_settings', 'AdminPaymentSettingsController@index');
		Route::post('admin/payment_settings', array('middleware' => 'demo', 'uses' => 'AdminPaymentSettingsController@save_payment_settings'));

		Route::get('admin/theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
		Route::get('admin/theme_settings', 'AdminThemeSettingsController@theme_settings');
		Route::post('admin/theme_settings', array('middleware' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings'));
	});

/*
|--------------------------------------------------------------------------
| Payment Webhooks
|--------------------------------------------------------------------------
*/
	Route::get('admin/send/request', 'ThemeVideoController@send_request' );
	Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');
