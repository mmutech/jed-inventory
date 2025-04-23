<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Livewire\DashboardComponent;

// Others
use App\Livewire\Other\LocationManagement;
use App\Livewire\Other\StoreManagement;
use App\Livewire\Other\UnitManagement;

//Purchase Order Number
use App\Livewire\PurchaseOrder\Create;
use App\Livewire\PurchaseOrder\Edit;
use App\Livewire\PurchaseOrder\EditItem;
use App\Livewire\PurchaseOrder\Index;
use App\Livewire\PurchaseOrder\POBalance;
use App\Livewire\PurchaseOrder\PORecommendation;
use App\Livewire\PurchaseOrder\QualityCheck;
use App\Livewire\PurchaseOrder\Show;
use App\Livewire\QualityCheck\QualityCheckIndex;
use App\Livewire\QualityCheck\QualityCheckSingle;
// Reports
use App\Livewire\Reports\BinCard;
use App\Livewire\Reports\GeneralReport;
use App\Livewire\Reports\Journal;
use App\Livewire\Reports\SingleBinCard;

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

//Stock
use App\Livewire\Stock\GeneralLedgerManagement;
use App\Livewire\Stock\StockCategoryManagement;
use App\Livewire\Stock\StockClassManagement;
use App\Livewire\Stock\StockCodeManagement;

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
    Route::get('/po-recommend/{poID}', PORecommendation::class);
    Route::get('/po-balance/{poID}', POBalance::class);

    // Quality Check
    Route::get('/quality-check', QualityCheckIndex::class);
    Route::get('/quality-check-single/{poID}', QualityCheckSingle::class);

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

    // Report
    Route::get('/general-report', GeneralReport::class);
    Route::get('/journal-report', Journal::class);
    Route::get('/bin-card', BinCard::class);
    Route::get('/single-bin-card/{binCardID}', SingleBinCard::class);

    //Stock Management
    Route::get('/stock-categories', StockCategoryManagement::class);
    Route::get('/stock-classes', StockClassManagement::class);
    Route::get('/stock-codes', StockCodeManagement::class);
    Route::get('/general-ledger', GeneralLedgerManagement::class);

    // Other Management
    Route::get('/stores', StoreManagement::class);
    Route::get('/units', UnitManagement::class);
    Route::get('/locations', LocationManagement::class);
});

