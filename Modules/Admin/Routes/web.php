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

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return "Sunny管理後台";
    });
    Route::get('/test', 'AdminController@test');
    //登录
    Route::get('/login', 'LoginController@login')->name("login");
    //獲取驗證碼
    Route::get('/get_img_code','IndexController@get_img_code')->name('get_img_code');

    //視圖
    Route::get('/index', 'IndexController@index')->name("admin_index");
    //管理員管理
    Route::get('/admin_list', 'AdminController@admin_list')->name("admin_list");
    Route::get('/admin_edit/{id?}', 'AdminController@admin_edit')->name("admin_edit")->where(["id" => 'nullable|[0-9]*']);
    //管理員身份
    Route::get('/role_list', 'AdminController@role_list')->name("role_list");
    Route::get('/role_edit/{id?}', 'AdminController@role_edit')->name("role_edit")->where(["id" => 'nullable|[0-9]*']);
    //群組管理
    Route::get('/group_list', 'AdminController@group_list')->name("group_list");
    Route::get('/group_edit/{id?}', 'AdminController@group_edit')->name("group_edit")->where(["id" => 'nullable|[0-9]*']);
    //菜單權限
    Route::get('/menu_list', 'AdminController@menu_list')->name("menu_list");

    //Banners管理
    Route::post('upload', 'UploadController@upload')->name("upload");
    Route::get('banner/big_list', 'BannerController@big_list')->name("banner_big_list");
    Route::get('banner/big_edit/{id?}', 'BannerController@big_edit')->name("banner_big_edit");
    Route::get('banner/below_list', 'BannerController@below_list')->name("banner_below_list");
    Route::get('banner/below_edit/{id?}', 'BannerController@below_edit')->name("banner_below_edit");
    Route::get('banner/middle_list', 'BannerController@middle_list')->name("banner_middle_list");
    Route::get('banner/middle_edit/{id?}', 'BannerController@middle_edit')->name("banner_middle_edit");
    Route::get('banner/middle_carousel_list', 'BannerController@middle_carousel_list')->name("banner_middle_carousel_list");
    Route::get('banner/middle_carousel_edit/{id?}', 'BannerController@middle_carousel_edit')->name("banner_middle_carousel_edit");
    Route::get('banner/sales_list', 'BannerController@sales_list')->name("banner_sales_list");
    Route::get('banner/sales_edit/{id?}', 'BannerController@sales_edit')->name("banner_sales_edit");
    Route::get('banner/team_buy_list', 'BannerController@team_buy_list')->name("banner_team_buy_list");
    Route::get('banner/team_buy_edit/{id?}', 'BannerController@team_buy_edit')->name("banner_team_buy_edit");
    Route::get('banner/dividend_list', 'BannerController@dividend_list')->name("banner_dividend_list");
    Route::get('banner/dividend_edit/{id?}', 'BannerController@dividend_edit')->name("banner_dividend_edit");

   //網站設定
    Route::get('website/{type}', 'WebsiteController@index')->name("website_index");
    //搜尋管理
    Route::get('keyword/history', 'KeywordController@history')->name("keyword_history");
    Route::get('keyword/hint', 'KeywordController@hint')->name("keyword_hint");
    Route::get('keyword/hint_edit', 'KeywordController@hintEdit')->name("keyword_hint_edit");
    Route::get('keyword/hot', 'KeywordController@hot')->name("keyword_hot");
    //物流
    Route::get('logistics', 'LogisticsController@index')->name("logistics");
    //發票
    Route::get('invoice', 'InvoiceController@index')->name("invoice");
   //footer
    Route::get('menu_footer/{id?}', 'MenuFooterController@index')->name("menu_footer");
    //支付方式
    Route::get('pay_way/{id?}', 'PayWayController@index')->name("pay_way");
    //歡迎頁
    Route::get('welcome/app_list', 'WelcomePageController@appList')->name("welcome_app_list");
    Route::get('welcome/app_edit/{id?}', 'WelcomePageController@appEdit')->name("welcome_app_edit");
    Route::get('welcome/ad_list', 'WelcomePageController@adList')->name("welcome_ad_list");
    Route::get('welcome/ad_edit/{id?}', 'WelcomePageController@adEdit')->name("welcome_ad_edit");
    //導航欄
    Route::get('navi', 'NaviController@index')->name("navi_index");
    //品牌管理
    Route::get('brand', 'BrandController@index')->name("brand_index");
    Route::get('brand/recommend', 'BrandRecommendController@index')->name("brand_recommend_index");
    //廣告
    Route::get('advertisement/{type}', 'AdvertisementController@index')->name("advertisement_list");
    //卡友好康
    Route::get('banner/kayou', 'BannerController@kayou')->name("banner_kayou_index");
    //中間活動
    Route::get('banner/middle_activity', 'BannerController@middle_activity')->name("banner_middle_activity_index");

    //會員專區
    Route::get('banner/member', 'BannerController@member')->name("banner_member_index");
    Route::get('banner/member_edit/{id?}', 'BannerController@memberEdit')->name("banner_member_edit");
    //熱門館別
    Route::get('annexe_hot', 'AnnexeHotController@index')->name("annexe_hot_index");
    Route::get('annexe_hot/edit/{id?}', 'AnnexeHotController@edit')->name("annexe_hot_edit");
    //強檔推薦
    Route::get('season_recommend', 'SeasonRecommendController@index')->name("season_recommend_index");
    Route::get('season_recommend/edit/{id?}', 'SeasonRecommendController@edit')->name("season_recommend_edit");
    //精選專區
    Route::get('choiceness', 'ChoicenessController@index')->name("choiceness_index");
    Route::get('choiceness/edit/{id?}', 'ChoicenessController@edit')->name("choiceness_edit");

    //會員模塊
    Route::get('user', 'UserController@index')->name("user_index");
    Route::get('user/edit/{id?}', 'UserController@edit')->name("user_edit");
    Route::get('user/add', 'UserController@add')->name("user_add");
    //等級設定
    Route::get('grade', 'GradeController@index')->name("grade_index");
    Route::get('grade/edit/{id?}', 'GradeController@edit')->name("grade_edit");

    //银行红利專區
    Route::get('bank/dividend', 'BankDividendController@index')->name("bank_dividend_index");

    //分類管理
    Route::get('classify/{id?}', 'ClassifyController@index')->name("classify_index");
    Route::get('classify_edit/{pid?}', 'ClassifyController@edit')->name("classify_edit");
    Route::get('classify_add', 'ClassifyController@add')->name("classify_add");
    //店家
    Route::get('store/{id?}', 'StoreController@index')->name("store_index");
    Route::get('store_edit/{id?}', 'StoreController@edit')->name("store_edit");
    //分店
    Route::get('branch/{pid?}', 'StoreController@branch')->name("branch");
    Route::get('branch_edit/{pid?}/{id?}', 'StoreController@branchedit')->name("branch_edit");
    //產業類別
    Route::get('industry_category/{pid?}', 'StoreController@industry_category')->name("industry_category");
    Route::get('industry_category_edit/{id?}', 'StoreController@industry_category_edit')->name("industry_category_edit");
    //商圈
    Route::get('shopping_street', 'ShoppingStreetController@index')->name("shopping_street_index");
    Route::get('shopping_street_edit/{id?}', 'ShoppingStreetController@edit')->name("shopping_street_edit");
    Route::get('shopping_street/branch/{sid?}', 'ShoppingStreetController@branch')->name("shopping_street_branch");
    Route::get('shopping_street/branch_edit/{sid?}/{id?}', 'ShoppingStreetController@branchedit')->name("shopping_street_branch_edit");
    //購買方案
    Route::get('purchase_scheme', 'PurchaseSchemeController@index')->name("purchase_scheme_index");
    Route::get('purchase_scheme_edit/{id?}', 'PurchaseSchemeController@edit')->name("purchase_scheme_edit");
    //點數售出
    Route::get('points_sold', 'PointsSoldController@index')->name("points_sold_index");
    Route::get('points_sold_edit/{id?}', 'PointsSoldController@edit')->name("points_sold_edit");
    //退款記錄
    Route::get('refund', 'RefundController@index')->name("refund_index");
    Route::get('refund_edit/{id?}', 'RefundController@edit')->name("refund_edit");
    //請款記錄
    Route::get('request_funds', 'RequestFundsController@index')->name("request_funds_index");
    Route::get('request_funds_edit/{id?}', 'RequestFundsController@edit')->name("request_funds_edit");
    //店家資料變更記錄
    Route::get('store_change', 'StoreChangeController@index')->name("store_change_index");
    Route::get('store_change_edit/{id?}', 'StoreChangeController@edit')->name("store_change_edit");
    //店家資料註冊記錄
    Route::get('store_register', 'StoreRegisterController@index')->name("store_register_index");
    Route::get('store_register_edit/{id?}', 'StoreRegisterController@edit')->name("store_register_edit");
    //店家與會員點數交易管理
    Route::get('users_points_deal', 'UsersPointsDealController@index')->name("users_points_deal_index");
    //商圈點數發放管理
    Route::get('points_grant', 'PointsGrantController@index')->name("points_grant_index");
    //店家廣告
    Route::get('store_advertising', 'StoreAdvertisingController@index')->name("store_advertising_index");
    Route::get('store_advertising_edit/{id?}', 'StoreAdvertisingController@edit')->name("store_advertising_edit");
    //電商廣告
    Route::get('ec_advertising', 'EcAdvertisingController@index')->name("ec_advertising_index");
    Route::get('ec_advertising_edit/{id?}', 'EcAdvertisingController@edit')->name("ec_advertising_edit");
    //推播管理
    Route::get('push_broadcast', 'PushBroadcastController@index')->name("push_broadcast_index");
    Route::get('push_broadcast_edit/{id?}', 'PushBroadcastController@edit')->name("push_broadcast_edit");
    //自動寄送模板管理
    Route::get('send_template', 'SendTemplateController@index')->name("send_template_index");
    Route::get('send_template_edit/{id?}', 'SendTemplateController@edit')->name("send_template_edit");
