<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', 'Auth\LoginController@loginf')->name('loginf');


Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/pdf/{id}', 'HomeController@pdf')->name('pdf');

Route::get('/search/ajax/{id}', 'HomeController@SearchAjax')->name('admin.masterAccSearchAjax');

Auth::routes();

// Testing URL
Route::get('/compare', 'HomeController@compare');
Route::get('/newReport', 'HomeController@newReport')->name('newReport');
Route::get('/tax', 'HomeController@tax');
Route::get('/sale-transection/sep', 'HomeController@tax_september');
Route::get('/sale-transection/oct', 'HomeController@tax_oct');
Route::get('/sale-transection/nov', 'HomeController@tax_nov');
Route::get("purchase-transection", "HomeController@purchase_export");

Route::get('/new-stock', 'HomeController@new_stock');

Route::get('/repair-data-invoice-item-stock-sale-from-fifo', 'HomeController@repairinvitmstocksalefromfifo')->name('repairinvitmstocksalefromfifo');
Route::get('/invoicecheck', 'HomeController@invoice');
Route::get('/invoice-itemscheck/{invoice}', 'HomeController@invoiceItem')->name('invoiceItem');
Route::get('/invoice-deletecheck/{invoice}', 'HomeController@invoiceDelete')->name('invoiceDelete');
//Mominul vai
Route::get('fifo-update', 'HomeController@fifo_update')->name('fifo-update');
Route::get('fifo-update-submit', 'HomeController@fifo_update_submit')->name('fifo-update-submit');
//End Testing URL

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/home', 'backend\ParentProfileController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
  Route::get('/dashboard', 'backend\DashboardController@index');
  Route::get('/form-layout', 'backend\DashboardController@form_layout');
  Route::get('/form-input', 'backend\DashboardController@form_input');
  Route::resource('role', 'backend\RoleController');
  Route::resource('settings','backend\SettingController');

  // Work by Tarek Start

    // Project Details Starts
    Route::get('/project-details', 'backend\ProjectController@projectDetails')->name('projectDetails');
    Route::post('/project-details/Post', 'backend\ProjectController@projectDetailsPost')->name('projectDetailsPost');
    Route::get('/project-details/edit/{proj}', 'backend\ProjectController@projectEdit')->name('projectEdit');
    Route::post('/project-details/Post/edit/{proj}', 'backend\ProjectController@projectDetailsUpdate')->name('projectDetailsUpdate');
    Route::get('/project-details/delete/{proj}', 'backend\ProjectController@projectDelete')->name('projectDelete');
    Route::get('/project-details/form', 'backend\ProjectController@projectForm')->name('projectForm');
    
    // Project Details Ends

    // Bank Details Starts
    Route::get('/bank-details', 'backend\BankController@bankDetails')->name('bankDetails');
    Route::post('/bank-details/Post', 'backend\BankController@bankDetailsPost')->name('bankDetailsPost');
    Route::get('/bank-details/edit/{bank}', 'backend\BankController@bankEdit')->name('bankEdit');
    Route::post('/bank-details/Post/edit/{bank}', 'backend\BankController@bankDetailsUpdate')->name('bankDetailsUpdate');
    Route::get('/bank-details/delete/{bank}', 'backend\BankController@bankDelete')->name('bankDelete');
    Route::get('/bank-details/form/', 'backend\BankController@bankForm')->name('bankForm');
    // Bank Details Ends

    // Master Accounts Details Starts
    Route::get('/master-accounts-details', 'backend\MasterAccountController@masteAccDetails')->name('masteAccDetails');
    Route::post('/master-details/Post', 'backend\MasterAccountController@MasterDetailsPost')->name('masterDetailsPost');
    Route::get('/master-details/edit/{masterAcc}', 'backend\MasterAccountController@masterEdit')->name('masterEdit');
    Route::post('/master-details/Post/edit/{masterAcc}', 'backend\MasterAccountController@masterDetailsUpdate')->name('masterDetailsUpdate');
    Route::get('/master-details/delete/{masterAcc}', 'backend\MasterAccountController@masterDelete')->name('masterDelete');
    Route::get('/master-details/type', 'backend\MasterAccountController@mstAccType')->name('mstAccType');
    Route::post('/master-details/masterCatPost', 'backend\MasterAccountController@masterCatPost')->name('masterCatPost');
    Route::post('/master-details/masterAccType', 'backend\MasterAccountController@masterAccType')->name('masterAccType');
    Route::post('/master-details/findMastedCode', 'backend\MasterAccountController@findMastedCode')->name('findMastedCode');
    // Master Accounts Details Ends


    // Account Head Details Starts
    Route::get('/accounts-head-details', 'backend\MasterAccountController@accHeadDetails')->name('accHeadDetails');
    Route::post('/project-details/Post/{masterAcc}', 'backend\MasterAccountController@accHeahDetailsPost')->name('accHeahDetailsPost');
    Route::get('/findMasterAcc/{masterAcc}', 'backend\MasterAccountController@findMasterAcc')->name('findMasterAcc');
    Route::get('/editAccHead/{item}', 'backend\MasterAccountController@editAccHead')->name('editAccHead');
    Route::post('/project-details/edit/post/{account_head}', 'backend\MasterAccountController@accHeahEditPost')->name('accHeahEditPost');
    Route::get('/acount-head/delete/{account_head}', 'backend\MasterAccountController@deleteAcHead')->name('deleteAcHead');
    // Account Head Details Ends

    // Cost center Details Starts
    Route::get('/cost-center-details', 'backend\CostCenterController@costCenterDetails')->name('costCenterDetails');
    Route::post('/costCenter/Post/', 'backend\CostCenterController@costCenterPost')->name('costCenterPost');
    Route::get('/cost-center/edit/{costCenter}', 'backend\CostCenterController@costCenEdit')->name('costCenEdit');
    Route::post('/cost-center/Post/edit/{costCenter}', 'backend\CostCenterController@costCentersUpdate')->name('costCentersUpdate');
    Route::get('/cost-center/delete/{costCenter}', 'backend\CostCenterController@costCenDelete')->name('costCenDelete');
    Route::get('/cost-center/form/', 'backend\CostCenterController@costCenterForm')->name('costCenterForm');
    // Cost center Details Ends

    // Profit Ccenter center Details Starts
    Route::get('/profit-details', 'backend\ProfitCenterController@ProfitCenterDetails')->name('profitCenterDetails');
    Route::post('/profit-center/Post/', 'backend\ProfitCenterController@profitCenterPost')->name('profitCenterPost');
    Route::get('/profit-center/edit/{profitCenter}', 'backend\ProfitCenterController@profitCenEdit')->name('profitCenEdit');
    Route::post('/profit-center/Post/edit/{profitCenter}', 'backend\ProfitCenterController@profitCentersUpdate')->name('profitCentersUpdate');
    Route::get('/profit-center/delete/{profitCenter}', 'backend\ProfitCenterController@profitCenDelete')->name('profitCenDelete');
    Route::get('/profit-center/form', 'backend\ProfitCenterController@profitCenterForm')->name('profitCenterForm');
    // Profit Ccenter center Details Ends

    // Party Info Starts
    Route::get('/party-info', 'backend\PartyInfoController@partyInfoDetails')->name('partyInfoDetails');
    Route::post('/party-info/Post/', 'backend\PartyInfoController@partyInfoPost')->name('partyInfoPost');
    Route::get('/party-info/edit/{pInfo}', 'backend\PartyInfoController@partyInfoEdit')->name('partyInfoEdit');
    Route::post('/party-info/Post/edit/{profitCenter}', 'backend\PartyInfoController@partyInfoUpdate')->name('partyInfoUpdate');
    Route::get('/party-info/delete/{pinfo}', 'backend\PartyInfoController@partyInfoDelete')->name('partyInfoDelete');
    Route::get('/party-info/form/', 'backend\PartyInfoController@partyInfoForm')->name('partyInfoForm');
    Route::get('/party-info-view/{pInfo}', 'backend\PartyInfoController@partyView')->name('partyView');
    // Party Info Ends

    // Tax Invoice Issue
    Route::get('/tax-invoice-issue', 'backend\TaxInvoiceController@taxInvoIssue')->name('taxInvoIssue');
    Route::get('/tax-invoice-issue/post', 'backend\TaxInvoiceController@taxInvoIssuepost')->name('taxInvoIssuepost');
    Route::post('select/item/by/term/', 'backend\TaxInvoiceController@selectItemByTerm')->name('selectItemByTerm');
    Route::post('party/info/by/term/', 'backend\TaxInvoiceController@partyInfoInvoice')->name('partyInfoInvoice');
    Route::post('find/date/', 'backend\TaxInvoiceController@findDate')->name('findDate');
    Route::post('find/item/', 'backend\TaxInvoiceController@findItem')->name('findItem');
    Route::post('find/item/edit', 'backend\TaxInvoiceController@findItemEdit')->name('findItemEdit');
    Route::get('temp/invoice/', 'backend\TaxInvoiceController@tempInvoice')->name('tempInvoice');
    Route::get('temp/invoice/edit', 'backend\TaxInvoiceController@tempInvoiceedit')->name('tempInvoiceedit');
    Route::post('preview/invoice/', 'backend\TaxInvoiceController@previewSaveInvoice')->name('previewSaveInvoice');
    Route::get('preview/invoice/view/{invoice}/{amountFrom}/{amountTo}', 'backend\TaxInvoiceController@invoicePreview')->name('invoicePreview');
    Route::get('preview/invoice/view/{invoice}/update', 'backend\TaxInvoiceController@updatePreviewInv')->name('updatePreviewInv');
    Route::post('final/invoice/', 'backend\TaxInvoiceController@finalSaveInvoice')->name('finalSaveInvoice');
    Route::get('invoicess/', 'backend\TaxInvoiceController@invoicess')->name('invoicess');
    Route::get('invoicePrint/{invoice}', 'backend\TaxInvoiceController@invoicePrint')->name('invoicePrint');
    Route::get('itemDelete/{item}', 'backend\TaxInvoiceController@itemDelete')->name('itemDelete');
    Route::get('refresh_invoice/', 'backend\TaxInvoiceController@refresh_invoice')->name('refresh_invoice');
    Route::get('tax-invoice-view/{invoice}', 'backend\TaxInvoiceController@invoiceView')->name('invoiceView');
    Route::get('tax-invoice-view/sale/{invoice}', 'backend\TaxInvoiceController@saleinvoiceView')->name('saleinvoiceView');
    Route::get('tax-invoice-view/2/{invoice}', 'backend\TaxInvoiceController@invoiceView2')->name('invoiceView2');
    Route::get('tax-invoice-edit/{invoice}', 'backend\TaxInvoiceController@invoiceEdit')->name('invoiceEdit');
    Route::post('tax-invoice-update/{invoice}', 'backend\TaxInvoiceController@finalSaveInvoiceUpdate')->name('finalSaveInvoiceUpdate');
    Route::post('find/item/id', 'backend\TaxInvoiceController@findItemId')->name('findItemId');
    Route::post('find/item/id/edit', 'backend\TaxInvoiceController@findItemIdedit')->name('findItemIdedit');
    Route::get('tax-invoice-list', 'backend\TaxInvoiceController@taxInvoiceList')->name('taxInvoiceList');
    Route::get('tax-invoice-search', 'backend\TaxInvoiceController@searchInvoice')->name('searchInvoice');
    Route::get('tax-invoice-search/sale', 'backend\TaxInvoiceController@searchSaleInvoice')->name('searchSaleInvoice');
    Route::post('amountto', 'backend\TaxInvoiceController@amountto')->name('amountto');
    Route::post('fifo/id', 'backend\TaxInvoiceController@quantityFifo')->name('quantityFifo');
    Route::post('fifo/id/edit', 'backend\TaxInvoiceController@quantityFifoedit')->name('quantityFifoedit');
        Route::get('tarek', 'backend\TaxInvoiceController@tarek')->name('tarek');
