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

// Route::get('/plans', 'Frunted\FruntedController@index')->name('index');
Route::get('/pricing', 'Frunted\FruntedController@pricing')->name('pricing');
// Route::group(['prefix' => '', 'middleware' => 'referral'], function () {
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::get('/register', 'Auth\RegisterController@register')->name('register');
// });

Route::post('/user_register', 'Auth\RegisterController@user_register')->name('user_register');

//facebook login
Route::get('/facebook/login', 'Auth\FacebookLoginController@redirectToFacebook')->name('facebook_login');
Route::get('/facebook/success', 'Auth\FacebookLoginController@facebook_success')->name('facebook_success');

//facebook login
Route::get('/linkedin/login', 'Auth\LinkedinLoginController@redirectTolinkedin')->name('linkedin_login');
Route::get('/linkedin/success', 'Auth\LinkedinLoginController@linkedin_success')->name('linkedin_success');
Route::get('/linkedin/cancel', 'Auth\LinkedinLoginController@linkedin_cancel')->name('linkedin_cancel');

Route::get('/mail/replay/{id}', 'MessageController@replayMail')->name('replayMail');
Route::post('/replay', 'MessageController@send')->name('send');
Route::get('/Privacy', 'Frunted\FruntedController@Privacy')->name('Privacy');

Route::post('/save-journalist', ['as' => 'bot', 'uses' => 'JournalistsEmailController@saveJournalist']);

Route::post('/find-journalist', 'JournalistsEmailController@findJournalist');
Route::post('/check-url-good-for-iframe', 'HomeController@checkUrlGoodForIframe');

Route::post('/sendgrid/events', 'MessageController@sendgrid_events');

//displaying data in news alerts table
Route::post('/subscribe-news-alerts', 'NewsAlertsController@subscribe_news_alerts');
// Route::get('/news-alerts/delete/{id}', 'NewsAlertsController@subscribe_news_alert_delete')->name('news_alert_delete');

Route::post('/news-alerts/last-alert', 'NewsAlertsController@last_alert');

//Videos
Route::get('/videos', 'videoRecorderController@index')->name('videoRecorder');
Route::post('/ajax/request-s3-file-signature', 'videoRecorderController@dropzone')->name('request-s3-file-signature');
Route::post('/save-video-attributes', 'videoRecorderController@saveAttributes')->name('saveAttributes');
Route::get('/video/delete/{id}', 'videoRecorderController@video_delete')->name('videoDelete');

Route::post('/chet/bot/api', ['as' => 'bot', 'uses' => 'Chet_botController@store']);
Route::get('/view-video/{userId}/{videoId}/{filename}', 'VideoController@view')->name('video_view');
Route::post('/group/save', 'User\GroupController@store')->name('group_save');

