<?php

Route::group([
    'as' => 'voyager.enquiries.',
    'prefix' => 'admin/enquiries/',
    'middleware' => ['web', 'admin.user'],
    'namespace' => '\AnywhereMedia\PageEditor\Http\Controllers'
], function () {
    Route::get('{id}/file/{fileKey}', ['uses' => "EnquiryController@getFile", 'as' => 'file']);
});


Route::group([
    'as' => 'voyager.enquiries.',
    'middleware' => ['web'],
    'namespace' => '\AnywhereMedia\PageEditor\Http\Controllers'
], function () {
    Route::post('voyager-forms-submit-enquiry/{id}', ['uses' => "EnquiryController@submit", 'as' => 'submit']);
});


Route::group(['middleware' => ['web']], function () {

    //Route::any('/admin/pages/{id}/build', 'PageBuilderController@build')->name('pagebuilder.build');
    Route::any('/admin/page-editor/build', '\AnywhereMedia\PageEditor\Http\Controllers\PageBuilderController@build');

});

\AnywhereMedia\PageEditor\Helpers\Routes::registerPageRoutes();