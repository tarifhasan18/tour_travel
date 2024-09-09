<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductCategoryController;
Use App\Http\Controllers\SubCategory1Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\SalaryDetailsController;
use App\Http\Controllers\SalaryInfoController;
use App\Http\Controllers\SalaryTypeController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\OrderController;

Route::get('/',[HomeController::class,'display_homepage']);
Route::get('/dashboard',[HomeController::class,'display_homepage'])->middleware(['auth','verified'])->name('dashboard');
//Route::get('/dashboard',[AdminController::class,'index']);
// Route::get('/',[HomeController::class,'home']);
// Route::get('/dashboard',[HomeController::class,'login_home'])->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('home.index');
// });

// Route::get('dashboard', function(){
//     return view('admin.index');
// })->middleware(['auth','verified']);

Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard')->middleware(['auth','admin']);

Route::get('/add_packages',[AdminController::class,'add_packages'])->name('add.packages')->middleware(['auth','admin']);
Route::post('/submit_packages',[AdminController::class,'submit_packages'])->middleware(['auth','admin']);
Route::get('/view_packages',[AdminController::class,'view_packages'])->middleware(['auth','admin']);
Route::get('/delete_packages/{id}',[AdminController::class,'delete_packages'])->middleware(['auth','admin']);
Route::get('/edit_packages/{id}',[AdminController::class,'edit_packages'])->middleware(['auth','admin']);
Route::post('/update_packages/{id}',[AdminController::class,'update_packages'])->middleware(['auth','admin']);
Route::get('/view_details/{id}',[HomeController::class,'view_details']);
Route::post('/book_now/{id}',[HomeController::class,'book_now']);
//paynow from my booking
Route::post('/usersPayNow',[HomeController::class,'usersPayNow'])->name('usersPayNow');
Route::get('/view_booking',[AdminController::class,'view_booking'])->middleware(['auth','admin']);
Route::get('/approve_booking/{id}',[AdminController::class,'approve_booking'])->middleware(['auth','admin']);
Route::get('/reject_booking/{id}',[AdminController::class,'reject_booking'])->middleware(['auth','admin']);
Route::get('remove_booking/{id}',[AdminController::class,'remove_booking'])->middleware(['auth','admin']);
Route::get('payment_details',[AdminController::class,'payment_details'])->middleware(['auth','admin']);
Route::post('addPayment',[AdminController::class,'addPayment'])->name('addPayment')->middleware(['auth','admin']);
Route::get('approve_payment/{id}',[AdminController::class,'approve_payment'])->middleware(['auth','admin']);
Route::get('reject_payment/{id}',[AdminController::class,'reject_payment'])->middleware(['auth','admin']);
Route::get('all_payment_report',[AdminController::class,'all_payment_report'])->middleware(['auth','admin']);
//newly added at 08-09-2024
Route::get('approved_rejected_booking',[AdminController::class,'approved_rejected_booking'])->middleware(['auth','admin']);
Route::get('view_all_customer',[AdminController::class,'view_all_customer'])->middleware(['auth','admin']);
Route::get('view_customer_bookings/{email}',[AdminController::class,'view_customer_bookings'])->middleware(['auth','admin']);