Auth::routes();
Route::group(['prefix' => '', 'middleware' => 'redirect'], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::post('/', 'HomeController@home')->name('home_month');

    Route::get('/', 'HomeController@home')->name('index');
    Route::post('/Date', 'HomeController@home_type_date')->name('home_type_date');

    Route::get('/search-journalists', 'HomeController@searchJournalists')->name('searchJournalists');
    Route::get('/search-articles', 'HomeController@searchArticles')->name('searchArticles');
    Route::get('/article/{id}', 'HomeController@singleArticle')->name('singleArticle');
    Route::get('/list', 'HomeController@list')->name('list');

    Route::post('/send-pitch-list', 'HomeController@sendListPitch')->name('send_list_pitch');

    Route::get('/latest-pitch', 'HomeController@latestPitch')->name('individualCampaign');
    Route::get('/individual-campaign', 'HomeController@individualCampaign')->name('individualCampaign');
    Route::get('/individual-compose/{id}', 'HomeController@individualCompose')->name('individualCompose');
    Route::get('/individual-list', 'HomeController@individualList')->name('individualList');

//ImageCrop Requirements

// Route::get('image-crop', 'ImageController@imageCrop');
    Route::post('image-crop', 'ImageController@imageCropPost');

    Route::get('/news-alerts/subscribed/{id}', 'NewsAlertsController@show_subscribed_news');

//NEWS ALERTS LINKS

    Route::get('/news-alerts/delete/{id}', 'NewsAlertsController@subscribe_news_alert_delete');
    Route::post('/subscribe-news-journalist', 'NewsAlertsController@subscribe_news_journalist')->name('subscribe_news_journalist');

//ImageCrop End

    Route::POST('/admin/csv', 'admin\JournalistsController@csv')->name('csv');

    //Dashboard
    Route::get('/show_email_click_list/{message_id}', 'HomeController@show_email_click_list')->name('show_email_click_list');

    //Profile
    Route::get('/profile', 'User\ProfileController@index')->name('profile');
    Route::post('/profile/update/info', 'User\ProfileController@update_profile_info')->name('update_profile_info');
    Route::post('/profile/update/password', 'User\ProfileController@update_profile_pass')->name('update_profile_pass');
    Route::post('/profile/update/image', 'User\ProfileController@update_profile_image')->name('update_profile_image');
    Route::get('/profile/delete/image/', 'User\ProfileController@delete_profile_image')->name('delete_profile_image');

    //sub user profile
    Route::get('/user/profile/{id}', 'User\ProfileController@user_profile_index')->name('user_profile_index');
    Route::post('/sub_profile/update/info', 'User\ProfileController@update_sub_profile_info')->name('update_sub_profile_info');
    Route::post('/sub_profile/update/password', 'User\ProfileController@update_sub_profile_pass')->name('update_sub_profile_pass');

    //user
    Route::resource('sub_user', 'User\SubUserController');

    //Journalists
    Route::get('/Journalists/search', 'User\JournalistsController@index')->name('contact_index');

    //email finder journalist'

    //group
    Route::get('/group', 'User\GroupController@index')->name('group_index');
    Route::get('/group/member/{id}', 'User\GroupController@group_member')->name('group_member');
    Route::post('/group/store', 'User\GroupController@store')->name('group_store');

    Route::get('/group/delete/{id}', 'User\GroupController@delete')->name('group_delete');
    Route::get('/member/delete/{id}', 'User\GroupController@member_delete')->name('member_delete');

    //Message
    Route::get('/message', 'MessageController@inbox')->name('message');
    Route::get('/message/create', 'MessageController@create')->name('message_create');
    Route::post('/message/save-draft', 'MessageController@saveDraft')->name('message_save_draft');

    Route::get('/campaign/edit/{id}', 'MessageController@editCampaign')->name('campaign_edit');
    Route::get('/campaign/delete/{id}', 'MessageController@deleteCampaign')->name('campaign_delete');

    Route::get('/format-key', 'HomeController@formatKeywordsView')->name('format_key');

    Route::get('/format-keywords', 'HomeController@formatKeywords')->name('format_keywords');

    // Route::get('/message/show/{id}', 'MessageController@show')->name('message_show');
    Route::get('/message/chatrooms/{campaignId}', 'MessageController@getChatRooms')->name('message_show_chatrooms');
    Route::get('/message/show/{campaignId}/{groupId}', 'MessageController@getMessages')->name('message_show');

    Route::get('/messages/show/{id}', 'MessageController@messages_show')->name('messages_show');
    Route::post('/mail/send', 'MessageController@sendMail')->name('sendMail');

    Route::post('/mail/chet', 'MessageController@chetMail')->name('chetMail');

    Route::post('/chat_search_name/', 'MessageController@search_name')->name('search_name');

    //Reports
    Route::get('/reports/', 'ReportsController@reports')->name('reports');
    Route::get('/reports/{id}', 'ReportsController@getReports')->name('getReports');
    // Route::get('/reports/{id}', 'ReportsController@getReports')->name('getReports');
    Route::post('/reports/by-date/{id}', 'ReportsController@getReportsByDate')->name('getReportsByDate');
    // $message[0]

    //Profile
    // Route::get('/profile', 'ProfileControllerTest@profiletest')->name('profile');

    //NewsAlert
    Route::get('/news-jacking', 'NewsAlertsController@news_alerts')->name('news_alerts');
    // Route::post('/subscribe-news-alerts', 'NewsAlertsController@subscribe_news_alerts');

    //Campaign Page
    Route::get('/campaigns', 'CampaignController@campaigns')->name('campaigns');

    //SideBar Ajx Route
    Route::get('/side-bar', 'SideBarController@sideBarMsg')->name('side_bar');

    Route::post('/pay/agency', 'PlanController@pay_with_agency')->name('pay_with_agency');

    Route::get('/stripe/create-plans', 'PlanController@create_plan')->name('create_plan');

});
Route::get('/walkthrough-completed', 'PlanController@walkthrough')->name('walkthrough');

