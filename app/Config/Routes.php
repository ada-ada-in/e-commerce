<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// admin
$routes->group('admin', ['filter' => 'admin'], static function($routes) {
// $routes->group('admin', static function($routes) {
    $routes->get('dashboard', 'PagesController::dashboard', ['as' => 'dashboard']);
    $routes->get('product', 'PagesController::product', ['as' => 'product']);
    $routes->get('category', 'PagesController::category', ['as' => 'category']);
    $routes->get('paid', 'PagesController::paid', ['as' => 'paid']);
    $routes->get('pending', 'PagesController::pending', ['as' => 'pending']);
    $routes->get('cancel', 'PagesController::cancel', ['as' => 'cancel']);
    $routes->get('data', 'PagesController::data', ['as' => 'data']);
    $routes->get('order', 'PagesController::order', ['as' => 'order']);
    $routes->get('send', 'PagesController::send', ['as' => 'send']);
    $routes->get('pickup', 'PagesController::pickup', ['as' => 'pickup']);
    $routes->get('report', 'PagesController ::report', ['as' => 'report']);
    $routes->get('users', 'PagesController::users', ['as' => 'users']);
    $routes->get('profile', 'PagesController::profile', ['as' => 'profile']);
    $routes->get('complete', 'PagesController::complete', ['as' => 'complete']);
    $routes->get('inventory', 'PagesController::stokin', ['as' => 'stokin']);
});


// user
$routes->group('', static function($routes) {
    $routes->get('/', 'PagesController::user', ['as' => 'user']);
    $routes->get('/about', 'PagesController::about', ['as' => 'about']);
    $routes->get('allcategory', 'PagesController::allcategory', ['as' => 'allcategory']);
    $routes->get('allproduct', 'PagesController::allproduct', ['as' => 'allproduct']);
    $routes->get('profile', 'PagesController::userProfile', [
        'as' => 'userProfile',
        'filter' => 'auth'
    ]);
    $routes->get('payment', 'PagesController::payment', [
        'as' => 'payment',
        'filter' => 'auth'
    ]);
    $routes->get('delivery', 'PagesController::delivery', [
        'as' => 'delivery',
        'filter' => 'auth'
    ]);
    $routes->get('inventory', 'PagesController::inventory', [
        'as' => 'inventory',
        'filter' => 'auth'
    ]);
    $routes->get('checkout', 'PagesController::checkout', [
        'as' => 'checkout',
        'filter' => 'auth'
    ]);
    $routes->get('productcategory', 'PagesController::productCategory', [
        'as' => 'productCategory',
        'filter' => 'auth'
    ]);

});


// auth
$routes->group('auth', static function($routes) {
    $routes->get('login', 'PagesController::login', ['as' => 'login']);
    $routes->get('register', 'PagesController::register', ['as' => 'register']);
    $routes->get('logout', 'PagesController::logout', ['as' => 'logout']);
});