Route::get('tarek-invo-update/{invoice}', 'backend\TaxInvoiceController@tarekInvUpdate')->name('tarekInvUpdate');
    Route::get('updateStock/{item}', 'backend\TaxInvoiceController@updateStock')->name('updateStock');
    Route::post('find/item/color', 'backend\TaxInvoiceController@findItemColor')->name('load_item.fetch');
    // End Tax Invoice Issue

    //Stock Position
    Route::get('/stock-position-details', 'backend\StockPositionController@stockPosition')->name('stockPosition');
    Route::get('/stock-position/search-month', 'backend\StockPositionController@searchStockPosition')->name('searchStockPosition');
    Route::get('/stock-position/search-date', 'backend\StockPositionController@searchStockPositionDate')->name('searchStockPositionDate');
    Route::get('/stock-position/search-range', 'backend\StockPositionController@searchStockPositionRange')->name('searchStockPositionRange');
    Route::get('/stock-position/with-purchase', 'backend\StockPositionController@stockReportWithP')->name('stockReportWithP');
    Route::get('/stock-position/search-date/with-purchase', 'backend\StockPositionController@searchStockPositionDateP')->name('searchStockPositionDateP');
    Route::get('/stock-position/search-range/with-purchase', 'backend\StockPositionController@searchStockPositionRangeP')->name('searchStockPositionRangeP');
    Route::get('/stock-position/print', 'backend\StockPositionController@printStockPosition')->name('printStockPosition');
    Route::get('/stock-position/print/date/{date}', 'backend\StockPositionController@printStockPositionDate')->name('printStockPositionDate');
    Route::get('/stock-position/print/range/{from}/{to}', 'backend\StockPositionController@printStockPositionRange')->name('printStockPositionRange');
    Route::get('/stock-position/purchase/print', 'backend\StockPositionController@printStockPositionP')->name('printStockPositionP');
    Route::get('/stock-position/purchase/print/date/{date}', 'backend\StockPositionController@printStockPositionDateP')->name('printStockPositionDateP');
    Route::get('/stock-position/purchase/print/range/{from}/{to}', 'backend\StockPositionController@printStockPositionRangeP')->name('printStockPositionRangeP');
    Route::get('/stock-position-report', 'backend\StockPositionController@stockPosition2')->name('stockPosition2');
      Route::get('/stock-position-report/print', 'backend\StockPositionController@printStockPosition2')->name('printStockPosition2');
    Route::get('/stock-position-report/date/{date}/print', 'backend\StockPositionController@printStockPosition2Date')->name('printStockPosition2Date');
    Route::get('/stock-position-report/range/{from}/{to}/print', 'backend\StockPositionController@printStockPosition2Range')->name('printStockPosition2Range');
    Route::get('/available-stock', 'backend\StockPositionController@available_stock')->name('available-stock');

    //End Stock Position

    //Journal Entry
    Route::get('/journal-entry', 'backend\JournalEntryController@journalEntry')->name('journalEntry');
    Route::post('find-project', 'backend\JournalEntryController@findProject')->name('findProject');
    Route::post('find-cost-center', 'backend\JournalEntryController@findCostCenter')->name('findCostCenter');
    Route::post('find-cost-center/id', 'backend\JournalEntryController@findCostCenterId')->name('findCostCenterId');
    Route::post('party/info/by/term2/', 'backend\JournalEntryController@partyInfoInvoice2')->name('partyInfoInvoice2');
        Route::post('party/info/by/term3/', 'backend\JournalEntryController@partyInfoInvoice3')->name('partyInfoInvoice3');

    Route::post('find-account-head', 'backend\JournalEntryController@findAccHead')->name('findAccHead');
    Route::post('find-account-head/id', 'backend\JournalEntryController@findAccHeadId')->name('findAccHeadId');
    Route::post('find-tax_rate', 'backend\JournalEntryController@findTaxRate')->name('findTaxRate');
    Route::post('find-findamount', 'backend\JournalEntryController@findamount')->name('findamount');
    Route::post('journal-entry/post', 'backend\JournalEntryController@journalEntryPost')->name('journalEntryPost');
    Route::get('journal-entry/edit/{journal}', 'backend\JournalEntryController@journalEdit')->name('journalEdit');
    Route::post('journal-entry/edit-post/{journal}', 'backend\JournalEntryController@journalEntryEditPost')->name('journalEntryEditPost');
    Route::get('/journal/delete/{journal}', 'backend\JournalEntryController@journalDelete')->name('journalDelete');
    Route::get('/journal-authorize', 'backend\JournalEntryController@journalAuthorize')->name('journalAuthorize');
    Route::get('/journal-entry/view/{journal}', 'backend\JournalEntryController@journalView')->name('journalView');
    Route::get('/journal-authorize/{journal}', 'backend\JournalEntryController@journalMakeAuthorize')->name('journalMakeAuthorize');
    Route::post('journal/auth-decline/{journal}', 'backend\JournalEntryController@journaAuthDecline')->name('journaAuthDecline');
    Route::get('/journal-approve/{journal}', 'backend\JournalEntryController@journalMakeApprove')->name('journalMakeApprove');
    Route::post('journal/approve-decline/{journal}', 'backend\JournalEntryController@journaApproveDecline')->name('journaApproveDecline');
    Route::get('/journal-approval', 'backend\JournalEntryController@journalApproval')->name('journalApproval');
    //End Journal Entry


      // Sale order receive
      Route::get('/sale-order', 'backend\SaleOrderController@saleOrderReceive')->name('saleOrderReceive');
      Route::post('party/info/by/term/for-sale', 'backend\SaleOrderController@SalePartyInfo')->name('SalePartyInfo');
      Route::post('find/date/for-sale', 'backend\SaleOrderController@findDateSale')->name('findDateSale');
      Route::post('find/item/for-sale', 'backend\SaleOrderController@findItemSale')->name('findItemSale');
      Route::post('find/item/id/for-sale', 'backend\SaleOrderController@findItemIdSale')->name('findItemIdSale');
      Route::get('temp/sale-order/', 'backend\SaleOrderController@tempSaleOrder')->name('tempSaleOrder');
      Route::get('itemDelete/for-sale/{item}', 'backend\SaleOrderController@itemDeleteSale')->name('itemDeleteSale');
      Route::post('final/sale-order/', 'backend\SaleOrderController@finalSaveSaleOrder')->name('finalSaveSaleOrder');
      Route::get('sale-order-print/{invoice}', 'backend\SaleOrderController@saleOrderPrint')->name('saleOrderPrint');
      Route::get('refresh/sale-order', 'backend\SaleOrderController@refresh_sale_order')->name('refresh_sale_order');
      Route::get('sale-order/view/{sale}', 'backend\SaleOrderController@saleOrderView')->name('saleOrderView');
      Route::get('sale-order-edit/{invoice}', 'backend\SaleOrderController@saleOrderEdit')->name('saleOrderEdit');
      Route::post('sale_order-update/{invoice}', 'backend\SaleOrderController@finalSaveSaleUpdate')->name('finalSaveSaleUpdate');
      Route::get('search-sale-order', 'backend\SaleOrderController@searchSO')->name('searchSO');
      Route::post('/customer/Post/', 'backend\SaleOrderController@customerPost')->name('customerPost');
      // End sale order

      //Delivery Note
      Route::get('/delivery-note', 'backend\DeliveryNoteController@deliveryNote')->name('deliveryNote');
      Route::get('/sale-order-details/{sale}', 'backend\DeliveryNoteController@saleOrderDetails')->name('saleOrderDetails');
      Route::get('/delivery-note-view/{dNote}', 'backend\DeliveryNoteController@deliveryNoteView')->name('deliveryNoteView');

      Route::post('/assing-delivery-note/{sale}', 'backend\DeliveryNoteController@asignDeliveryNote')->name('asignDeliveryNote');
      Route::get('/delivery-note-update/{invoice}', 'backend\DeliveryNoteController@updateNote')->name('updateNote');
      Route::get('delivery-note-print/{invoice}', 'backend\DeliveryNoteController@deliveryNotePrint')->name('deliveryNotePrint');
      Route::post('/generate-delivery-note/{sale}', 'backend\DeliveryNoteController@generateDeliveryNote')->name('generateDeliveryNote');
      Route::get('delivery-note/search-sale-order', 'backend\DeliveryNoteController@searchSODNo')->name('searchSODNo');
      Route::get('delivery-note/find', 'backend\DeliveryNoteController@findDNo')->name('findDNo');
      Route::get('delivery-note/search-sale-order/month', 'backend\DeliveryNoteController@searchSODNoMonth')->name('searchSODNoMonth');
      Route::get('delivery-note/search-sale-order/date', 'backend\DeliveryNoteController@searchSODNoDate')->name('searchSODNoDate');
      Route::get('delivery-note/search-sale-order/date-range', 'backend\DeliveryNoteController@searchSODNoDateRange')->name('searchSODNoDateRange');
      Route::get('delivery-note-list/', 'backend\DeliveryNoteController@dnList')->name('dnList');
      Route::get('delivery-note-details/{dNote}', 'backend\DeliveryNoteController@deliveryNoteDetails')->name('deliveryNoteDetails');
      Route::get('delivery-note-find/month', 'backend\DeliveryNoteController@findDNoMonth')->name('findDNoMonth');
      Route::get('delivery-note/find/date', 'backend\DeliveryNoteController@findDNoDate')->name('findDNoDate');
      Route::get('delivery-note/find/date-range', 'backend\DeliveryNoteController@findDNoDateRange')->name('findDNoDateRange');
      Route::get('delivery-summary', 'backend\DeliveryNoteController@deliverySummery')->name('deliverySummery');
      Route::get('delivery-details/deliveryNotesummery/{dnote}', 'backend\DeliveryNoteController@deliveryNotesummery')->name('deliveryNotesummery');
      Route::get('delivery-note/search/summary', 'backend\DeliveryNoteController@searchDNo')->name('searchDNoS');
      Route::get('delivery-note-search/summary/month', 'backend\DeliveryNoteController@searchDNoMonth')->name('searchDNoMonthS');
      Route::get('delivery-note/search/summary/date', 'backend\DeliveryNoteController@searchDNoDate')->name('searchDNoDateS');
      Route::get('delivery-note/search/summary/date-range', 'backend\DeliveryNoteController@searchDNoDateRange')->name('searchDNoDateRangeS');
      //End delivery note

      //Sales Return
      Route::get('/sales-return', 'backend\SalesReturnController@salesReturn')->name('salesReturn');
      Route::post('find/delivery-note/for-return', 'backend\SalesReturnController@finddeliveryNote')->name('finddeliveryNote');
      Route::get('temp/sale-order-return/', 'backend\SalesReturnController@tempSaleOrderReturn')->name('tempSaleOrderReturn');
      Route::post('final/sale-return/', 'backend\SalesReturnController@finalSaveSaleReturn')->name('finalSaveSaleReturn');
      Route::get('sale-return-print/{invoice}', 'backend\SalesReturnController@saleReturnPrint')->name('saleReturnPrint');
      Route::get('sale-return-details/{invoice}', 'backend\SalesReturnController@saleReturnDetails')->name('saleReturnDetails');
      Route::get('refresh_sale-return/', 'backend\SalesReturnController@refresh_saleReturn')->name('refresh_saleReturn');
      Route::post('find/item/id/for-return', 'backend\SalesReturnController@findItemIdSaleReturn')->name('findItemIdSaleReturn');
      Route::get('find/item/qty/saleReturnQty', 'backend\SalesReturnController@saleReturnQty')->name('saleReturnQty');
      //End Sales Return

      //Sale Tax invoice issue
    Route::get('tax-invoice-issue/sales', 'backend\TaxInvoiceController@salesTaxtInvoiceIssue')->name('salesTaxtInvoiceIssue');
    Route::get('tax-invoice-details/sale-order/{sale}', 'backend\TaxInvoiceController@saleOrderTaxInvoice')->name('saleOrderTaxInvoice');
    Route::get('/tax-invoice-generate/sale-order/{sale}', 'backend\TaxInvoiceController@genTaxInvoiceSO')->name('genTaxInvoiceSO');
    Route::get('delivery-details/sale-order/{dnote}', 'backend\TaxInvoiceController@deliveryNotInvoice')->name('deliveryNotInvoice');
    Route::get('/tax-invoice-generate/delivery-note/{dnote}', 'backend\TaxInvoiceController@genTaxInvoiceDN')->name('genTaxInvoiceDN');
    Route::get('delivery-note/search', 'backend\TaxInvoiceController@searchDNo')->name('searchDNo');
    Route::get('delivery-note-search/month', 'backend\TaxInvoiceController@searchDNoMonth')->name('searchDNoMonth');
    Route::get('delivery-note/search/date', 'backend\TaxInvoiceController@searchDNoDate')->name('searchDNoDate');
    Route::get('delivery-note/search/date-range', 'backend\TaxInvoiceController@searchDNoDateRange')->name('searchDNoDateRange');
      //end sales tax invoice issue

    //   Report
        Route::get('daily-sale-report', 'backend\ReportController@dailySaleReport')->name('dailySaleReport');
    Route::get('daily-sale-report/print', 'backend\ReportController@printDailySale')->name('printDailySale');
    Route::get('daily-sale-report/date', 'backend\ReportController@searchDailySale')->name('searchDailySale');
    Route::get('daily-sale-report/date-range', 'backend\ReportController@searchDailySaleRange')->name('searchDailySaleRange');
    Route::get('/daily-sale-report/date-range/print/{from}/{to}', 'backend\ReportController@printDailySaleDateRange')->name('printDailySaleDateRange');
    Route::get('monthly-sale-report', 'backend\ReportController@monthlySaleReport')->name('monthlySaleReport');
    Route::get('invoice-wise-sale-summary', 'backend\ReportController@InvoiceWiseSaleSummary')->name('InvoiceWiseSaleSummary');
    Route::get('daily-sale-report/print/date/{date}', 'backend\ReportController@printDailySaleDate')->name('printDailySaleDate');
    Route::get('daily-sale-report/print/date/range/{from}/{to}', 'backend\ReportController@printDailySaleDateRange')->name('printDailySaleDateRange');
    Route::get('delivery-note/search/date-range', 'backend\ReportController@searchDNoDateRange')->name('searchDNoDateRange');
    Route::get('/invoice-wise-sales/search-date', 'backend\ReportController@searchinvoiceWIseDate')->name('searchinvoiceWIseDate');
    Route::get('/invoice-wise-sales/search-range', 'backend\ReportController@searchinvoiceWIseRange')->name('searchinvoiceWIseRange');
    Route::post('/filterInvoiceWiseSaleReport', 'backend\ReportController@filterInvoiceWiseSaleReport')->name('filterInvoiceWiseSaleReport');
    Route::get('/invoice-wise-daily-sales', 'backend\ReportController@invoiceWiseDailySalePrint')->name('invoiceWiseDailySalePrint');
    Route::get('/invoice-wise-daily-sales/{date}', 'backend\ReportController@invoiceWiseDailySalePrintDate')->name('invoiceWiseDailySalePrintDate');
    Route::get('/invoice-wise-daily-sales/range/{from}/{to}', 'backend\ReportController@invoiceWiseDailySalePrintRange')->name('invoiceWiseDailySalePrintRange');
    Route::get('/monthly-sale-report', 'backend\ReportController@monthylySale')->name('monthly-sale-report');
    Route::get('/monthly-sale-report/print/{month?}', 'backend\ReportController@monthlySaleReportPrint')->name('monthlySaleReportPrint');
    //Report End
    //Work by Tarek end
  // work start by mominul
  
    // mapping 
    Route::resource('mapping', 'backend\MappingController');
    Route::post('account-head', 'backend\MappingController@account_head')->name('account-head');
    Route::post('account-code', 'backend\MappingController@account_code')->name('account-code');
    // style
    Route::resource('style', 'backend\StyleController');    
    // brands
    Route::resource('brand', 'backend\BrandController');
    // group
    Route::resource('group', 'backend\GroupController');
    // list item
    Route::resource('item-list', 'backend\ItemListController');
    Route::post('vat-type-value', 'backend\ItemListController@vat_type_value')->name('vat-type-value');
    Route::post('item-type-no', 'backend\ItemListController@item_type_no')->name('item-type-no');
    Route::post('group-id', 'backend\ItemListController@group_id')->name('group-id');
    Route::post('brand-country', 'backend\ItemListController@brand_country')->name('brand-country');
    Route::get('item-delete/{id}', 'backend\ItemListController@item_delete')->name('item-list.item-delete');
    Route::post('excel-file-import', 'backend\ItemListController@import')->name('excel-file-import');
    Route::post('partyInfo_import-excel-file-import', 'backend\PartyInfoController@partyInfo_import')->name('partyInfo_import-excel-file-import');
    Route::post('style-id', 'backend\StyleController@style_id')->name('style-id');
    Route::post("item-barcode", "backend\ItemListController@item_barcode")->name("item-barcode");
    Route::post("item-barcode-check", "backend\ItemListController@item_barcode_check")->name("item-barcode-check");
    Route::post("item-name-auto-select", "backend\ItemListController@item_name_auto_select")->name("item-name-auto-select");
    Route::get("items-download", "backend\ItemListController@items_download")->name("items-download");
    // purchase requisition
    Route::resource('purchase-requisition', 'backend\PurchaseRequisitionController');

    Route::post("one-po-item-delete", "backend\PurchaseDetailController@one_po_item_delete")->name("one-po-item-delete");
    Route::post("one-po-item-edit", "backend\PurchaseDetailController@one_po_item_edit")->name("one-po-item-edit");
    Route::get("editor-pr-process/{id}", "backend\PurchaseRequisitionController@editor_pr_process")->name("editor-pr-process");
    Route::get('authorize-requisition', 'backend\PurchaseRequisitionController@authorize_requisition')->name('authorize-requisition');
    Route::get('authorize-requisition-details/{id}', 'backend\PurchaseRequisitionController@authorize_requisition_details')->name('authorize-requisition-details');
    Route::get('authorize-pr-submit/{id}', 'backend\PurchaseRequisitionController@authorize_pr_submit')->name('authorize-pr-submit');
    Route::get('approve-requisition', 'backend\PurchaseRequisitionController@approve_requisition')->name('approve-requisition');
    Route::get('approve-requisition-details/{id}', 'backend\PurchaseRequisitionController@approve_requisition_details')->name('approve-requisition-details');
    Route::get('approve-pr-submit/{id}', 'backend\PurchaseRequisitionController@approve_pr_submit')->name('approve-pr-submit');
    Route::post('item-list-get', 'backend\PurchaseRequisitionController@item_list_get')->name('item-list-get');
    Route::post('purchase-requisition-item-store', 'backend\PurchaseRequisitionDetailController@purchase_requisition_item_store')->name('purchase-requisition-item-store');
    Route::get('purchase-requisitin-aprove/{id}', 'backend\PurchaseRequisitionController@purchase_requisitin_aprove')->name('purchase-requisitin-aprove');
    Route::get('pr-item-list-delete/{id}', 'backend\PurchaseRequisitionDetailController@pr_item_delete')->name('pr-item-list-delete');
    Route::post('item-qty-get', 'backend\PurchaseRequisitionDetailController@item_qty_get')->name('item-qty-get');
    Route::post('project-name-get', 'backend\PurchaseRequisitionDetailController@project_name_get')->name('project-name-get');
    Route::get("authorize-pr-rejected/{id}", "backend\PurchaseRequisitionController@authorize_pr_rejected")->name("authorize-pr-rejected");
    Route::get("approver-pr-rejected/{id}", "backend\PurchaseRequisitionController@approver_pr_rejected")->name("approver-pr-rejected");
    Route::post("authorize-pr-reviece", "backend\PurchaseRequisitionController@authorize_pr_reviece")->name("authorize-pr-reviece");
    Route::post("approve-pr-reviece", "backend\PurchaseRequisitionController@approve_pr_reviece")->name("approve-pr-reviece");
    Route::get("rejected-requisition", "backend\PurchaseRequisitionController@rejected_requisition")->name("rejected-requisition");
    Route::get("revise-requisition-authorize", "backend\PurchaseRequisitionController@reviece_requisition_authorize")->name("revise-requisition-authorize");
    Route::get("revise-requisition-editor", "backend\PurchaseRequisitionController@reviece_requisition_editor")->name("revise-requisition-editor");
    Route::get('pr-print/{id}', 'backend\PurchaseRequisitionController@pr_print')->name('pr-print');
    Route::post("delete-previouse-pr-item", "backend\PurchaseRequisitionController@delete_previouse_pr_item")->name("delete-previouse-pr-item");
    Route::post("delete-previouse-pr-item-one", "backend\PurchaseRequisitionDetailController@delete_previouse_pr_item_one")->name("delete-previouse-pr-item-one");
    Route::post("pr-filter", "backend\PurchaseRequisitionController@pr_filter")->name("pr-filter");
    // Item purchases
    Route::resource('purchase-temp', 'backend\PurchaseTempController');
    Route::resource('purchase', 'backend\PurchaseController');
    Route::get("purchase-process/{id}", "backend\PurchaseController@purchase_process")->name("purchase-process");
    Route::get("po-generation-approval-list", "backend\PurchaseController@po_generation_approval_list")->name("po-generation-approval-list");
    Route::get("approve-po-submit/{id}", "backend\PurchaseController@approve_po_submit")->name("approve-po-submit");
    Route::post("approve-po-reviece", "backend\PurchaseController@approve_po_reviece")->name("approve-po-reviece");
    Route::get("po-generation-approval-details/{id}", "backend\PurchaseController@po_generation_approval_details")->name("po-generation-approval-details");
    Route::get("po-generation-revise-list", "backend\PurchaseController@po_generation_revise_list")->name("po-generation-revise-list");
    Route::post('purchase-temp-trasfer', 'backend\PurchaseController@purchase_temp_trasfer')->name('purchase-temp-trasfer');
    Route::resource('item-purchase', 'backend\PurchaseDetailController');
    Route::post("po-filter", "backend\PurchaseController@po_filter")->name("po-filter");
    Route::post('all-po-item-delete', 'backend\PurchaseDetailController@all_po_item_delete')->name('all-po-item-delete');
    Route::get('purchase-print/{id}', 'backend\PurchaseDetailController@purchase_print')->name('purchase-print');
    Route::post('supplier-information', 'backend\PurchaseDetailTempController@supplier_information')->name('supplier-information');
    Route::post('po-item-store', 'backend\PurchaseDetailController@po_item_store')->name('po-item-store');
    Route::get('temp-item-list-delete/{id}', 'backend\PurchaseDetailTempController@temp_item_delete')->name('temp-item-list-delete');
    // Goods Receive
    Route::resource('goods-received', 'backend\GoodsReceivedController');
    Route::get('gr-details/{id}', 'backend\GoodsReceivedController@gr_details')->name('gr-details');
    Route::get("gr-print/{id}", "backend\GoodsReceivedController@gr_print")->name("gr-print");
    Route::post("gr-list-show", "backend\GoodsReceivedController@gr_list_show")->name("gr-list-show");
    // purchase returm
    Route::resource("purchase-return", 'backend\PurchaseReturnController');
    Route::get('pt-details/{id}', 'backend\PurchaseReturnController@pt_details')->name('pt-details');
    Route::get('pr-return/{id}', 'backend\PurchaseReturnController@pt_return')->name('pr-return');
    Route::get("purchase-return-authorize", "backend\PurchaseReturnController@purchase_return_authorize")->name("purchase-return-authorize");
    Route::get("purchase-return-approval", "backend\PurchaseReturnController@purchase_return_approval")->name("purchase-return-approval");
    Route::get("pt-authorize-details/{id}", "backend\PurchaseReturnController@pt_authorize_details")->name("pt-authorize-details");
    Route::post("authorize-pt-reviece", "backend\PurchaseReturnController@authorize_pt_reviece")->name("authorize-pt-reviece");
    Route::get("purchase-return-revise", "backend\PurchaseReturnController@purchase_return_revise")->name("purchase-return-revise");
    Route::post("purchase-return-item-store", "backend\PurchaseReturnDetailController@purchase_return_item_store")->name("purchase-return-item-store");
    Route::post("pt-item-barcode", "backend\PurchaseReturnDetailController@pt_item_barcode")->name('pt-item-barcode');
    Route::get("temp-return-item-list-delete/{id}", "backend\PurchaseReturnDetailController@temp_return_item_list_delete")->name("temp-return-item-list-delete");
    Route::get("authorize-pt-rejected/{id}", "backend\PurchaseReturnController@authorize_pt_rejected")->name("authorize-pt-rejected");
    Route::get("pt-rejected-list-authorize", "backend\PurchaseReturnController@pt_rejected_list_authorize")->name("pt-rejected-list-authorize");
    Route::get("pt-rejected-list-editor", "backend\PurchaseReturnController@pt_rejected_list_editor")->name("pt-rejected-list-editor");
    Route::get("authorize-pt-submit/{id}", "backend\PurchaseReturnController@authorize_pt_submit")->name("authorize-pt-submit");
    Route::get("pt-approval-details/{id}", "backend\PurchaseReturnController@pt_approval_details")->name("pt-approval-details");
    Route::post("approval-pt-reviece", "backend\PurchaseReturnController@approval_pt_reviece")->name("approval-pt-reviece");
    Route::get("revise-pt-authorize-list", "backend\PurchaseReturnController@revise_pt_authorize_list")->name("revise-pt-authorize-list");
    Route::get("approval-pt-rejected/{id}", "backend\PurchaseReturnController@approval_pt_rejected")->name("approval-pt-rejected");
    Route::get("pt-approval-process/{id}", "backend\PurchaseReturnController@pt_approval_process")->name("pt-approval-process");
    Route::get("pt-print/{id}", "backend\PurchaseReturnController@pt_print")->name("pt-print");
    Route::post("pt-filter", "backend\PurchaseReturnController@pt_filter")->name("pt-filter");
    // payment-voucher
    Route::resource("payment-voucher", "backend\PaymentVoucherController");
    Route::get("pv-process/{id}", "backend\PaymentVoucherController@pv_process")->name("pv-process");
    Route::get("pv-create/{id}", "backend\PaymentVoucherController@pv_create")->name("pv-create");
    Route::get("pending-pv-authorize", "backend\PaymentVoucherController@pending_pv_authorize")->name("pending-pv-authorize");
    Route::get("pv-authorize-view/{id}", "backend\PaymentVoucherController@pv_authorize_view")->name("pv-authorize-view");
    Route::post("revise-pv-submit-authorizer", "backend\PaymentVoucherController@revise_pv_submit_authorizer")->name("revise-pv-submit-authorizer");
    Route::get("rejected-pv-authorizer/{id}", "backend\PaymentVoucherController@rejected_pv_authorizer")->name("rejected-pv-authorizer");
    Route::get("rejected-pv-all-editor", "backend\PaymentVoucherController@rejected_pv_all_editor")->name("rejected-pv-all-editor");
    Route::get("pv-approve-authorizer/{id}", "backend\PaymentVoucherController@pv_approve_authorizer")->name("pv-approve-authorizer");
    Route::get("pending-pv-approval", "backend\PaymentVoucherController@pending_pv_approval")->name("pending-pv-approval");
    Route::get("pv-approval-view/{id}", "backend\PaymentVoucherController@pv_approval_view")->name("pv-approval-view");
    Route::post("revise-pv-submit-approval", "backend\PaymentVoucherController@revise_pv_submit_approval")->name("revise-pv-submit-approval");
    Route::get("revise-pv-all-editor", "backend\PaymentVoucherController@revise_pv_all_editor")->name("revise-pv-all-editor");
    Route::get("revise-pv-authorizer-approver", "backend\PaymentVoucherController@revise_pv_authorizer_approver")->name("revise-pv-authorizer-approver");
    Route::get("rejected-pv-approver/{id}", "backend\PaymentVoucherController@rejected_pv_approver")->name("rejected-pv-approver");
    Route::get("rejected-pv-authorize", "backend\PaymentVoucherController@rejected_pv_authorize")->name("rejected-pv-authorize");
    Route::get("pv-approve-approval/{id}", "backend\PaymentVoucherController@pv_approve_approval")->name("pv-approve-approval");
    Route::get("approve-pv-view/{id}", "backend\PaymentVoucherController@approve_pv_view")->name("approve-pv-view");
    Route::get("pv-pdf-print/{id}", "backend\PaymentVoucherController@pv_pdf_print")->name("pv-pdf-print");
    Route::post("pv-filter", "backend\PaymentVoucherController@pv_filter")->name("pv-filter");
    // Receipt Voucher
    Route::resource("receipt-voucher", "backend\ReceiptVoucherController");
    Route::get("invoice-details/{id}", "backend\ReceiptVoucherController@invoice_details")->name("invoice-details");
    Route::get("receipt-voucher-create/{id}", "backend\ReceiptVoucherController@receipt_voucher_create")->name("receipt-voucher-create");
    Route::get("receipt-voucher-process/{id}", "backend\ReceiptVoucherController@receipt_voucher_process")->name("receipt-voucher-process");
    Route::get("receipt-voucher-print/{id}", "backend\ReceiptVoucherController@receipt_voucher_print")->name("receipt-voucher-print");
    Route::get("receipt-voucher-approval-list", "backend\ReceiptVoucherController@receipt_voucher_approval_list")->name("receipt-voucher-approval-list");
    Route::get("approve-rv-details/{id}", "backend\ReceiptVoucherController@approve_rv_details")->name("approve-rv-details");
    Route::post("approve-rv-reviece", "backend\ReceiptVoucherController@approve_rv_reviece")->name("approve-rv-reviece");
    Route::get("approver-rv-approve/{id}", "backend\ReceiptVoucherController@approver_rv_approve")->name("approver-rv-approve");
    Route::get("rv-revise-list", "backend\ReceiptVoucherController@rv_revise_list")->name("rv-revise-list");
    Route::get("rv-revise-update/{id}", "backend\ReceiptVoucherController@rv_revise_update")->name("rv-revise-update");
    Route::post("rv-revise-update-complete/{id}", "backend\ReceiptVoucherController@rv_revise_update_complete")->name("rv-revise-update-complete");
    Route::post("rv-filter", "backend\ReceiptVoucherController@rv_filter")->name("rv-filter");
 

     // purchase summary report
  Route::resource("purchase-summary", "backend\PurchaseSummaryController");
  Route::get('purchase-summery/date', 'backend\PurchaseSummaryController@searchDailyPurch')->name('searchDailyPurch');
  Route::get('purchase-summery/date-range', 'backend\PurchaseSummaryController@searchDailyPurchageRange')->name('searchDailyPurchageRange');
  Route::get('purchase-summary-print', 'backend\PurchaseSummaryController@printPurchaseSummery')->name('printPurchaseSummery');
  Route::get('purchase-summery-print/date/{date}', 'backend\PurchaseSummaryController@printPurchaseSummeryDate')->name('printPurchaseSummeryDate');
  Route::get('purchase-summery-print/range/{from}/{to}', 'backend\PurchaseSummaryController@printPurchaseSummeryRange')->name('printPurchaseSummeryRange');


  // work end by mominul

  // work end by mominul

  

 // Shagor: Invoice Posting