Route::get('/view_tour_packages',[HomeController::class,'view_tour_packages']);
Route::get('/our_services',[PageController::class,'our_services']);
Route::get('/service_details/{id}',[PageController::class,'service_details']);
Route::get('/about_us',[PageController::class,'about_us']);
Route::get('/contact_us',[PageController::class,'contact_us']);
Route::get('/search_booking',[AdminController::class,'search_booking'])->middleware(['auth','admin']);
Route::get('/search_packages',[AdminController::class,'search_packages'])->middleware(['auth','admin']);
Route::post('/send_contact_message',[HomeController::class,'send_contact_message']);
Route::get('/view_message',[AdminController::class,'view_message'])->middleware(['auth','admin']);
Route::get('/remove_message/{id}',[AdminController::class,'remove_message'])->middleware(['auth','admin']);
Route::get('/reply_email/{id}',[AdminController::class,'reply_email'])->middleware(['auth','admin']);
Route::post('/reply_message/{id}',[AdminController::class,'reply_message'])->middleware(['auth','admin']);
Route::get('/search_contact',[AdminController::class,'search_contact'])->middleware(['auth','admin']);
Route::get('/add_users',[AdminController::class,'add_users'])->middleware(['auth','admin']);
Route::post('/submit_users',[AdminController::class,'submit_users'])->middleware(['auth','admin']);
Route::get('/view_users',[AdminController::class,'view_users'])->middleware(['auth','admin']);
Route::get('/remove_users/{id}',[AdminController::class,'remove_users'])->middleware(['auth','admin']);
Route::get('/edit_users/{id}',[AdminController::class,'edit_users'])->middleware(['auth','admin']);
Route::post('/update_users/{id}',[AdminController::class,'update_users'])->middleware(['auth','admin']);
Route::get('site_settings',[AdminController::class,'site_settings'])->middleware(['auth','admin']);
Route::post('/update_site_settings/{id}',[AdminController::class,'update_site_settings'])->middleware(['auth','admin']);
Route::get('/my_bookings',[HomeController::class,'my_bookings'])->middleware(['auth','verified']);
Route::get('/update_about_us',[PageController::class,'update_about_us'])->middleware(['auth','admin']);
Route::get('/add_our_services',[PageController::class,'add_our_services'])->middleware(['auth','admin']);
Route::post('/submit_our_services',[PageController::class,'submit_our_services'])->middleware(['auth','admin']);
Route::get('/delete_service/{id}',[PageController::class,'delete_service'])->middleware(['auth','admin']);
Route::get('/edit_service/{id}',[PageController::class,'edit_service'])->middleware(['auth','admin']);
Route::post('/update_our_services/{id}',[PageController::class,'update_our_services'])->middleware(['auth','admin']);
Route::get('/submit_selected_packages',[AdminController::class,'submit_selected_packages'])->middleware(['auth','admin']);
Route::post('/submit_about_us',[PageController::class,'submit_about_us'])->middleware(['auth','admin']);
Route::get('/add_category',[AdminController::class,'add_category'])->middleware(['auth','admin']);
Route::post('/submit_category',[AdminController::class,'submit_category'])->middleware(['auth','admin']);
Route::get('/view_category',[AdminController::class,'view_category'])->middleware(['auth','admin']);
Route::get('/add_product',[AdminController::class,'add_product'])->middleware(['auth','admin']);
Route::post('/submit_product',[AdminController::class,'submit_product'])->middleware(['auth','admin']);
Route::get('/view_product',[AdminController::class,'view_product'])->middleware(['auth','admin']);
Route::get('/delete_category/{id}',[AdminController::class,'delete_category'])->middleware(['auth','admin']);
Route::get('/delete_product/{id}',[AdminController::class,'delete_product'])->middleware(['auth','admin']);
Route::get('/edit_category/{id}',[AdminController::class,'edit_category'])->middleware(['auth','admin']);
Route::post('/update_category/{id}',[AdminController::class,'update_category'])->middleware(['auth','admin']);
Route::get('/edit_product/{id}',[AdminController::class,'edit_product'])->middleware(['auth','admin']);
Route::post('/update_product/{id}',[AdminController::class,'update_product'])->middleware(['auth','admin']);
Route::get('/search_products',[AdminController::class,'search_products'])->middleware(['auth','admin']);
Route::get('/search_category',[AdminController::class,'search_category'])->middleware(['auth','admin']);
Route::get('/add_unit',[AdminController::class,'add_unit'])->middleware(['auth','admin']);
Route::POST('/submit_unit',[AdminController::class,'submit_unit'])->middleware(['auth','admin']);
// Route::get('/delete_unit/{id}',[AdminController::class,'delete_unit'])->middleware(['auth','admin']);
Route::get('/edit_unit/{id}',[AdminController::class,'edit_unit'])->middleware(['auth','admin']);
Route::post('/update_unit/{id}',[AdminController::class,'update_unit'])->middleware(['auth','admin']);


