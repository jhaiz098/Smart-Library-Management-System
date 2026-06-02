<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PUBLIC
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->post('/login/auth', 'Auth::loginAuth');

$routes->get('/register', 'Auth::register');
$routes->post('/register/auth', 'Auth::registerAuth');

$routes->get('/logout', 'Auth::logout');

$routes->get('/unauthorized', 'Error::unauthorized');

$routes->get('/server_time', 'Server::server_time');

$routes->get('/auth/change_password', 'Auth::must_change_pass');
$routes->post('/auth/update_password', 'Auth::must_update_pass');



// PRIVATE (PROTECTED) (Login required)

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/logout', 'Auth::logout');
});


//ADMIN
$routes->group('admin', ['filter' => 'auth:1,2'], function($routes) {

$routes->get('dashboard', 'Admin\Admin::dashboard');
$routes->get('book_management_active', 'Admin\Admin::book_management_active');
$routes->get('book_management_draft', 'Admin\Admin::book_management_draft');

$routes->get('book_management/add_book', 'Admin\Book::add_book');
$routes->get('book_management/view_book/(:num)', 'Admin\Book::view_book/$1');
$routes->get('book_management/edit_book/(:num)', 'Admin\Book::edit_book/$1');
$routes->post('book_management/save_book', 'Admin\Book::save_book');
$routes->post('book_management/delete_book/(:num)', 'Admin\Book::delete_book/$1');

$routes->post('book_management/publish_book/(:num)', 'Admin\Book::publish_book/$1');
$routes->post('book_management/unpublish_book/(:num)', 'Admin\Book::unpublish_book/$1');

$routes->get('borrowed_books/borrowed', 'Admin\BorrowedBooks::borrowed_books_list');
$routes->post('borrowed_books/return/', 'Admin\BorrowedBooks::borrowed_books_return');
$routes->post('borrowed_books/extend/', 'Admin\BorrowedBooks::borrowed_books_extend');
$routes->get('borrowed_books/history/(:num)', 'Admin\BorrowedBooks::borrowed_books_history/$1');

$routes->get('borrowed_books/returned', 'Admin\BorrowedBooks::returned_books_list');

$routes->get('borrow_requests/pending_borrow_requests', 'Admin\Book::pending_borrow_requests_list');
$routes->post('borrow_requests/pending_borrow_requests_reject/(:num)', 'Admin\Book::pending_borrow_requests_reject/$1');
$routes->post('borrow_requests/pending_borrow_requests_approve/(:num)', 'Admin\Book::pending_borrow_requests_approve/$1');

$routes->get('borrow_requests/approved_borrow_requests', 'Admin\Book::approved_borrow_requests_list');
$routes->post('borrow_requests/approved_borrow_requests_claim/(:num)', 'Admin\Book::approved_borrow_requests_claim/$1');
$routes->post('borrow_requests/approved_borrow_requests_cancel/(:num)', 'Admin\Book::approved_borrow_requests_cancel/$1');

$routes->get('borrow_requests/completed_borrow_requests', 'Admin\Book::completed_borrow_requests_list');
$routes->get('borrow_requests/expired_borrow_requests', 'Admin\Book::expired_borrow_requests_list');

$routes->get('users', 'Admin\User::list');
$routes->get('users/add_user', 'Admin\User::add_user');
$routes->post('users/add', 'Admin\User::add');
$routes->get('users/view/(:num)', 'Admin\User::view/$1');
$routes->get('users/edit/(:num)', 'Admin\User::edit/$1');
$routes->get('users/toggle_status/(:num)', 'Admin\User::toggle_status/$1');
$routes->post('users/update/(:num)', 'Admin\User::update/$1');
$routes->post('users/delete/(:num)', 'Admin\User::delete/$1');
$routes->post('users/reset_password/(:num)', 'Admin\User::reset_password/$1');

$routes->get('paid_fines_list', 'Admin\Fines::paid_fines_list');
$routes->get('unpaid_fines_list', 'Admin\Fines::unpaid_fines_list');
$routes->post('unpaid_fines_list/pay_fine', 'Admin\Fines::pay_fine');

$routes->get('library_settings', 'Admin\Setting::library_settings');
$routes->post('library_settings/update', 'Admin\Setting::library_settings_update');

$routes->get('category_management_settings', 'Admin\Setting::category_management_settings');
$routes->post('category_management_settings/add_category', 'Admin\Setting::add_category');
$routes->post('category_management_settings/update_category', 'Admin\Setting::update_category');
$routes->post('category_management_settings/delete_category/(:num)', 'Admin\Setting::delete_category/$1');

$routes->get('role_permissions_settings', 'Admin\Setting::role_permissions_settings');
$routes->post('role_permissions_settings/update', 'Admin\Setting::update_permission');
});



//USER
$routes->group('user', ['filter' => 'auth:3'], function($routes) {

$routes->get('dashboard', 'User\User::dashboard');
$routes->get('books', 'User\Book::book_list');
$routes->get('books/view/(:num)', 'User\Book::book_view/$1');
$routes->post('books/view/send_borrow_request/(:num)', 'User\Book::send_borrow_request/$1');
$routes->post('books/view/cancel_borrow_request/(:num)', 'User\Book::cancel_borrow_request/$1');

$routes->post('books/view/reserve_book/(:num)', 'User\Book::reserve_book/$1');
$routes->post('books/view/cancel_reserve_book/(:num)', 'User\Book::cancel_reserve_book/$1');

$routes->get('my_transactions/borrowings', 'User\Transactions::borrowings_list');
$routes->get('my_transactions/borrow_requests', 'User\Transactions::borrow_requests_list');
$routes->get('my_transactions/reservations', 'User\Transactions::reservations_list');
$routes->get('my_transactions/all', 'User\Transactions::all_list');

$routes->get('overdue/list', 'User\Overdue::list');

$routes->get('fines/unpaid', 'User\Fines::unpaid_list');
$routes->get('fines/paid', 'User\Fines::paid_list');
$routes->get('fines/all', 'User\Fines::all_list');

$routes->get('profile', 'User\Profile::display');
$routes->post('profile/change_password', 'User\Profile::change_password');

$routes->get('help', 'User\Help::display');
});