Route::get('invoice-posting', 'backend\InvoicePosting@index')->name('invoice_posting');
Route::get('invoice-posting/{id}', 'backend\InvoicePosting@invoice_post_form')->name('invoice_post_form');
Route::post('invoice-posting-submit','backend\InvoicePosting@invoice_posting_submit')->name('invoice-posting-submit');
Route::get('ip-details/{id}', 'backend\InvoicePosting@ip_details')->name('ip_details');
// users
Route::resource('user','backend\UserController');

Route::get('business-summary-report', 'backend\ExpenseController@business_summary_report')->name('b-summary-report');
Route::get('business-summary-report-print', 'backend\ExpenseController@business_summary_report_print')->name('b-summary-report-print');

// expense 
Route::resource('expense', 'backend\ExpenseController');
Route::post('expense-get-account-head','backend\ExpenseController@get_account_heads')->name('expense_get_account_head');

Route::resource('document','backend\DocumentController');
Route::post('document-search', 'backend\DocumentController@search')->name('document-search');

Route::get('under-const', 'HomeController@under_construction')->name('under-const');
// Shagor End


// Accounting marge by shagor 

//  new work by mominul 12/10/2022
Route::get('new-chart-of-account', 'backend\MasterAccountController@chart_of_account')->name('new-chart-of-account');
Route::get("chart-ofaccount-pdf", "backend\MasterAccountController@chart_of_account_pdf")->name("chart-ofaccount-pdf");
Route::get('new-journal', 'backend\JournalEntryController@new_journal')->name('new-journal');
Route::get('journal-success/{id}', 'backend\JournalEntryController@journal_success')->name('journal-success');
Route::get("journal-edit/{id}", "backend\JournalEntryController@journal_edit")->name("journal_edit");
Route::get("journal-approval-section", "backend\JournalEntryController@journal_approval_section")->name("journal-approval-section");
Route::post("journal-authorize-show-modal", "backend\JournalEntryController@journal_authorize_show_modal")->name("journal-authorize-show-modal");
Route::post("journal-approval-show-modal", "backend\JournalEntryController@journal_approval_show_modal")->name("journal-approval-show-modal");
Route::get("new-journal-creation", "backend\JournalEntryController@new_journal_creation")->name("new-journal-creation");
Route::post('journal-creation-section', 'backend\JournalEntryController@journal_creation_section')->name('journal-creation-section');
Route::post('voucher-details-modal', 'backend\JournalEntryController@voucher_details_modal')->name('voucher-details-modal');
Route::post('voucher-preview-modal', 'backend\JournalEntryController@voucher_preview_modal')->name('voucher-preview-modal');
Route::get('journal-authorization-section', 'backend\JournalEntryController@journal_authorization_section')->name('journal-authorization-section');
Route::post('journal-add-new-head', 'backend\JournalEntryController@journal_add_new_head')->name('journal-add-new-head');
Route::get('new-expense', 'backend\ExpenseController@new_expense')->name("new-expense");
Route::post("party-center-preview", "backend\PartyInfoController@party_center_preview")->name("party-center-preview");
Route::get('journal-view-pdf/{id}', 'backend\JournalEntryController@journal_view_pdf')->name('journal-view-pdf');
Route::get('tem-journal-view-pdf/{id}', 'backend\JournalEntryController@tem_journal_view_pdf')->name('tem-journal-view-pdf');