//New routes for photo gallery (04-09-2024)
Route::get('/photo_gallery',[PageController::class,'photo_gallery']);
Route::get('/add_photo_gallery',[AdminController::class,'add_photo_gallery'])->middleware(['auth','admin']);
Route::post('/submit_photo_gallery',[AdminController::class,'submit_photo_gallery'])->middleware(['auth','admin']);

//Customer Traveller's All Payments History in mybookings(04-09-2024)
Route::get('/view_all_payments_users',[HomeController::class,'view_all_payments_users'])->middleware(['auth','verified']);


//From Possie
// Unit

Route::get('/all-unit', [UnitController::class, 'index'])->name('all-unit');
Route::get('/add-unit', [UnitController::class, 'show'])->name('add-unit');
Route::post('/create-unit', [UnitController::class, 'store'])->name('create-unit');
Route::get('/edit-unit/{id}', [UnitController::class, 'edit'])->name('edit-unit');
Route::post('/update-unit', [UnitController::class, 'update'])->name('update-unit');


// Category

Route::get('/all-product-cat', [ProductCategoryController::class, 'AllProductCategory'])->name('all-product-cat');
Route::get('/product-cat', [ProductCategoryController::class,'addProductCat'])->name('addProductCat');
Route::post('/create-cat', [ProductCategoryController::class, 'createCategory'])->name('create-cat');
Route::get('/edit-category/{id}', [ProductCategoryController::class, 'edit'])->name('edit-category');
Route::post('/update-category', [ProductCategoryController::class, 'update'])->name('update-category');

// Sub Category One

Route::get('/all-subCat1', [SubCategory1Controller::class, 'AllSubCat1'])->name('all-subCat1');
Route::get('/sub-cat1', [SubCategory1Controller::class, 'index'])->name('subCat1');
Route::post('/create-cat1', [SubCategory1Controller::class, 'createSubCategoryOne'])->name('create-cat1');
Route::get('/edit-subCat1/{id}', [SubCategory1Controller::class, 'edit'])->name('edit-subCat1');
Route::post('/update-subCat1', [SubCategory1Controller::class, 'update'])->name('update-subCat1');

// Product

Route::get('/all-products', [ProductController::class, 'AllProducts'])->name('all-products');
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::post('/create-product', [ProductController::class, 'create'])->name('create-product');
Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('edit-product');
Route::post('/update-product', [ProductController::class, 'store'])->name('update-product');

// Suppliers

Route::get('/all-suppliers', [SupplierController::class, 'index'])->name('all-suppliers');
Route::get('/add-supplier', [SupplierController::class, 'show'])->name('add-supplier');
Route::post('/create-supplier', [SupplierController::class, 'store'])->name('create-supplier');
Route::get('/edit-supplier/{id}', [SupplierController::class, 'edit'])->name('edit-supplier');
Route::post('/update-supplier', [SupplierController::class, 'update'])->name('update-supplier');