// api
$routes->group('api/v1', static function($routes) {
    $routes->group('auth', static function($routes) {
        $routes->post('login', 'Api\V1\auth\AuthController::login', ['as' => 'api.auth.login']);
        $routes->post('register', 'Api\V1\auth\AuthController::register', ['as' => 'api.auth.register']);
        $routes->post('logout', 'Api\V1\auth\AuthController::logout', ['as' => 'api.auth.logout']);
    });

    $routes->group('users', static function($routes) {
        $routes->get('', 'Api\V1\User\UserController::getDataUser', ['as' => 'api.users.getDataUser']);
        $routes->get('print', 'Api\V1\User\UserController::printDataUser', ['as' => 'api.users.printDataUser']);
        $routes->get('profile', 'Api\V1\User\UserController::getDataUserProfile', ['as' => 'api.users.getDataUserProfile']);
        $routes->put('profile/update', 'Api\V1\User\UserController::getDataUserProfileById', ['as' => 'api.users.getDataUserProfileById']);
        $routes->get('countuser', 'Api\V1\User\UserController::countUser', ['as' => 'api.users.countUser']);
        $routes->get('(:num)', 'Api\V1\User\UserController::getDataUserById/$1', ['as' => 'api.users.getDataUserById']);
        $routes->delete('(:num)', 'Api\V1\User\UserController::deleteDataUserById/$1', ['as' => 'api.userss.deleteDataUserById']);
        $routes->put('(:num)', 'Api\V1\User\UserController::updateDataUserById/$1', ['as' => 'api.users.updateDataUserById']);
    });

    $routes->group('category', static function($routes) {
        $routes->post('', 'Api\V1\Category\CategoryController::addCategory', ['as' => 'api.category.addCategory']);
        $routes->delete('(:num)', 'Api\V1\Category\CategoryController::deleteCategory/$1', ['as' => 'api.category.deleteCategory']);
        $routes->get('', 'Api\V1\Category\CategoryController::getDataCategory', ['as' => 'api.category.getDataCategory']);
        $routes->get('print', 'Api\V1\Category\CategoryController::printDataProduct', ['as' => 'api.category.printDataProduct']);
        $routes->get('(:num)', 'Api\V1\Category\CategoryController::getDataCategoryById/$1', ['as' => 'api.category.getDataCategoryById']);
        $routes->put('(:num)', 'Api\V1\Category\CategoryController::updateDataCategoryById/$1', ['as' => 'api.category.updateDataCategoryById']);
    });

    $routes->group('transactions', static function($routes) {
        $routes->post('', 'Api\V1\Transactions\TransactionsController::addTransaction', ['as' => 'api.transactions.addTransaction']);
        $routes->delete('(:num)', 'Api\V1\Transactions\TransactionsController::deleteTransaction/$1', ['as' => 'api.transactions.deleteTransaction']);
        $routes->get('counttransactions', 'Api\V1\Transactions\TransactionsController::countTransaction', ['as' => 'api.transactions.countTransaction']);
        $routes->get('getlatesttransactions', 'Api\V1\Transactions\TransactionsController::getLatestTransaction', ['as' => 'api.payment.getLatestTransaction']);
        $routes->get('countprofit', 'Api\V1\Transactions\TransactionsController::countProfit', ['as' => 'api.transactions.countProfit']);
        $routes->get('chartmonthgraph', 'Api\V1\Transactions\TransactionsController::chartMonthGraph', ['as' => 'api.transactions.chartMonthGraph']);
        $routes->get('', 'Api\V1\Transactions\TransactionsController::getDataTransaction', ['as' => 'api.transactions.getDataTransaction']);
        $routes->get('paid/print', 'Api\V1\Transactions\TransactionsController::printPaidTransactions', ['as' => 'api.transactions.printPaidTransactions']);
        $routes->get('data/print', 'Api\V1\Transactions\TransactionsController::printDataTransactions', ['as' => 'api.transactions.printDataTransactions']);
        $routes->get('pending/print', 'Api\V1\Transactions\TransactionsController::printPendingTransactions', ['as' => 'api.transactions.printPendingTransactions']);
        $routes->get('cancel/print', 'Api\V1\Transactions\TransactionsController::printCancelTransactions', ['as' => 'api.transactions.printCancelTransactions']);
        $routes->get('paid/date', 'Api\V1\Transactions\TransactionsController::sortPaidTransactionByDate', ['as' => 'api.transactions.sortPaidTransactionByDate']);
        $routes->get('pending/date', 'Api\V1\Transactions\TransactionsController::sortPendingTransactionByDate', ['as' => 'api.transactions.sortPendingTransactionByDate']);
        $routes->get('cancel/date', 'Api\V1\Transactions\TransactionsController::sortCancelTransactionByDate', ['as' => 'api.transactions.sortCancelTransactionByDate']);
        $routes->get('data/date', 'Api\V1\Transactions\TransactionsController::sortDataTransactionByDate', ['as' => 'api.transactions.sortDataTransactionByDate']);
        $routes->get('paid', 'Api\V1\Transactions\TransactionsController::getDataPaidTransaction', ['as' => 'api.transactions.getDataPaidTransaction']);
        $routes->get('pending', 'Api\V1\Transactions\TransactionsController::getDataPendingTransaction', ['as' => 'api.transactions.getDataPendingTransaction']);
        $routes->get('user', 'Api\V1\Transactions\TransactionsController::getDataUserTransaction', ['as' => 'api.transactions.getDataUserTransaction']);
        $routes->get('cancel', 'Api\V1\Transactions\TransactionsController::getDataCancelTransaction', ['as' => 'api.transactions.getDataCancelTransaction']);
        $routes->get('(:num)', 'Api\V1\Transactions\TransactionsController::getDataTransactionById/$1', ['as' => 'api.transactions.getDataTransactionById']);
        $routes->put('(:num)', 'Api\V1\Transactions\TransactionsController::updateDataTransactionyById/$1', ['as' => 'api.transactions.updateDataTransactionyById']);
    }); 

    $routes->group('cartitems', static function($routes) {
        $routes->post('', 'Api\V1\CartItems\CartItemsController::addCartItem', ['as' => 'api.cartItem.addCartItem']);
        $routes->delete('(:num)', 'Api\V1\CartItems\CartItemsController::deleteCartItem/$1', ['as' => 'api.cartItem.deleteCartItem']);
        $routes->get('', 'Api\V1\CartItems\CartItemsController::getDataCartItem', ['as' => 'api.cartItem.getDataCartItem']);
        $routes->get('(:num)', 'Api\V1\CartItems\CartItemsController::getDataCartItemById/$1', ['as' => 'api.cartItem.getDataCartItemById']);
        $routes->get('user', 'Api\V1\CartItems\CartItemsController::getDataCartItemByUser', ['as' => 'api.cartItem.getDataCartItemByUser']);
        $routes->put('(:num)', 'Api\V1\CartItems\CartItemsController::updateDataCategoryById/$1', ['as' => 'api.cartItem.updateDataCategoryById']);
    }); 

    $routes->group('payments', static function($routes) {
        $routes->post('', 'Api\V1\Payment\PaymentController::addPayment', ['as' => 'api.payment.addPayment']);
        $routes->delete('(:num)', 'Api\V1\Payment\PaymentController::deletePayment/$1', ['as' => 'api.payment.deletePayment']);
        $routes->get('', 'Api\V1\Payment\PaymentController::getDataPayment', ['as' => 'api.payment.getDataPayment']);
        $routes->get('getlatestpayment', 'Api\V1\Payment\PaymentController::getLatestPayment', ['as' => 'api.payment.getLatestPayment']);
        $routes->get('(:num)', 'Api\V1\Payment\PaymentController::getDataPaymentById/$1', ['as' => 'api.payment.getDataPaymentById']);
        $routes->put('(:num)', 'Api\V1\Payment\PaymentController::updateDataTransactionyById/$1', ['as' => 'api.payment.updateDataTransactionyById']);
    }); 

    $routes->group('products', static function($routes) {
        $routes->post('', 'Api\V1\Product\ProductController::addProduct', ['as' => 'api.product.addProduct']);
        $routes->delete('(:num)', 'Api\V1\Product\ProductController::deleteProduct/$1', ['as' => 'api.product.deleteProduct']);
        $routes->get('', 'Api\V1\Product\ProductController::getDataProduct', ['as' => 'api.product.getDataProduct']);
        $routes->get('print', 'Api\V1\Product\ProductController::printDataProduct', ['as' => 'api.product.printDataProduct']);
        $routes->get('limit', 'Api\V1\Product\ProductController::getDataProductLimit', ['as' => 'api.product.getDataProductLimit']);
        $routes->get('countproduct', 'Api\V1\Product\ProductController::countProduct', ['as' => 'api.product.countProduct']);
        $routes->get('(:num)', 'Api\V1\Product\ProductController::getDataProductById/$1', ['as' => 'api.product.getDataProductById']);
        $routes->get('userproduct/(:num)', 'Api\V1\Product\ProductController::getDataProductByCategoryId/$1', ['as' => 'api.product.getDataProductByCategoryId']);
        $routes->put('(:num)', 'Api\V1\Product\ProductController::updateDataProductById/$1', ['as' => 'api.product.updateDataProductyById']);
    }); 

    $routes->group('stokin', static function($routes) {
        $routes->post('', 'Api\V1\StokIn\StokInController::addStokIn', ['as' => 'api.stokin.addStokIn']);
        $routes->delete('(:num)', 'Api\V1\StokIn\StokInController::deleteStokIn/$1', ['as' => 'api.stokin.deleteStokIn']);
        $routes->get('', 'Api\V1\StokIn\StokInController::getDataStokIn', ['as' => 'api.stokin.getDataStokIn']);
        $routes->get('(:num)', 'Api\V1\StokIn\StokInController::getDataStokInById/$1', ['as' => 'api.stokin.getDataStokInById']);
        $routes->put('(:num)', 'Api\V1\StokIn\StokInController::updateDataStokInById/$1', ['as' => 'api.stokin.updateDataStokInById']);
    }); 

    $routes->group('transactionsitems', static function($routes) {
        $routes->post('', 'Api\V1\TransactionsItems\TransactionsItemsController::addTransactionItems', ['as' => 'api.transactionsitems.addTransactionItems']);
        $routes->delete('(:num)', 'Api\V1\TransactionsItems\TransactionsItemsController::deleteTransactionItems/$1', ['as' => 'api.transactionsitems.deleteTransactionItems']);
        $routes->get('', 'Api\V1\TransactionsItems\TransactionsItemsController::getDataTransactionItems', ['as' => 'api.transactionsitems.getDataTransactionItems']);
        $routes->get('(:num)', 'Api\V1\TransactionsItems\TransactionsItemsController::getDataTransactionItemsById/$1', ['as' => 'api.transactionsitems.getDataTransactionItemsById']);
        $routes->get('inventory/(:num)', 'Api\V1\TransactionsItems\TransactionsItemsController::getDataTransactionItemsTransactionsById/$1', ['as' => 'api.transactionsitems.getDataTransactionItemsTransactionsById']);
        $routes->get('transactions', 'Api\V1\TransactionsItems\TransactionsItemsController::getDataTransactionItemsTransactionsById', ['as' => 'api.transactionsitems.getDataTransactionItemsTransactionsById']);
        $routes->put('(:num)', 'Api\V1\TransactionsItems\TransactionsItemsController::updateDataTransactionsItemsyById/$1', ['as' => 'api.transactionsitems.updateDataTransactionsItemsyById']);
    }); 

    
    $routes->group('delivery', static function($routes) {
        $routes->post('', 'Api\V1\Delivery\DeliveryController::addDelivery', ['as' => 'api.delivery.addDelivery']);
        $routes->delete('(:num)', 'Api\V1\Delivery\DeliveryController::deleteDelivery/$1', ['as' => 'api.Delivery.deleteDelivery']);
        $routes->get('', 'Api\V1\Delivery\DeliveryController::getDataDelivery', ['as' => 'api.Delivery.getDataDelivery']);
        $routes->get('send', 'Api\V1\Delivery\DeliveryController::getDataSendDelivery', ['as' => 'api.Delivery.getDataSendDelivery']);
        $routes->get('order', 'Api\V1\Delivery\DeliveryController::getDataOrderDelivery', ['as' => 'api.Delivery.getDataOrderDelivery']);
        $routes->get('complete', 'Api\V1\Delivery\DeliveryController::getDataCompleteDelivery', ['as' => 'api.Delivery.getDataCompleteDelivery']);
        $routes->get('pickup', 'Api\V1\Delivery\DeliveryController::getDataPickUpDelivery', ['as' => 'api.Delivery.getDataPickUpDelivery']);
        $routes->get('trackingnumber', 'Api\V1\Delivery\DeliveryController::getDataTrackingDelivery', ['as' => 'api.Delivery.getDataTrackingDelivery']);
        $routes->get('(:num)', 'Api\V1\Delivery\DeliveryController::getDataDeliveryById/$1', ['as' => 'api.Delivery.getDataDeliveryById']);
        $routes->get('transactions/(:num)', 'Api\V1\Delivery\DeliveryController::getDataDeliveryByTransactionsId/$1', ['as' => 'api.Delivery.getDataDeliveryByTransactionsId']);
        $routes->put('(:num)', 'Api\V1\Delivery\DeliveryController::updateDataCategoryById/$1', ['as' => 'api.Delivery.updateDataCategoryById']);
    }); 

    $routes->group('payments', static function($routes) {
        $routes->post('', 'Api\V1\Payment\PaymentController::addPayment', ['as' => 'api.payment.addPayment']);
    }); 

    $routes->group('webhook', static function($routes) {
        $routes->post('', 'Api\V1\WebHook\WebHookController::index', ['as' => 'api.webhook.index']);
    }); 
    
});