// New acconts report
Route::get('new-general-ledger', 'backend\AccountsReportController@new_general_ledger')->name('new-general-ledger');
Route::get('new-general-ledger/date-range', 'backend\AccountsReportController@new_general_ledger_by_date_range')->name('new-general-ledger-by-date-range');
Route::get('new-general-ledger/date', 'backend\AccountsReportController@new_general_ledger_by_date')->name('new-general-ledger-by-date');
Route::get('new-trial-balance', 'backend\AccountsReportController@new_trial_balance')->name('new-trial-balance');
Route::get('new-trial-balance/date', 'backend\AccountsReportController@new_trial_balance_date')->name('new-trial-balance-date');
Route::get('new-trial-balance/date-range', 'backend\AccountsReportController@new_trial_balance_date_range')->name('new-trial-balance-date-range');
Route::get('new-accounts-payable-ledger', 'backend\AccountsReportController@new_accounts_payable_ledger')->name('new-accounts-payable-ledger');
Route::get('new-accounts-receivable-ledger', 'backend\AccountsReportController@new_accounts_receivable_ledger')->name('new-accounts-receivable-ledger');
Route::get('new-party-ledger', 'backend\PartyLedgerController@new_party_ledger')->name('new-party-ledger');
Route::get('general-ledger/print', 'backend\AccountsReportController@general_ledger_print')->name('print-gl');
Route::get('general-ledger/print/date/{date}', 'backend\AccountsReportController@general_ledger_print_date')->name('print-gl-date');
Route::get('general-ledger/print/date/range/{from}/{to}', 'backend\AccountsReportController@general_ledger_print_date_range')->name('print-gl-date-range');
Route::get('trial-balance/print', 'backend\AccountsReportController@trial_balance_print')->name('trial-balance-print');
Route::get('trial-balance/print/date/{date}', 'backend\AccountsReportController@trial_balance_print_date')->name('trial-balance-print-date');
Route::get('trial-balance/print/date-range/{from}/{to}', 'backend\AccountsReportController@trial_balance_print_date_range')->name('trial-balance-print-date-range');