Route::group(['prefix' => '', 'middleware' => ['redirect', 'referral']], function () {
    Route::get('/plan/view', 'PlanController@view')->name('plan_view');
    //Plan
    Route::get('/plan/lite/monthly', 'PlanController@hooty_lite_monthly')->name('hooty_lite_monthly');
    Route::get('/plan/lite/yearly', 'PlanController@hooty_lite_yearly')->name('hooty_lite_yearly');
    // Route::get('/plan/agency', 'PlanController@agency_plan')->name('agency_plan');

    Route::get('/paln/renewal', 'PlanController@renewal_plan')->name('renewal_plan');
    //pay
    Route::get('/payment/success', 'PlanController@payment_success')->name('payment_success');

// Route::post("/walkthrough-completed","PlanController@Wal")
    Route::post('pay/lite/update', 'PlanController@update_plan')->name('update_plan');
    Route::get('pay/lite/resume', 'PlanController@resume_plan')->name('resume_plan');
    Route::get('pay/lite/cancel', 'PlanController@cancel_plan')->name('cancel_plan');

    // Route::post('/pay/lite/monthly', 'PlanController@pay_lite_monthly')->name('pay_lite_monthly');
    // Route::post('/pay/lite/yearly', 'PlanController@pay_lite_yearly')->name('pay_lite_yearly');

    // Route::post("/walkthrough-completed","PlanController@Wal")

});

Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::post('/pay/lite/monthly', 'PlanController@pay_lite_monthly')->name('pay_lite_monthly');
    Route::post('/pay/lite/yearly', 'PlanController@pay_lite_yearly')->name('pay_lite_yearly');
    Route::post('pay/lite/update', 'PlanController@update_plan')->name('update_plan');
    Route::get('pay/lite/cancel', 'PlanController@cancel_plan')->name('cancel_plan');
    //pay
    Route::get('/payment/success', 'PlanController@payment_success')->name('payment_success');
});

Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
Route::get('/admin/', 'Auth\AdminAuthController@getLogin');
Route::get('/admin/logout', 'Auth\AdminAuthController@logout')->name('admin_logout');
Route::post('/admin/login', 'Auth\AdminAuthController@postLogin')->name('admin_login');
Route::group(['prefix' => '', 'middleware' => 'adminauth'], function () {
    Route::get('/admin/home', 'Admin\CommenController@home')->name('admin_home');
    Route::post('/admin/home', 'Admin\CommenController@home')->name('admin_home_month');

    //JournaList
    Route::get('/admin/JournaList', 'Admin\CommenController@JournaList')->name('admin_JournaList');
    Route::get('/admin/statistics', 'Admin\CommenController@statistics')->name('admin_Statistics');
    Route::POST('/admin/csv', 'Admin\CommenController@csv')->name('csv');
    Route::POST('/admin/JournaList/delete', 'Admin\CommenController@JournaList_delete')->name('JournaList_delete');

    //message
    Route::get('/admin/message/user', 'Admin\UserController@message_user')->name('admin_message_user');
    Route::get('/admin/message/{user_id}', 'Admin\ChetController@index')->name('admin_message');
    Route::get('/admin/chet/{user_id}', 'Admin\ChetController@chet')->name('admin_chet');
    Route::get('/admin/chets/{user_id}', 'Admin\ChetController@chets')->name('admin_chets');
    Route::post('/admin/chat_search_name/', 'Admin\ChetController@chat_search_name')->name('chat_search_name');

    //User
    Route::get('/admin/user', 'Admin\UserController@index')->name('admin_user');
    Route::get('/admin/user-profile/{user_id}', 'Admin\UserController@user_profile')->name('user_profile');
    Route::get('/admin/sub-user/{user_id}', 'Admin\UserController@admin_sub_user')->name('admin_sub_user');
    Route::get('/admin/sub-user-profile/{user_id}', 'Admin\UserController@admin_sub_user_profile')->name('admin_sub_user_profile');
    Route::get('/admin/user/member/{group_id}', 'Admin\UserController@admin_user_member')->name('admin_user_member');
    Route::get('/admin/user/block/{user_id}', 'Admin\UserController@admin_user_block')->name('admin_user_block');
    Route::get('/admin/user/active/{user_id}', 'Admin\UserController@admin_user_active')->name('admin_user_active');

});
