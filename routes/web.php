<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Route::group(['middleware'=>['auth.shopify']], function () {

    Route::get('/', [App\Http\Controllers\OrderController::class, 'Dashboard'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\OrderController::class, 'Dashboard'])->name('dashboard');
    Route::get('/settings',  [App\Http\Controllers\OrderController::class, 'Settings'])->name('settings.home');

    Route::get('/settings/logo', [App\Http\Controllers\OrderController::class, 'settings_logo'])->name('settings.logo');
    Route::post('/settings/logo', [App\Http\Controllers\OrderController::class, 'settings_logo_post'])->name('settings.logo.post');

    Route::get('/request/settings',  [App\Http\Controllers\RequestController::class, 'DeclineRequestDeletion'])->name('request.decline.setting');
    Route::post('/request/settings', [App\Http\Controllers\RequestController::class, 'DeclineRequestDeletionSave'])->name('request.decline.setting.save');

    Route::get('/product/exclusions',  [App\Http\Controllers\OrderController::class, 'ProductExclusion'])->name('block.tags');
    Route::post('/product/exclusions', [App\Http\Controllers\OrderController::class, 'ProductExclusionSave'])->name('block.tags.save');


    Route::get('/product/return',  [App\Http\Controllers\OrderController::class, 'ProductReturn'])->name('product.return');
    Route::post('/product/return', [App\Http\Controllers\OrderController::class, 'ProductReturnSave'])->name('product.return.save');


    Route::get('/request/policy', [App\Http\Controllers\RequestController::class, 'RequestPolicy'])->name('request.policy');
    Route::post('/request/policy', [App\Http\Controllers\RequestController::class, 'RequestPolicyUpdate'])->name('request.policy.update');


    Route::get('/requests/import',[App\Http\Controllers\OrderController::class, 'loadPrevious'])->name('request.import');
    Route::post('/requests/import/save',[App\Http\Controllers\OrderController::class, 'savePrevious'])->name('request.import.save');


    Route::get('/settings/reasons', [App\Http\Controllers\ReasonsController::class, 'settings_reasons'])->name('settings.reasons');
    Route::post('/reasons/new', [App\Http\Controllers\ReasonsController::class, 'addCustomReason'])->name('settings.reasons.new');

    Route::get('/setting/{id}/reasons/edit', [App\Http\Controllers\ReasonsController::class, 'settings_reasons_edit'])->name('settings.reasons.edit');
    Route::get('/setting/{id}/reasons/delete', [App\Http\Controllers\ReasonsController::class, 'settings_reasons_delete'])->name('settings.reasons.delete');


    Route::get('/order/return/type', [App\Http\Controllers\OrderController::class, 'OrderRefundType'])->name('orders.return.type');
    Route::post('/order/return/type', [App\Http\Controllers\OrderController::class, 'BuiltRefundTypeSave'])->name('built.return.type.save');
    Route::post('/order/return/type/save',  [App\Http\Controllers\OrderController::class, 'OrderRefundTypesave'])->name('orders.return.type.save');

    Route::get('/order/{id}/type/edit',[App\Http\Controllers\OrderController::class, 'OrderReturnTypeEdit'])->name('orders.return.type.edit');
    Route::post('/order/type/edit', [App\Http\Controllers\OrderController::class, 'OrderReturnTypeEdited'])->name('return.type.edited');

    Route::get('/order/{id}/type/delete', [App\Http\Controllers\OrderController::class, 'OrderReturnTypeDelete'])->name('orders.return.type.delete');


    //    Orders customization settings
    Route::get('/orders/custom/text', [App\Http\Controllers\OrderController::class, 'AddCustomationText'])->name('order.custom.text');

    Route::Post('/orders/custom/text/save', [App\Http\Controllers\OrderController::class, 'AddCustomationTextSave'])->name('custom.text.save');

    // Order retrun Method
    Route::get('/order/confirmation/settings', [App\Http\Controllers\RefundMethodController::class, 'ReturnDetails'])->name('return.confirmation');
    Route::post('/order/confirmation/save', [App\Http\Controllers\RefundMethodController::class, 'ReturnDetailsSave'])->name('confirmation.save');
    Route::get('label/test/{type}/send',[App\Http\Controllers\OrderController::class, 'sendTestLabel'])->name('send.test.label');



    Route::get('/email/reminder', [App\Http\Controllers\OrderController::class, 'EmailReminder'])->name('email.reminder');
    Route::post('/email/reminder', [App\Http\Controllers\OrderController::class, 'EmailReminderSave'])->name('email.reminder.save');


    Route::get('/email/expired', [App\Http\Controllers\OrderController::class, 'EmailExpired'])->name('email.expired');
    Route::post('/email/expired', [App\Http\Controllers\OrderController::class, 'EmailExpiredSave'])->name('email.expired.save');


    Route::get('/email/general', [App\Http\Controllers\OrderController::class, 'EmailGeneral'])->name('email.general');
    Route::post('/email/general', [App\Http\Controllers\OrderController::class, 'EmailGeneralSave'])->name('email.general.save');


    Route::get('/email/workflow', [App\Http\Controllers\OrderController::class, 'EmailWorkFlow'])->name('email.workflow');
    Route::post('/email/workflow', [App\Http\Controllers\OrderController::class, 'EmailWorkFlowSave'])->name('email.workflow.save');

    Route::get('/editor', [App\Http\Controllers\OrderController::class, 'Editor'])->name('editor');
    Route::post('/editor', [App\Http\Controllers\OrderController::class, 'EditorSave'])->name('editor.save');

    Route::get('test-email/{id}/send',[App\Http\Controllers\OrderController::class, 'sendTestEmail'])->name('send.test.email');

    Route::post('email/flow/update',[App\Http\Controllers\OrderController::class, 'emailflowupdate'])->name('email.flow.update');


    Route::get('/email/export', [App\Http\Controllers\OrderController::class, 'EmailExport'])->name('email.export');
    Route::post('/email/export', [App\Http\Controllers\OrderController::class, 'EmailExportSave'])->name('email.export.save');



    //Customer Block
    Route::get('/settings/customer/block', [App\Http\Controllers\CustomerController::class, 'create_block'])->name('customer.block.create');
    Route::post('/settings/customer/block/update', [App\Http\Controllers\CustomerController::class, 'update_block'])->name('customer.block.update');


    //Easy Post
    Route::get('/settings/easypost/integration', [App\Http\Controllers\EasyPostController::class, 'index'])->name('easypost.index');
    Route::post('/settings/easypost/integration',  [App\Http\Controllers\EasyPostController::class, 'update'])->name('easypost.update');



    //synchronize orders
    Route::get('/synchronize/orders', [App\Http\Controllers\OrderController::class, 'synchronization']);


    Route::get('/declined/request', [App\Http\Controllers\RequestController::class, 'DeclineRequests'])->name('decline.request');

    Route::get('/search/request', [App\Http\Controllers\RequestController::class, 'SearchRequest'])->name("search.request");


    Route::get('/requests/{id}', [App\Http\Controllers\OrderController::class, 'singleRequest'])->name('single.request');
    Route::get('/requests/{id}/status', [App\Http\Controllers\OrderController::class, 'RequestStatus'])->name('request.status');


    Route::get('/request/{id}/delete', [App\Http\Controllers\RequestController::class, 'DeclineRequestDelete'])->name('request.delete');

    Route::get('/delete/{id}/comment', [App\Http\Controllers\OrderController::class, 'DeleteComment'])->name('delete.comment');

    Route::post('/timeline', [App\Http\Controllers\OrderController::class, 'timeline_submit'])->name('timeline.submit');


    Route::get('/request/label/{id}/resend',[App\Http\Controllers\EasyPostController::class, 'resendLabel'])->name('resend.label');

    Route::get('/request/{id}/manualexchange',[App\Http\Controllers\EasyPostController::class, 'manualExchange'])->name('request.manualExchange');


    Route::get('/request/{id}/items/{item_id}/change', [App\Http\Controllers\RequestController::class, 'changeRequestItem'])->name('change.request_item.type');


    //Analytics
    Route::get('/analytics', [App\Http\Controllers\OrderController::class, 'Analytics'])->name('analytics');
    Route::get('/analytics/filter',  [App\Http\Controllers\OrderController::class, 'FilterAnalytics'])->name('filter.analytics');
    Route::post('/exports/create',[App\Http\Controllers\OrderController::class, 'createCSV'])->name('create.export');


});


Route::middleware(['customer'])->group(function (){


//    Route::get('/',  [App\Http\Controllers\CustomerController::class, 'loginshow'])->name('home');

    Route::get('/customer/login',  [App\Http\Controllers\CustomerController::class, 'login'])->name('customer.login.post');



});