//work by tarek
Route::get('new-general-ledger/filter', 'backend\AccountsReportController@new_general_filter')->name('new-general-filter');
Route::get('new-general-ledger/filter-all', 'backend\AccountsReportController@new_general_filter_all')->name('new-general-filter-range-all');
Route::get('new-general-ledger/filter-range', 'backend\AccountsReportController@new_general_filter_range')->name('new-general-filter-range');

// Party ledger by Tarek
Route::get('party-ledger', 'backend\PartyLedgerController@partyLedger')->name('partyLedger');
Route::get('find/party-ledger', 'backend\PartyLedgerController@findPartyLedgers')->name('findPartyLedgers');
Route::get('find/party-ledger/date', 'backend\PartyLedgerController@findPartyLedgersDate')->name('findPartyLedgersDate');
Route::get('find/party-ledger/{from}/{to}/{party}', 'backend\PartyLedgerController@printLedger')->name('printLedger');
Route::get('finds/party-ledger/date/{date}/{party}', 'backend\PartyLedgerController@printLedgerDate')->name('printLedgerDate');


// 15/10/2022
Route::get("new-mapping", "backend\MappingController@new_mapping")->name("new-mapping");
Route::post("new-find-account-head", "backend\MappingController@new_find_account_head")->name("new-find-account-head");
Route::get('new-account-head', 'backend\MasterAccountController@new_account_head')->name('new-account-head');
Route::post("new-account-code", "backend\MappingController@new_account_code")->name("new-account-code");
Route::post("mapping-edit-modal", "backend\MappingController@mapping_edit_modal")->name("mapping-edit-modal");
Route::get("new-project-details", "backend\ProjectController@new_project_details")->name("new-project-details");
Route::post("business-edit-modal", "backend\ProjectController@business_edit_modal")->name("business-edit-modal");
Route::post("business-view-modal", "backend\ProjectController@business_view_modal")->name("business-view-modal");
Route::get("new-bank-details", "backend\BankController@new_bank_details")->name("new-bank-details");
Route::post("bank-details-edit-modal", "backend\BankController@bank_details_edit_modal")->name("bank-details-edit-modal");
Route::get('get-party-info/{id}', 'backend\PartyInfoController@get_party_info')->name('get-party-info');
Route::get('journal-view-pdf/{id}', 'backend\JournalEntryController@journal_view_pdf')->name('journal-view-pdf');
Route::get('tem-journal-view-pdf/{id}', 'backend\JournalEntryController@tem_journal_view_pdf')->name('tem-journal-view-pdf');