//-----------------------------------------分割線--------------------------------------------------------
//-----------------------------------------分割線--------------------------------------------------------
//-----------------------------------------分割線--------------------------------------------------------
//-----------------------------------------分割線--------------------------------------------------------
//-----------------------------------------分割線--------------------------------------------------------



    //管理員登入後
    Route::group(['middleware' => 'AdminAuth'], function () {
        //登入
        Route::post('login_in', 'LoginController@login_in')->name("login_in");

        Route::post('index/get_menu', 'IndexController@get_meun')->name("get_menu");
        Route::post('get_menu_list', 'AdminController@get_menu_list')->name("get_menu_list");
        Route::post('get_menu_select', 'AdminController@get_menu_select')->name("get_menu_select");
        Route::post('menu_update', 'AdminController@menu_update')->name("menu_update");
        Route::post('menu_del', 'AdminController@menu_del')->name("menu_del");

        /***********************************首页***************************************/
        //退出登录
        Route::post('index/logout', 'IndexController@logout')->name("logout");
        //修改密码
        Route::post('index/upadte_password', 'IndexController@upadte_password')->name("upadte_password");
        //刷新token
        Route::post('index/refresh_token', 'IndexController@refreshToken')->name("refresh_token");

        // 获取管理员信息
        Route::group(['middleware' => ['permission:admin_list']], function () {
            Route::post('get_admin_list', 'AdminController@get_admin_list')->name("get_admin_list");
        });
        Route::group(['middleware' => ['permission:admin_edit']], function () {
            Route::post('status', 'AdminController@status')->name("admin_status");
            Route::post('admin_update', 'AdminController@admin_update')->name("admin_update");
            Route::post('admin_add', 'AdminController@admin_add')->name("admin_add");
        });
        Route::group(['middleware' => ['permission:admin_delete']], function () {
            Route::post('admin_del', 'AdminController@admin_del')->name("admin_del");
        });

        //獲取管理員身份
        Route::group(['middleware' => ['permission:role_list']], function () {
            Route::post('get_role_list', 'AdminController@get_role_list')->name("get_role_list");
        });
        Route::group(['middleware' => ['permission:role_edit']], function () {
            Route::post('role_status', 'AdminController@role_status')->name("role_status");
            Route::post('role_update', 'AdminController@role_update')->name("role_update");
            Route::post('role_add', 'AdminController@role_add')->name("role_add");
        });
        Route::group(['middleware' => ['permission:role_delete']], function () {
            Route::post('role_del', 'AdminController@role_del')->name("role_del");
        });

        //獲取群組
        Route::group(['middleware' => ['permission:group_list']], function () {
            Route::post('get_group_list', 'AdminController@get_group_list')->name("get_group_list");
        });
        Route::group(['middleware' => ['permission:group_edit']], function () {
            Route::post('group_status', 'AdminController@group_status')->name("group_status");
            Route::post('group_update', 'AdminController@group_update')->name("group_update");
            Route::post('group_add', 'AdminController@group_add')->name("group_add");
        });
        Route::group(['middleware' => ['permission:group_delete']], function () {
            Route::post('group_del', 'AdminController@group_del')->name("group_del");
        });


        //Banners管理
        Route::post('banner/get_big_list', 'BannerController@get_big_list')->name("banner_get_big_list");
        Route::post('banner/big_add', 'BannerController@big_add')->name("banner_big_add");
        Route::post('banner/big_update', 'BannerController@big_update')->name("banner_big_update");
        Route::post('banner/big_del', 'BannerController@big_del')->name("banner_big_del");
        Route::post('banner/get_below_list', 'BannerController@get_below_list')->name("banner_get_below_list");
        Route::post('banner/below_add', 'BannerController@below_add')->name("banner_below_add");
        Route::post('banner/below_update', 'BannerController@below_update')->name("banner_below_update");
        Route::post('banner/below_del', 'BannerController@below_del')->name("banner_below_del");
        Route::post('banner/get_middle_list', 'BannerController@get_middle_list')->name("banner_get_middle_list");
        Route::post('banner/middle_add', 'BannerController@middle_add')->name("banner_middle_add");
        Route::post('banner/middle_update', 'BannerController@middle_update')->name("banner_middle_update");
        Route::post('banner/middle_del', 'BannerController@middle_del')->name("banner_middle_del");
        Route::post('banner/get_middle_carousel_list', 'BannerController@get_middle_carousel_list')->name("banner_get_middle_carousel_list");
        Route::post('banner/middle_carousel_add', 'BannerController@middle_carousel_add')->name("banner_middle_carousel_add");
        Route::post('banner/middle_carousel_update', 'BannerController@middle_carousel_update')->name("banner_middle_carousel_update");
        Route::post('banner/middle_carousel_del', 'BannerController@middle_carousel_del')->name("banner_middle_carousel_del");
        Route::post('banner/get_sales_list', 'BannerController@get_sales_list')->name("banner_get_sales_list");
        Route::post('banner/sales_add', 'BannerController@sales_add')->name("banner_sales_add");
        Route::post('banner/sales_update', 'BannerController@sales_update')->name("banner_sales_update");
        Route::post('banner/sales_del', 'BannerController@sales_del')->name("banner_sales_del");
        Route::post('banner/get_team_buy_list', 'BannerController@get_team_buy_list')->name("banner_get_team_buy_list");
        Route::post('banner/team_buy_add', 'BannerController@team_buy_add')->name("banner_team_buy_add");
        Route::post('banner/team_buy_update', 'BannerController@team_buy_update')->name("banner_team_buy_update");
        Route::post('banner/team_buy_del', 'BannerController@team_buy_del')->name("banner_team_buy_del");
        Route::post('banner/get_dividend_list', 'BannerController@get_dividend_list')->name("banner_get_dividend_list");
        Route::post('banner/dividend_add', 'BannerController@dividend_add')->name("banner_dividend_add");
        Route::post('banner/dividend_update', 'BannerController@dividend_update')->name("banner_dividend_update");
        Route::post('banner/dividend_del', 'BannerController@dividend_del')->name("banner_dividend_del");

        //搜尋管理
        Route::post('keyword/history_list', 'KeywordController@historyList')->name("keyword_history_list");
        Route::post('keyword/hint_list', 'KeywordController@hintList')->name("keyword_hint_list");
        Route::post('keyword/hint_add', 'KeywordController@hintAdd')->name("keyword_hint_add");
        Route::post('keyword/hint_update', 'KeywordController@hintUpdate')->name("keyword_hint_update");
        Route::post('keyword/hint_del', 'KeywordController@hintDel')->name("keyword_hint_del");
        Route::post('keyword/hot_update', 'KeywordController@hotUpdate')->name("keyword_hot_update");
        //網站設定管理
        Route::post('website/update', 'WebsiteController@update')->name("website_update");
       //物流
        Route::post('logistics/list', 'LogisticsController@list')->name("logistics_list");
        Route::post('logistics/update', 'LogisticsController@update')->name("logistics_update");
        //發票
        Route::post('invoice/list', 'InvoiceController@list')->name("invoice_list");
        Route::post('invoice/update', 'InvoiceController@update')->name("invoice_update");
        Route::post('invoice/del', 'InvoiceController@del')->name("invoice_del");
        //footer
        Route::post('menu_footer/list/{id?}', 'MenuFooterController@list')->name("menu_footer_list");
        Route::post('menu_footer/update', 'MenuFooterController@update')->name("menu_footer_update");
        //支付方式
        Route::post('pay_way/list', 'PayWayController@list')->name("pay_way_list");
        Route::post('pay_poundage/list/{id}', 'PayWayController@poundageList')->name("pay_poundage_list");
        Route::post('pay_poundage/update', 'PayWayController@poundageUpdate')->name("pay_poundage_update");
        Route::post('pay_poundage/del', 'PayWayController@poundageDel')->name("pay_poundage_del");
        Route::post('pay_way/status', 'PayWayController@status')->name("pay_way_status");
        //歡迎頁
        Route::post('welcome/get_app_list', 'WelcomePageController@getAppList')->name("welcome_get_app_list");
        Route::post('welcome/app_add', 'WelcomePageController@appAdd')->name("welcome_app_add");
        Route::post('welcome/app_update', 'WelcomePageController@appUpdate')->name("welcome_app_update");
        Route::post('welcome/app_del', 'WelcomePageController@appDel')->name("welcome_app_del");
        Route::post('welcome/get_ad_list', 'WelcomePageController@getAdList')->name("welcome_get_ad_list");
        Route::post('welcome/ad_add', 'WelcomePageController@adAdd')->name("welcome_ad_add");
        Route::post('welcome/ad_update', 'WelcomePageController@adUpdate')->name("welcome_ad_update");
        Route::post('welcome/ad_del', 'WelcomePageController@adDel')->name("welcome_ad_del");

        //導航欄
        Route::post('navi/list', 'NaviController@list')->name("navi_list");
        Route::post('navi/update', 'NaviController@update')->name("navi_update");
        Route::post('navi/del', 'NaviController@del')->name("navi_del");
        //品牌管理
        Route::post('brand/list', 'BrandController@list')->name("brand_list");
        Route::post('brand/update', 'BrandController@update')->name("brand_update");
        Route::post('brand/del', 'BrandController@del')->name("brand_del");
        Route::post('brand/search', 'BrandController@search')->name("brand_search");
        Route::post('brand/select', 'BrandController@select')->name("get_brand_select");
        Route::post('brand_recommend/list', 'BrandRecommendController@list')->name("brand_recommend_list");
        Route::post('brand_recommend/update', 'BrandRecommendController@update')->name("brand_recommend_update");
        Route::post('brand_recommend/del', 'BrandRecommendController@del')->name("brand_recommend_del");

        //廣告
        Route::post('advertisement/list', 'AdvertisementController@list')->name("advertisement_list");
        Route::post('advertisement/update', 'AdvertisementController@update')->name("advertisement_update");
        Route::post('advertisement/del', 'AdvertisementController@del')->name("advertisement_del");
        //卡友好康
        Route::post('banner/kayou_list', 'BannerController@kayouList')->name("banner_kayou_list");
        Route::post('banner/kayou_update', 'BannerController@kayouUpdate')->name("banner_kayou_update");
        Route::post('banner/kayou_del', 'BannerController@kayouDel')->name("banner_kayou_del");

        //中間活動
        Route::post('banner/middle_activity_list', 'BannerController@middle_activityList')->name("banner_middle_activity_list");
        Route::post('banner/middle_activity_update', 'BannerController@middle_activityUpdate')->name("banner_middle_activity_update");
        Route::post('banner/middle_activity_del', 'BannerController@middle_activityDel')->name("banner_middle_activity_del");

        //會員專區
        Route::post('banner/member_list', 'BannerController@memberList')->name("banner_member_list");
        Route::post('banner/member_add', 'BannerController@memberAdd')->name("banner_member_add");
        Route::post('banner/member_update', 'BannerController@memberUpdate')->name("banner_member_update");
        Route::post('banner/member_del', 'BannerController@memberDel')->name("banner_member_del");

        //熱門館別
        Route::post('annexe_hot/list', 'AnnexeHotController@list')->name("annexe_hot_list");
        Route::post('annexe_hot/add', 'AnnexeHotController@add')->name("annexe_hot_add");
        Route::post('annexe_hot/update', 'AnnexeHotController@update')->name("annexe_hot_update");
        Route::post('annexe_hot/del', 'AnnexeHotController@del')->name("annexe_hot_del");

        //強檔推薦
        Route::post('season_recommend/list', 'SeasonRecommendController@list')->name("season_recommend_list");
        Route::post('season_recommend/add', 'SeasonRecommendController@add')->name("season_recommend_add");
        Route::post('season_recommend/update', 'SeasonRecommendController@update')->name("season_recommend_update");
        Route::post('season_recommend/del', 'SeasonRecommendController@del')->name("season_recommend_del");

        //精選專區
        Route::post('choiceness/list', 'ChoicenessController@list')->name("choiceness_list");
        Route::post('choiceness/add', 'ChoicenessController@add')->name("choiceness_add");
        Route::post('choiceness/update', 'ChoicenessController@update')->name("choiceness_update");
        Route::post('choiceness/del', 'ChoicenessController@del')->name("choiceness_del");

        //會員模塊
        Route::post('user/list', 'UserController@list')->name("user_list");
        Route::post('user/update', 'UserController@update')->name("user_update");
        Route::post('user/create', 'UserController@create')->name("user_create");
        Route::post('user/update_phone', 'UserController@updatePhone')->name("user_update_phone");
        Route::post('user/update_email', 'UserController@updateEmail')->name("user_update_email");
        Route::post('user/update_password', 'UserController@updatePassword')->name("user_update_password");

        //等級設定
        Route::post('grade/list', 'GradeController@list')->name("grade_list");
        Route::post('grade/update', 'GradeController@update')->name("grade_update");

        //银行红利專區
        Route::post('bank/dividend/list', 'BankDividendController@list')->name("bank_dividend_list");
        Route::post('bank/dividend/update', 'BankDividendController@update')->name("bank_dividend_update");

        //分類管理
        Route::post('classify/list', 'ClassifyController@list')->name("classify_list");
        Route::post('classify/update', 'ClassifyController@update')->name("classify_update");
        Route::post('classify/create', 'ClassifyController@create')->name("classify_create");

        //店家
        Route::post('store/status', 'StoreController@status')->name("store_status");
        Route::post('store/list', 'StoreController@list')->name("store_list");
        Route::post('store/update', 'StoreController@update')->name("store_update");

        //分店
        Route::post('store/branch_list', 'StoreController@branch_list')->name("branch_list");
        Route::post('store/branch_update', 'StoreController@branch_update')->name("branch_update");

        //產業類別
        Route::post('store/industry_category_list', 'StoreController@industry_category_list')->name("industry_category_list");
        Route::post('store/industry_category_update', 'StoreController@industry_category_update')->name("industry_category_update");

        //商圈
        Route::post('shopping_street/status', 'ShoppingStreetController@status')->name("shopping_street_status");
        Route::post('shopping_street/list', 'ShoppingStreetController@list')->name("shopping_street_list");
        Route::post('shopping_street/update', 'ShoppingStreetController@update')->name("shopping_street_update");
        Route::post('shopping_street/branch_list', 'ShoppingStreetController@branch_list')->name("shopping_street_branch_list");

        //購買方案
        Route::post('purchase_scheme/status', 'PurchaseSchemeController@status')->name("purchase_scheme_status");
        Route::post('purchase_scheme/list', 'PurchaseSchemeController@list')->name("purchase_scheme_list");
        Route::post('purchase_scheme/update', 'PurchaseSchemeController@update')->name("purchase_scheme_update");

        //點數售出
        Route::post('points_sold/list', 'PointsSoldController@list')->name("points_sold_list");
        Route::post('points_sold/update', 'PointsSoldController@update')->name("points_sold_update");

        //退款記錄
        Route::post('refund/list', 'RefundController@list')->name("refund_list");
        Route::post('refund/update', 'RefundController@update')->name("refund_update");
        Route::post('refund/findlist', 'RefundController@findlist')->name("refund_find");

        //請款記錄
        Route::post('request_funds/list', 'RequestFundsController@list')->name("request_funds_list");
        Route::post('request_funds/update', 'RequestFundsController@update')->name("request_funds_update");

        //店家變更記錄
        Route::post('store_change/list', 'StoreChangeController@list')->name("store_change_list");
        Route::post('store_change/update', 'StoreChangeController@update')->name("store_change_update");

        //店家註冊記錄
        Route::post('store_register/list', 'StoreRegisterController@list')->name("store_register_list");
        Route::post('store_register/update', 'StoreRegisterController@update')->name("store_register_update");

        //店家與會員點數交易管理
        Route::post('users_points_deal/list', 'UsersPointsDealController@list')->name("users_points_deal_list");
        //商圈點數發放管理
        Route::post('points_grant/list', 'PointsGrantController@list')->name("points_grant_list");

        //店家廣告管理
        Route::post('store_advertising/list', 'StoreAdvertisingController@list')->name("store_advertising_list");
        Route::post('store_advertising/update', 'StoreAdvertisingController@update')->name("store_advertising_update");
        Route::post('store_advertising/status', 'StoreAdvertisingController@status')->name("store_advertising_status");
         Route::post('store_advertising/del', 'StoreAdvertisingController@del')->name("store_advertising_del");

         //電商廣告管理
        Route::post('ec_advertising/list', 'EcAdvertisingController@list')->name("ec_advertising_list");
        Route::post('ec_advertising/update', 'EcAdvertisingController@update')->name("ec_advertising_update");
        Route::post('ec_advertising/status', 'EcAdvertisingController@status')->name("ec_advertising_status");
         Route::post('ec_advertising/del', 'EcAdvertisingController@del')->name("ec_advertising_del");

         //推播管理
        Route::post('push_broadcast/list', 'PushBroadcastController@list')->name("push_broadcast_list");
        Route::post('push_broadcast/update', 'PushBroadcastController@update')->name("push_broadcast_update");

         //自動寄送模板管理
        Route::post('send_template/list', 'SendTemplateController@list')->name("send_template_list");
        Route::post('send_template/update', 'SendTemplateController@update')->name("send_template_update");

    });
});

