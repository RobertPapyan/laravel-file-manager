<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Controllers\FileManagerController;
use Alexusmai\LaravelFileManager\Services\ConfigService\ConfigRepository;


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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


$config = resolve(ConfigRepository::class);

// App middleware list
$middleware = $config->getMiddleware();

/**
 * If ACL ON add "fm-acl" middleware to array
 */
if ($config->getAcl()) {
    $middleware[] = 'fm-acl';
}

Route::group([
    'middleware' => $middleware,
    'prefix'     => $config->getRoutePrefix(),
    'namespace'  => 'Alexusmai\LaravelFileManager\Controllers',
], function () {

    Route::get('initialize', [FileManagerController::class, 'initialize'])
        ->name('fm.initialize');

    Route::get('content', [FileManagerController::class, 'content'])
        ->name('fm.content');

    Route::get('search',[FileManagerController::class,'search'])
        ->name('fm.search');

    Route::get('tree', [FileManagerController::class, 'tree'])
        ->name('fm.tree');

    Route::get('select-disk', [FileManagerController::class, 'selectDisk'])
        ->name('fm.select-disk');

    Route::post('upload', [FileManagerController::class, 'upload'])
        ->name('fm.upload');

    Route::post('delete', [FileManagerController::class, 'delete'])
        ->name('fm.delete');

    Route::post('paste', [FileManagerController::class, 'paste'])
        ->name('fm.paste');

    Route::post('rename', [FileManagerController::class, 'rename'])
        ->name('fm.rename');

    Route::get('download', [FileManagerController::class, 'download'])
        ->name('fm.download');

    Route::get('thumbnails', [FileManagerController::class, 'thumbnails'])
        ->name('fm.thumbnails');

    Route::get('preview', [FileManagerController::class, 'preview'])
        ->name('fm.preview');

    Route::get('url', [FileManagerController::class, 'url'])
        ->name('fm.url');

    Route::post('create-directory', [FileManagerController::class, 'createDirectory'])
        ->name('fm.create-directory');

    Route::post('create-file', [FileManagerController::class, 'createFile'])
        ->name('fm.create-file');

    Route::post('update-file', [FileManagerController::class, 'updateFile'])
        ->name('fm.update-file');

    Route::get('stream-file', [FileManagerController::class, 'streamFile'])
        ->name('fm.stream-file');

    Route::post('zip', [FileManagerController::class, 'zip'])
        ->name('fm.zip');

    Route::post('unzip', [FileManagerController::class, 'unzip'])
        ->name('fm.unzip');

    // Route::get('properties', 'FileManagerController@properties');

    // Integration with editors
    Route::get('ckeditor', [FileManagerController::class, 'ckeditor'])
        ->name('fm.ckeditor');

    Route::get('tinymce', [FileManagerController::class, 'tinymce'])
        ->name('fm.tinymce');

    Route::get('tinymce5', [FileManagerController::class, 'tinymce5'])
        ->name('fm.tinymce5');

    Route::get('summernote', [FileManagerController::class, 'summernote'])
        ->name('fm.summernote');

    Route::get('fm-button', [FileManagerController::class, 'fmButton'])
        ->name('fm.fm-button');

});
    Route::get('testroute',[FileManagerController::class , 'fmButton']);

    Route::get('/file-manager',[FileManagerController::class, 'index']);