Route::post('projectView', 'backend\ProjectController@projectView')->name('projectView');
Route::get('project-list-print', 'backend\ProjectController@project_list_print')->name('project-list-print');
Route::get('bank-list-print', 'backend\BankController@bank_lint_print')->name('bank-list-print');


// End: Accounting marge by shagor 

// Moshiur Bhaia Report
Route::get('customer-balance', 'backend\AccountsReportController@customer_balance')->name('customer-balance');
Route::POST('customer-invoice-report', 'backend\AccountsReportController@customer_invoice_report')->name('customer-invoice-report');
Route::POST('invoice-view-modal', 'backend\AccountsReportController@invoice_view_modal')->name('invoice-view-modal');

Route::get('ar-ageing-summary', 'backend\AccountsReportController@ar_ageing_summary')->name('ar-ageing-summary');
Route::get('ar-ageing-summary/{id}', 'backend\AccountsReportController@ar_ageing_summary_one')->name('ar-ageing-summary-one');
Route::get('ar-ageing-details', 'backend\AccountsReportController@ar_ageing_details')->name('ar-ageing-details');

Route::get('receivable-summary', 'backend\AccountsReportController@receivable_summary')->name('receivable-summary');
Route::get('receivable-details/{id}', 'backend\AccountsReportController@receivable_details')->name('receivable-details');