//Purchase

    Route::get('/purchase-form', [PurchaseInvoiceController::class, 'index'])->name('purchase-form');
    Route::get('/purchase-sub-category/{id}', [PurchaseInvoiceController::class, 'purchaseSubCategory'])->name('purchase-sub-category');
    Route::get('/purchase-cat-wise-items/{id}', [PurchaseInvoiceController::class, 'purchaseCategoryWiseItems'])->name('purchase-cat-wise-items');
    Route::get('/purchase-barcode-wise-items/{id}', [PurchaseInvoiceController::class, 'purchaseBarcodeWiseItems'])->name('purchase-barcode-wise-items');
    Route::get('/add-purchased-items-to-temp/{id}/{msg}', [PurchaseInvoiceController::class, 'addPurchaseItemToTempCart'])->name('add-purchased-items-to-temp');
    Route::get('/get_purchased_temp_cart_data/{id}', [PurchaseInvoiceController::class, 'purchasedTempCartData'])->name('get_purchased_temp_cart_data');
    Route::get('/delete_purchase_temp_cart_item/{id}', [PurchaseInvoiceController::class, 'deleteTempPurchaseItem'])->name('delete_purchase_temp_cart_item');
    Route::get('/edit_purchase_temp_cart_item/{id}', [PurchaseInvoiceController::class, 'editTempPurchaseItem'])->name('edit_purchase_temp_cart_item');
    Route::post('/store-purchase-product-data', [PurchaseInvoiceController::class, 'storePurchaseProductData'])->name('store-purchase-product-data');
    Route::post('/storePurchaseForm', [PurchaseInvoiceController::class, 'storePurchaseForm'])->name('storePurchaseForm');
    Route::post('/savePurchaseForm',[PurchaseInvoiceController::class, 'savePurchaseForm'])->name('savePurchaseForm');
    Route::get('/delete_purchase_form', [PurchaseInvoiceController::class, 'deletePurchaseForm'])->name('delete_purchase_form');
    Route::get('/ajax-get-unit', [PurchaseInvoiceController::class, 'ajaxGetUnit'])->name('ajax-get-unit');
    Route::get('/ajax-get-supplyer', [PurchaseInvoiceController::class, 'ajaxGetSupplyer'])->name('ajax-get-supplyer');
    Route::get('/ajax-get-location', [PurchaseInvoiceController::class, 'ajaxGetLocation'])->name('ajax-get-location');
    Route::post('/ajax-store-supplier-data', [PurchaseInvoiceController::class, 'ajaxStoreSupplierData'])->name('ajax-store-supplier-data');
    Route::post('/ajax-store-location-data', [PurchaseInvoiceController::class, 'ajaxStoreLocationData'])->name('ajax-store-location-data');
    Route::get('/get_purchase_temp_cart_data/{id}', [PurchaseInvoiceController::class, 'purchaseTempCartData'])->name('get_purchase_temp_cart_data');
    Route::get('/purchase_price_calculation/{id}/{qty}/{sales_price}', [PurchaseInvoiceController::class, 'priceCalculation'])->name('purchase_price_calculation');
    Route::get('/printPurchaseInvoice/{id}', [PurchaseInvoiceController::class, 'printPurchaseInvoice'])->name('printPurchaseInvoice');


    Route::get('/daily-purchase-report', [PurchaseReportController::class, 'dailyPurchaseReport'])->name('daily-purchase-report');
    Route::get('/range-purchase-report', [PurchaseReportController::class, 'rangePurchaseReport'])->name('range-purchase-report');
    Route::get('/all-purchase-report', [PurchaseReportController::class, 'allPurchaseReport'])->name('all-purchase-report');
    Route::get('/all-purchase-report-for-vat', [PurchaseReportController::class, 'allPurchaseReportForVat'])->name('all-purchase-report-for-vat');
    Route::get('/sup-purchase-report/{supplier_id}', [PurchaseReportController::class, 'supPurchaseReport'])->name('sup-purchase-report');
    Route::get('/pur-name-quantity/{purchase_id}', [PurchaseReportController::class, 'purNameQuantity'])->name('pur-name-quantity');

    Route::get('/ajax-get-balance/{bank_id}', [BankController::class, 'ajaxGetBalance'])->name('ajax-get-balance');



    // Sales Actions
    Route::get('/sales-form', [SalesController::class, 'index'])->name('sales-form');
    Route::get('/get_sales_temp_cart_data/{id}/{sales_type}', [SalesController::class, 'salesTempCartData'])->name('get_sales_temp_cart_data');
    Route::get('/get-ajax-category', [SalesController::class, 'getAjaxCategory'])->name('get-ajax-category');
    Route::get('/get-ajax-deliveryman', [SalesController::class, 'getAjaxDelivery'])->name('get-ajax-deliveryman');
    Route::get('/sales-cat-wise-items/{id}', [SalesController::class, 'salesCategoryWiseItems'])->name('sales-cat-wise-items');
    Route::get('/sales-barcode-wise-items/{id}', [SalesController::class, 'salesBarcodeWiseItems'])->name('sales-barcode-wise-items');
    Route::get('/sales-sub-category/{id}', [SalesController::class, 'salesSubCategory'])->name('sales-sub-category');
    Route::get('/autocomplete-mobile-no/{id}', [SalesController::class, 'autocompleteMobileNo'])->name('autocomplete-mobile-no');
    Route::post('/add-sales-items-to-temp', [SalesController::class, 'addSalesItemToTempCart'])->name('add-sales-items-to-temp');
    Route::get('/add-sales-items-with-barcode/{barcode}/{msg}/{sales_type}', [SalesController::class, 'addSalesItemsWithBarcode'])->name('add-sales-items-with-barcode');
    Route::get('/delete_sales_form', [SalesController::class, 'destroy'])->name('delete_sales_form');
    Route::get('/delete_temporary_payment/{id}', [SalesController::class, 'destroyTemporaryPayment'])->name('delete_temporary_payment');
    Route::get('/delete_sales_temp_cart_item/{id}/{sales_type}', [SalesController::class, 'destroyTempCart'])->name('delete_sales_temp_cart_item');
    Route::get('/price_calculation/{id}/{qty}/{sales_price}/{sales_type}', [SalesController::class, 'priceCalculation'])->name('price_calculation');
    Route::post('/store-sales-temp-payment', [SalesController::class, 'salesTempPayment'])->name('store-sales-temp-payment');
    Route::post('/store-sales', [SalesController::class, 'storeSales'])->name('store-sales');
    Route::get('/add_suspense/{id}/{waiter_id}/{table_no}', [SalesController::class, 'addSuspense'])->name('add_suspense');
    Route::get('/get-suspended-items', [SalesController::class, 'getSuspendedItems'])->name('get-suspended-items');
    Route::get('/get_suspended_data/{id}', [SalesController::class, 'getSuspendedData'])->name('get_suspended_data');
    Route::get('/get-waiter', [SalesController::class, 'getWaiter'])->name('get-waiter');
    Route::get('/sales-type-wise-price/{id}/{msg}', [SalesController::class, 'salesTypeWisePrice'])->name('sales-type-wise-price');

    Route::get('/get_all_barcode', [SalesController::class, 'get_all_barcode'])->name('get_all_barcode');




    //expense and Salary
    Route::get('/expense', [ExpenseController::class, 'expense'])->name('expense');
    Route::post('/expense', [ExpenseController::class, 'insert'])->name('insert-expense');
    Route::get('/fetch-expense', [ExpenseController::class, 'getdata'])->name('fetch-expense');
    Route::get('/edit-expense/{id}', [ExpenseController::class, 'edit_expense'])->name('edit-expense');
    Route::put('/update-expense/{id}', [ExpenseController::class, 'update_expense'])->name('update-expense');
    Route::get('/delete-expense/{id}', [ExpenseController::class, 'delete_expense'])->name('delete-expense');

    Route::get('/all-expenses', [ExpenseController::class, 'allExpenses'])->name('all-expenses');
    Route::get('/all-expenses-vat-show', [ExpenseController::class, 'allExpensesVatSHow'])->name('all-expensesVatSHow');

    //Expense section

    Route::get('/expense-category-list', [ExpenseCategoryController::class, 'expense_category_list'])->name('expense_category_list');
    Route::get('/add-expense-category', [ExpenseCategoryController::class, 'add_expense_category'])->name('add-expense-category');
    Route::post('/insert-expense-category', [ExpenseCategoryController::class, 'insert_expense_category'])->name('insert-expense-category');
    Route::get('/edit-expense-category/{id}', [ExpenseCategoryController::class, 'edit_expense_category'])->name('edit-expense-category');
    Route::put('/update-expense-category/{id}', [ExpenseCategoryController::class, 'update_expense_category'])->name('update-expense-category');


    //Salary Type
    Route::get('/salary-type', [SalaryTypeController::class, 'index'])->name('salary-type');
    Route::post('/salary-type-add', [SalaryTypeController::class, 'store'])->name('salary-type-add');
    Route::get('/salary-type-edit/{id}', [SalaryTypeController::class, 'edit'])->name('salary-type-edit');
    Route::put('/salary-type-update/{id}', [SalaryTypeController::class, 'update'])->name('salary-type-update');

    //Salary Info
    Route::get('/salary-info', [SalaryInfoController::class, 'index'])->name('salary-info');
    Route::post('/salary-info-add', [SalaryInfoController::class, 'store'])->name('salary-info-add');
    Route::get('/salary-info-edit/{id}', [SalaryInfoController::class, 'edit'])->name('salary-info-edit');
    Route::put('/salary-info-update/{id}', [SalaryInfoController::class, 'update'])->name('salary-info-update');

    //salary orderDetails
    Route::get('/salary-details', [SalaryDetailsController::class, 'index'])->name('salary-details');
    Route::get('/salary-info-amount/{id}', [SalaryDetailsController::class, 'getSalaryInfoAmount'])->name('salary-info-amount');
    Route::post('/salary-details-create', [SalaryDetailsController::class, 'store'])->name('salary-details-add');


    //Bank Actions

    Route::get('/bank-actions', [BankController::class,'bank_actions'])->name('bank-actions');
    Route::get('/ajax-all-bank', [BankController::class, 'ajaxAllBank'])->name('ajax-all-bank');
    Route::post('/ajax-store-dw-data', [BankController::class, 'ajaxStoreDWData'])->name('ajax-store-dw-data');
    Route::get('/ajax-all-transactions', [BankController::class, 'ajaxAllTransactions'])->name('ajax-all-transactions');
    Route::post('/ajax-generate-report', [BankController::class, 'ajaxGenerateReport'])->name('ajax-generate-report');
    Route::get('/trx-reports', [BankController::class, 'TrxReport'])->name('trx-reports');

    //Bank Section
    Route::get('/bank-list', [BankController::class, 'bank_list'])->name('bank_list');
    Route::get('/add-bank', [BankController::class, 'add_bank'])->name('add-bank');
    Route::post('/insert-bank', [BankController::class, 'insert_bank'])->name('insert-bank');
    Route::get('/edit-bank/{id}', [BankController::class, 'edit_bank'])->name('edit-bank');
    Route::put('/update-bank/{id}', [BankController::class, 'update_bank'])->name('update-bank');


     //Stock
     Route::get('/all-stock-report', [StockReportController::class, 'stock_report'])->name('all-stock-report');
     Route::get('/store-stock-report', [StockReportController::class, 'store_stock_report'])->name('store-stock-report');
     Route::get('/stock-transfer', [StockReportController::class, 'stock_transfer'])->name('stock-transfer');
     Route::post('/transfer-stock', [StockReportController::class, 'store_stock_transfer'])->name('transfer-stock');
     Route::get('/p-w-a-q/{product_id}', [StockReportController::class, 'PWAQ'])->name('p-w-a-q');
     Route::get('/p-w-s/{product_id}', [StockReportController::class, 'PWS'])->name('p-w-s');
     Route::get('/p-w-r/{product_id}', [StockReportController::class, 'PWR'])->name('p-w-r');
     Route::get('/p-w-s-d/{store_id}/{product_id}', [StockReportController::class, 'PWSD'])->name('p-w-s-d');
     Route::get('/p-w-s-q/{store_id}/{product_id}', [StockReportController::class, 'PWSQ'])->name('p-w-s-q');
     Route::get('/cat-wise-stock/{category_id}', [StockReportController::class, 'CatWiseStock'])->name('cat-wise-stock');


     Route::get('/supplier-payment', [SupplierPaymentController::class, 'index'])->name('supplier-payment');
        Route::post('/store-supplier-payment', [SupplierPaymentController::class, 'store'])->name('store-supplier-payment');
        Route::get('/edit-supplier-payment/{id}', [SupplierPaymentController::class, 'edit'])->name('edit-supplier-payment');
        Route::post('/update-supplier-payment/{id}', [SupplierPaymentController::class, 'update'])->name('update-supplier-payment');
        Route::get('/ajax-get-sup-invoice/{id}', [SupplierPaymentController::class, 'ajaxGetSupInvoice'])->name('ajax-get-sup-invoice');
        Route::get('/ajax-get-pur-data/{id}', [SupplierPaymentController::class, 'ajaxGetPurData'])->name('ajax-get-pur-data');
        Route::get('/ajax-get-pur-data/{id}', [SupplierPaymentController::class, 'ajaxGetPurData'])->name('ajax-get-pur-data');

        // Route::get('/customer-payment', [CustomerPaymentController::class, 'index'])->name('customer-payment');
        // Route::post('/store-customer-payment', [CustomerPaymentController::class, 'store'])->name('store-customer-payment');
        // Route::get('/edit-customer-payment/{id}', [CustomerPaymentController::class, 'edit'])->name('edit-customer-payment');
        // Route::post('/update-customer-payment/{id}', [CustomerPaymentController::class, 'update'])->name('update-customer-payment');
        // Route::get('/ajax-get-cus-invoice/{id}', [CustomerPaymentController::class, 'ajaxGetCusInvoice'])->name('ajax-get-cus-invoice');

        Route::get('/accounts-receivable', [AccountController::class, 'accountsReceivable'])->name('accounts-receivable');
        Route::get('/accounts-payable', [AccountController::class, 'accountsPayable'])->name('accounts-payable');
        Route::get('/payment-report', [AccountController::class, 'paymentReport'])->name('payment-report');
        Route::get('/cashflow', [AccountController::class, 'cashflow'])->name('cashflow');

        Route::get('/income-statement', [AccountController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/ajax-get-income-stat/{id}', [AccountController::class, 'ajaxGetIncomeStat'])->name('ajax-get-income-stat');
        Route::get('/multi-date-income-stat/{from}/{to}', [AccountController::class, 'multiDateIncomeStat'])->name('multi-date-income-stat');
        Route::get('/day-end/{id}', [AccountController::class, 'dayEnd'])->name('day-end');
        Route::get('/supplier-payments', [AccountController::class, 'supplierPayments'])->name('supplier-payments');
        Route::get('/customer-payments', [AccountController::class, 'customerPayments'])->name('customer-payments');


        //reports
        Route::get('/salesReport', [ReportController::class, 'salesReport'])->name('salesReport');
        Route::get('/single-date-sales/{id}', [ReportController::class, 'singleDateSales'])->name('single-date-sales');
        Route::get('/multi-date-sales/{from}/{to}', [ReportController::class, 'multiDateSales'])->name('multi-date-sales');
        Route::get('/customer-mobile/{id}', [ReportController::class, 'customerMobile'])->name('customer-mobile');
        Route::get('/due-list/{id}', [ReportController::class, 'dueList'])->name('due-list');


        Route::get('/purchaseReport', [ReportController::class, 'purchaseReport'])->name('purchaseReport');
        Route::get('/single-date-purchase/{id}', [ReportController::class, 'singleDatePurchase'])->name('single-date-purchase');
        Route::get('/multi-date-purchase/{from}/{to}', [ReportController::class, 'multiDatePurchase'])->name('multi-date-purchase');

        Route::get('/stockReport', [ReportController::class, 'stockReport'])->name('stockReport');
        Route::get('/profitLossReport', [ReportController::class, 'profitLossReport'])->name('profitLossReport');

        Route::get('/expenseReport', [ReportController::class, 'expenseReport'])->name('expenseReport');
        Route::get('/single-date-expense/{id}', [ReportController::class, 'singleDateExpense'])->name('single-date-expense');
        Route::get('/multi-date-expense/{from}/{to}', [ReportController::class, 'multiDateExpense'])->name('multi-date-expense');
        Route::get('/single-expense-category/{id}', [ReportController::class, 'singleExpenseCategory'])->name('single-expense-category');

        Route::get('/salaryReport', [ReportController::class, 'salaryReport'])->name('salaryReport');

        Route::get('/supplier-balance', [ReportController::class, 'SupplierBalance'])->name('supplier-balance');
        Route::get('/customer-balance', [ReportController::class, 'CustomerBalance'])->name('customer-balance');
        Route::get('/ajax-get-customer', [ReportController::class, 'ajaxGetCustomer'])->name('ajax-get-customer');
        Route::get('/ajax-get-customer-details/{id}', [ReportController::class, 'ajaxGetCustomerDetails']);
        Route::get('/print-customer-ledger/{id}', [ReportController::class, 'generatePdf'])->name('printPDF');
        Route::get('/ajax-get-supplier', [ReportController::class, 'ajaxGetSupplier'])->name('ajax-get-supplier');
        Route::get('/ajax-get-supplier-details/{id}', [ReportController::class, 'ajaxGetSupplierDetails']);
        Route::get('/print-supplier-ledger/{id}', [ReportController::class, 'generateSupPdf'])->name('printSupPDF');

        Route::get('/get_all_barcode', [SalesController::class, 'get_all_barcode'])->name('get_all_barcode');

        //Order Section
        Route::get('/suspended_orders', [OrderController::class, 'suspendedOrders'])->name('suspended_orders');
        Route::get('/daily_sales_report', [OrderController::class, 'dailySalesReport'])->name('daily_sales_report');
        Route::get('/all_sales_report', [OrderController::class, 'allSalesReport'])->name('all_sales_report');
        Route::get('/month_sales_report', [OrderController::class, 'monthSalesReport'])->name('month_sales_report');
        Route::get('/all_sales_report_show_vat_admin', [OrderController::class, 'allSalesReportShowVatAdmin'])->name('all_sales_report.vatAdmin');
        Route::get('/about-company', [OrderController::class, 'aboutRestaurant'])->name('about-company');
        Route::get('/printInvoice/{id}', [OrderController::class, 'printInvoice'])->name('printInvoice');
        Route::get('/CatWiseSells/{consumer_id}', [OrderController::class, 'CatWiseSell'])->name('CatWiseSells');
        Route::get('/product-name-quantity/{cart_id}', [OrderController::class, 'productNameQuantity'])->name('product-name-quantity');

        // Cart Return

        Route::get('/all-return', [ReturnController::class, 'index'])->name('all-return');
        Route::get('/completed-return', [ReturnController::class, 'completedReturns'])->name('completed-return');
        Route::get('/create-return', [ReturnController::class, 'create'])->name('create-return');
        Route::post('/store-return', [ReturnController::class, 'store'])->name('store-return');
        Route::get('/view-return/{id}', [ReturnController::class, 'view'])->name('view-return');
        Route::get('/get-products', [ReturnController::class, 'getAjaxProducts'])->name('get-products');
        Route::get('/get-all-customer', [ReturnController::class, 'getAjaxAllCustomer'])->name('get-all-customer');
        Route::get('/store-damage/{cart_id}/{product_id}/{quantity}/{rate}/{deliveryManId}', [ReturnController::class, 'storeDamage'])->name('store-damage');
        Route::get('/store-customer-due/{cart_id}/{customer_id}/{amount}/{deliveryManID}', [ReturnController::class, 'storeCustomerDue'])->name('store-customer-due');
        Route::get('/delete_temp_damage_return_item/{temp_item_id}', [ReturnController::class, 'deleteTempDamageReturnItem'])->name('delete_temp_damage_return_item');
        Route::get('/delete_temp_due_item/{temp_item_id}', [ReturnController::class, 'deleteTempDueItem'])->name('delete_temp_due_item');
        Route::get('/get-damage-item/{deliveryManId}/{cartID}', [ReturnController::class, 'getAjaxDamageItems'])->name('get-damage-item');
        Route::get('/get-temp-due-item/{deliveryManId}/{cartID}', [ReturnController::class, 'getAjaxDueItems'])->name('get-temp-due-item');
        Route::get('/get-return-cart/{id}', [ReturnController::class, 'getReturnCart'])->name('get-return-cart');
        Route::get('/get-return-item/{id}', [ReturnController::class, 'getReturnItem'])->name('get-return-item');
        Route::get('/return-authorization/{id}{authorize_status}', [ReturnController::class, 'Authorization'])->name('return-authorization');
        Route::get('/recived-to-warehouse/{id}', [ReturnController::class, 'recivedToWarehouse'])->name('recived-to-warehouse');
