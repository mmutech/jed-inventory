<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SRAController;
use App\Http\Controllers\UserController;
use App\Livewire\DashboardComponent;
use App\Livewire\PurchaseOrder\Create;
use App\Livewire\PurchaseOrder\Edit;
use App\Livewire\PurchaseOrder\EditItem;
use App\Livewire\PurchaseOrder\Index;
use App\Livewire\PurchaseOrder\Show;
use App\Livewire\SRA\ConfirmItem;
use App\Livewire\SRA\CreateSra;
use App\Livewire\SRA\EditSra;
//SRA
use App\Livewire\SRA\IndexSra;
use App\Livewire\SRA\QualityCheck;
use App\Livewire\SRA\ShowSra;
//Stock Category
use App\Livewire\Stock\Category\StockCategoryCreate;
use App\Livewire\Stock\Category\StockCategoryEdit;
use App\Livewire\Stock\Category\StockCategoryIndex;
//Stock Class
use App\Livewire\Stock\Class\StockClassCreate;
use App\Livewire\Stock\Class\StockClassEdit;
use App\Livewire\Stock\Class\StockClassIndex;
use App\Livewire\Stock\Code\StockCodeCreate;
use App\Livewire\Stock\Code\StockCodeEdit;
use App\Livewire\Stock\Code\StockCodeIndex;
//Store
use App\Livewire\Store\BinCardIndex;
use App\Livewire\Store\BinCardShow;
use App\Livewire\Store\StoreCreate;
use App\Livewire\Store\StoreEdit;
use App\Livewire\Store\StoreIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', DashboardComponent::class);


Auth::routes();
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //Purchase order
    Route::get('/purchase-order', Index::class);
    Route::get('/purchase-order-create', Create::class);
    Route::get('/purchase-order-show/{poID}', Show::class)->name('purchase-order-show/{poID}');
    Route::get('/purchase-order-edit/{editPoID}', Edit::class);
    Route::get('/purchase-order-edit-item/{editItemID}', EditItem::class);

    //SRA
    Route::get('/sra', IndexSra::class);
    Route::get('/create-sra', CreateSra::class);
    Route::get('/confirm-item/{poID}', ConfirmItem::class);
    Route::get('/show-sra/{poID}', ShowSra::class);
    Route::get('/edit-sra/{sraID}', EditSra::class);
    Route::get('/quality-check/{poID}', QualityCheck::class);

    //Store
    Route::get('/store-index', StoreIndex::class);
    Route::get('/store-create', StoreCreate::class);
    Route::get('/store-edit/{stID}', StoreEdit::class);

    //Stores Bin Card
    Route::get('/bin-card-index', BinCardIndex::class);
    Route::get('/bin-card-show/{binID}', BinCardShow::class);

    //Stock Category
    Route::get('/stock-category-index', StockCategoryIndex::class);
    Route::get('/stock-category-create', StockCategoryCreate::class);
    Route::get('/stock-category-edit/{stCategoryID}', StockCategoryEdit::class);

    //Stock Class
    Route::get('/stock-class-index', StockClassIndex::class);
    Route::get('/stock-class-create', StockClassCreate::class);
    Route::get('/stock-class-edit/{stClassID}', StockClassEdit::class);

    //Stock Codes
    Route::get('/stock-code-index', StockCodeIndex::class);
    Route::get('/stock-code-create', StockCodeCreate::class);
    Route::get('/stock-code-edit/{stCodeID}', StockCodeEdit::class);
});