Route::get('inventory-valuation-summary', 'backend\InventoryReportController@inventory_valuation_summary')->name('inventory-valuation-summary');
Route::get('inventory-summary', 'backend\InventoryReportController@inventory_summary')->name('inventory-summary');

Route::get('fifo-cost-lot-tracking', 'backend\InventoryReportController@fifo_cost_lost_tracking')->name('fifo-cost-lot-tracking');
Route::get('inventory-ageing-report', 'backend\InventoryReportController@inventory_ageing_report')->name('inventory-ageing-report');
Route::get('ageing-classification', 'backend\InventoryReportController@ageing_classification')->name('ageing-classification');
Route::get('stock-summary-report', 'backend\InventoryReportController@stock_summary_report')->name('stock-summary-report');
Route::get('product-sales-cost', 'backend\InventoryReportController@product_sales_cost')->name('product-sales-cost');
Route::get('abc-classification', 'backend\InventoryReportController@abc_classification')->name('abc-classification');


// Mominul Accounts Report
Route::get('tax-invoice-detail', 'backend\AccountsReportController@tax_invoice_detail')->name('tax-invoice-detail');
Route::get('customer-order', 'backend\AccountsReportController@customer_order')->name('customer-order');
Route::get('customer-balance-summary', 'backend\AccountsReportController@customer_balance_summary')->name('customer-balance-summary');
Route::post('customer-summary-details', 'backend\AccountsReportController@customer_summary_details')->name('customer-summary-details');
Route::get('vendor-balance-summary', 'backend\AccountsReportController@vendor_balance_summary')->name('vendor-balance-summary');
Route::get('vendor-balances', 'backend\AccountsReportController@vendor_balances')->name('vendor-balances');
Route::post('vendor-balances-details', 'backend\AccountsReportController@vendor_balances_details')->name('vendor-balances-details');
Route::get('bills-details', 'backend\AccountsReportController@bills_details')->name('bills-details');
Route::get('vendor-debit-details', 'backend\AccountsReportController@vendor_debit_details')->name('vendor-debit-details');
Route::get('purchase-order-details', 'backend\AccountsReportController@purchase_order_details')->name('purchase-order-details');
Route::get('purchase-order-by-vendor', 'backend\AccountsReportController@purchase_order_by_vendor')->name('purchase-order-by-vendor');
Route::get('purchase-by-vendor', 'backend\AccountsReportController@purchase_by_vendor')->name('purchase-by-vendor');
Route::get('purchase-by-item', 'backend\AccountsReportController@purchase_by_item')->name('purchase-by-item');
Route::get('expenses-details', 'backend\AccountsReportController@expenses_details')->name('expenses-details');

