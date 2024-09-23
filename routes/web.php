<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Livewire\DashboardComponent;

//Purchase Order Number
use App\Livewire\PurchaseOrder\Create;
use App\Livewire\PurchaseOrder\Edit;
use App\Livewire\PurchaseOrder\EditItem;
use App\Livewire\PurchaseOrder\Index;
use App\Livewire\PurchaseOrder\PORecommendation;
use App\Livewire\PurchaseOrder\QualityCheck;
use App\Livewire\PurchaseOrder\Show;

// Request
use App\Livewire\Request\Allocation as RequestAllocation;
use App\Livewire\Request\CheckIn;
use App\Livewire\Request\CheckOut;
use App\Livewire\Request\Recommendation;
use App\Livewire\Request\RequestIndex;
use App\Livewire\Request\RequestView;
use App\Livewire\Request\SCNRequest;
use App\Livewire\Request\SRCNAllocation;
use App\Livewire\Request\SRCNRequest;
use App\Livewire\Request\SRINAllocation;
use App\Livewire\Request\SRINRequest;

//SRA
use App\Livewire\SRA\ConfirmItem;
use App\Livewire\SRA\CreateSra;
use App\Livewire\SRA\EditSra;
use App\Livewire\SRA\IndexSra;
use App\Livewire\SRA\ShowSra;

//Stock Category
use App\Livewire\Stock\Category\StockCategoryCreate;
use App\Livewire\Stock\Category\StockCategoryEdit;
use App\Livewire\Stock\Category\StockCategoryIndex;

//Stock Class
use App\Livewire\Stock\Class\StockClassCreate;
use App\Livewire\Stock\Class\StockClassEdit;
use App\Livewire\Stock\Class\StockClassIndex;
use App\Livewire\Stock\Code\Barcode;
use App\Livewire\Stock\Code\StockCodeCreate;
use App\Livewire\Stock\Code\StockCodeEdit;
use App\Livewire\Stock\Code\StockCodeIndex;

//Store
use App\Livewire\Store\BinCardIndex;
use App\Livewire\Store\BinCardShow;
use App\Livewire\Store\GeneralReport;
use App\Livewire\Store\StoreCreate;
use App\Livewire\Store\StoreEdit;
use App\Livewire\Store\StoreIndex;
use App\Livewire\Store\StoreLedgerIndex;
use App\Livewire\Store\StoreLedgerShow;

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
    // User Management
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //Purchase order
    Route::get('/purchase-order', Index::class);
    Route::get('/purchase-order-create', Create::class);
    Route::get('/purchase-order-show/{poID}', Show::class)->name('purchase-order-show/{poID}');
    Route::get('/purchase-order-edit/{editPoID}', Edit::class);
    Route::get('/purchase-order-edit-item/{editItemID}', EditItem::class);
    Route::get('/quality-check/{poID}', QualityCheck::class);
    Route::get('/po-recommend/{poID}', PORecommendation::class);

    //SRA
    Route::get('/sra', IndexSra::class);
    Route::get('/create-sra', CreateSra::class);
    Route::get('/confirm-item/{poID}', ConfirmItem::class);
    Route::get('/show-sra/{poID}', ShowSra::class);
    Route::get('/edit-sra/{sraID}', EditSra::class);

    // Request
    Route::get('/request-index', RequestIndex::class);
    Route::get('/srcn-request', SRCNRequest::class);
    Route::get('/srin-request', SRINRequest::class);
    Route::get('/request-scn/{srinId}', SCNRequest::class);
    Route::get('/request-view/{referenceId}', RequestView::class);
    Route::get('/qty-recommend/{referenceId}', Recommendation::class);
    Route::get('/allocation/{referenceId}', RequestAllocation::class);
    Route::get('/srcn-allocation/{referenceId}', SRCNAllocation::class);
    Route::get('/srin-allocation/{referenceId}', SRINAllocation::class);
    Route::get('/check-in/{referenceId}', CheckIn::class);
    Route::get('/check-out/{referenceId}', CheckOut::class);

    //Store
    Route::get('/store-index', StoreIndex::class);
    Route::get('/store-create', StoreCreate::class);
    Route::get('/store-edit/{stID}', StoreEdit::class);

    // Report
    Route::get('/general-report', GeneralReport::class);

    //Stores Bin Card
    Route::get('/bin-card-index', BinCardIndex::class);
    Route::get('/bin-card-show/{stockCodeID}', BinCardShow::class);

    //Stores Ledger
    Route::get('/store-ledger-index', StoreLedgerIndex::class);
    Route::get('/store-ledger-show/{stockCodeID}', StoreLedgerShow::class);

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
    Route::get('/barcode', Barcode::class);
});