Route::get('ar-ageing-pdf-download', 'backend\AccountsReportController@ar_ageing_pdf_download')->name('ar-ageing-pdf-download');
Route::get('ar-ageing-excel-download', 'backend\AccountsReportController@ar_ageing_excel_download')->name('ar-ageing-excel-download');
Route::get('vbd-pdf-download/{id}', 'backend\AccountsReportController@vendor_balance_details_pdf_download')->name('vbd-pdf-download');
Route::get('vbd-excel-download/{id}', 'backend\AccountsReportController@vbd_excel_download')->name('vbd-excel-download');
Route::post('purchase-order-by-vendor-details', 'backend\AccountsReportController@purchase_order_by_vendor_details')->name('purchase-order-by-vendor-details');
Route::get('pov-pdf-download/{id}', 'backend\AccountsReportController@pov_pdf_download')->name('pov-pdf-download');
Route::get('pov-excel-download/{id}', 'backend\AccountsReportController@pov_excel_download')->name('pov-excel-download');

Route::get('expenses-by-category', 'backend\AccountsReportController@expenses_by_category')->name('expenses-by-category');
Route::get('expenses-by-customer', 'backend\AccountsReportController@expenses_by_customer')->name('expenses-by-customer');
Route::get('payments-mode', 'backend\AccountsReportController@payments_mode')->name('payments-mode');
Route::resource('estimate-list', 'backend\EstimateDetailsController');
Route::get('estimate-details', 'backend\AccountsReportController@estimate_details')->name('estimate-details');
Route::get('expenses-by-project', 'backend\AccountsReportController@expenses_by_project')->name('expenses-by-project');


// Tarek Accounting Report
//payable
Route::get('ap-ageing-summary', 'backend\PayableReportController@ap_ageing_summary')->name('ap-ageing-summary');
Route::get('ap-ageing-summary/{id}', 'backend\PayableReportController@ap_ageing_summary_one')->name('ap-ageing-summary-one');
Route::get('ap-ageing-details', 'backend\PayableReportController@ap_ageing_details')->name('ap-ageing-details');
Route::get('payable-summary', 'backend\PayableReportController@payable_summary')->name('payable-summary');
Route::get('payable-details/{id}', 'backend\PayableReportController@payable_details')->name('payable-details');
Route::get('payable-details-view', 'backend\PayableReportController@payable_details_view')->name('payable-details-view');

});
