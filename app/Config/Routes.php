<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);
$routes->get('/', 'Home::index');
$routes->group('v1', static function ($routes) {
    $routes->group('auth', static function ($routes) {
        $routes->post('mobile-login', 'Security\AuthController::mobileLogin');
        $routes->post('generate-token', 'Security\AuthController::generateToken');
    });
    $routes->group('gateway', static function ($routes) {
        $routes->group('sms', static function ($routes) {
            $routes->group('supplier', ['filter' => 'tokenAuth'], static function ($routes) {
                $routes->get('details-dashboard', 'Gateway\SMS\SupplierController::detailsDashboard');
                $routes->get('pending-messages', 'Gateway\SMS\SupplierController::pendingMessages');
                $routes->post('confirm-sent-message', 'Gateway\SMS\SupplierController::confirmSentMessage');
            });
            $routes->group('client', ['filter' => 'tokenAuth'], static function ($routes) {
                $routes->post('send', 'Gateway\SMS\ClientController::send');
            });
        });
    });
});
$routes->group('client', static function ($routes) {
    $routes->group('system', static function ($routes) {
        $routes->get('', 'Gateway\SMS\ClientController::index', ['as' => 'client/system/list']);
        $routes->post('add', 'ClientController::add', ['as' => 'client/system/add']);
        $routes->get('edit/(:num)', 'ClientController::edit/$1', ['as' => 'client/system/edit']);
        $routes->post('update', 'ClientController::update', ['as' => 'client/system/update']);
        $routes->get('regenerate-token/(:num)', 'ClientController::regenerateToken/$1', ['as' => 'client/system/regenerate-token']);
        $routes->get('report/(:num)', 'ClientController::report/$1', ['as' => 'client/system/report']);
        $routes->get('general-report', 'ClientController::generalReport', ['as' => 'client/system/general-report']);
    });
});



$routes->get('/', function () {
    return redirect()->to('dashboards/default-dashboard');
});

// Dashboard
$routes->group('dashboards', static function ($routes) {
    $routes->get('default-dashboard', function () {
        return view('Admin/dashboard/dashboard');
    });
    $routes->get('ecommerce', function () {
        return view('Admin/dashboard/ecommerce_dashboard');
    });
    $routes->get('online_course', function () {
        return view('Admin/dashboard/online_course_dashboard');
    });
    $routes->get('social_dashboard', function () {
        return view('Admin/dashboard/social_dashboard');
    });
    $routes->get('crypto_dashboard', function () {
        return view('Admin/dashboard/crypto_dashboard');
    });
});

//Widget
$routes->group('Widgets', static function ($routes) {
    $routes->get('general-widget', function () {
        return view('Admin/widgets/general-widget');
    });
    $routes->get('chart-widget', function () {
        return view('Admin/widgets/chart-widget');
    });
});
// Page-Layout
$routes->group('page-layout', static function ($routes) {
    $routes->get('box-layout', function () {
        return view('Admin/page-layout/box-layout');
    });
    $routes->get('layout-rtl', function () {
        return view('Admin/page-layout/rlt-layout');
    });
    $routes->get('layout-dark', function () {
        return view('Admin/page-layout/layout-dark');
    });
    $routes->get('hide-on-scroll', function () {
        return view('Admin/page-layout/hide-on-scroll');
    });
    $routes->get('footer-light', function () {
        return view('Admin/page-layout/footer-light');
    });
    $routes->get('footer-dark', function () {
        return view('Admin/page-layout/footer-dark');
    });
    $routes->get('footer-fixed', function () {
        return view('Admin/page-layout/footer-fixed');
    });
});

// project
$routes->group('projects', static function ($routes) {
    $routes->get('project-list', function () {
        return view('Admin/project/projects-list');
    });
    $routes->get('project-create', function () {
        return view('Admin/project/projectcreate');
    });
});

// Ecommerce
$routes->group('ecommerce', static function ($routes) {
    $routes->get('product', function () {
        return view('Admin/ecommerce/product');
    });
    $routes->get('detailed-product-page', function () {
        return view('Admin/ecommerce/product-page');
    });
    $routes->get('detailed-products-list', function () {
        return view('Admin/ecommerce/products-list');
    });
    $routes->get('payment-details', function () {
        return view('Admin/ecommerce/payment-details');
    });
    $routes->get('order-history', function () {
        return view('Admin/ecommerce/order-history');
    });
    $routes->get('invoice-template', function () {
        return view('Admin/ecommerce/invoice-template');
    });
    $routes->get('cart', function () {
        return view('Admin/ecommerce/cart');
    });
    $routes->get('list-wish', function () {
        return view('Admin/ecommerce/list-wish');
    });
    $routes->get('checkout', function () {
        return view('Admin/ecommerce/checkout');
    });
    $routes->get('pricing', function () {
        return view('Admin/ecommerce/pricing');
    });
});

// Email
$routes->group('email', static function ($routes) {
    $routes->get('email-application', function () {
        return view('Admin/email/email-application');
    });
    $routes->get('email-compose', function () {
        return view('Admin/email/email-compose');
    });
});

// Chat
$routes->group('chat', static function ($routes) {
    $routes->get('chat-app', function () {
        return view('Admin/chat/chat');
    });
    $routes->get('video-chat', function () {
        return view('Admin/chat/chat-video');
    });
});

// Users
$routes->group('user', static function ($routes) {
    $routes->get('user-profile', function () {
        return view('Admin/users/user-profile');
    });
    $routes->get('edit-profile', function () {
        return view('Admin/users/edit-profile');
    });
    $routes->get('user-cards', function () {
        return view('Admin/users/user-cards');
    });
});


// Forms

$routes->group('forms', function ($routes) {

    // Forms-Controls  
    $routes->get('form-validation', function () {
        return view('Admin/forms/form-controls/form-validation');
    });
    $routes->get('base-input', function () {
        return view('Admin/forms/form-controls/base-input');
    });
    $routes->get('radio-checkbox-control', function () {
        return view('Admin/forms/form-controls/radio-checkbox-control');
    });
    $routes->get('input-group', function () {
        return view('Admin/forms/form-controls/input-group');
    });
    $routes->get('megaoptions', function () {
        return view('Admin/forms/form-controls/megaoptions');
    });

    // Form Widgets
    $routes->get('datepicker', function () {
        return view('Admin/forms/form-widgets/datepicker');
    });
    $routes->get('time-picker', function () {
        return view('Admin/forms/form-widgets/time-picker');
    });
    $routes->get('datetimepicker', function () {
        return view('Admin/forms/form-widgets/datetimepicker');
    });
    $routes->get('daterangepicker', function () {
        return view('Admin/forms/form-widgets/daterangepicker');
    });
    $routes->get('touchspin', function () {
        return view('Admin/forms/form-widgets/touchspin');
    });
    $routes->get('select2', function () {
        return view('Admin/forms/form-widgets/select2');
    });
    $routes->get('switch', function () {
        return view('Admin/forms/form-widgets/switch');
    });
    $routes->get('typeahead', function () {
        return view('Admin/forms/form-widgets/typeahead');
    });
    $routes->get('clipboard', function () {
        return view('Admin/forms/form-widgets/clipboard');
    });

    // Form Layout
    $routes->get('default-form', function () {
        return view('Admin/forms/form-layout/default-form');
    });
    $routes->get('form-wizard', function () {
        return view('Admin/forms/form-layout/form-wizard');
    });
    $routes->get('second-form-wizard', function () {
        return view('Admin/forms/form-layout/form-wizard-two');
    });
    $routes->get('third-form-wizard', function () {
        return view('Admin/forms/form-layout/form-wizard-three');
    });
});

// Tables 
$routes->group('tables', function ($routes) {

    // Bootstrap Tables
    $routes->get('bootstrap-basic-table', function () {
        return view('Admin/tables/bootstrap-tables/bootstrap-basic-table');
    });
    $routes->get('table-components', function () {
        return view('Admin/tables/bootstrap-tables/table-components');
    });

    // Data Tables
    $routes->get('datatable-basic-init', function () {
        return view('Admin/tables/data-tables/datatable-basic');
    });
    $routes->get('datatable-API', function () {
        return view('Admin/tables/data-tables/datatable-API');
    });
    $routes->get('datatable-data-source', function () {
        return view('Admin/tables/data-tables/datatable-data-source');
    });

    // Ex. Data Tables
    $routes->get('datatable-ext-autofill', function () {
        return view('Admin/tables/ex-data-tables/datatable-ext-autofill');
    });

    // JS Grid Tables
    $routes->get('jsgrid-table', function () {
        return view('Admin/tables/jsgrid-table');
    });
});


// Ui Kits
$routes->group('ui-kits', function ($routes) {
    $routes->get('state-color', function () {
        return view('Admin/ui-kits/state-color');
    });
    $routes->get('typography', function () {
        return view('Admin/ui-kits/typography');
    });
    $routes->get('avatars', function () {
        return view('Admin/ui-kits/avatars');
    });
    $routes->get('helper-classes', function () {
        return view('Admin/ui-kits/helper-classes');
    });
    $routes->get('grid', function () {
        return view('Admin/ui-kits/grid');
    });
    $routes->get('tag-pills', function () {
        return view('Admin/ui-kits/tag-pills');
    });
    $routes->get('progress-bar', function () {
        return view('Admin/ui-kits/progress-bar');
    });
    $routes->get('modal', function () {
        return view('Admin/ui-kits/modal');
    });
    $routes->get('alert', function () {
        return view('Admin/ui-kits/alert');
    });
    $routes->get('popover', function () {
        return view('Admin/ui-kits/popover');
    });
    $routes->get('tooltip', function () {
        return view('Admin/ui-kits/tooltip');
    });
    $routes->get('loader', function () {
        return view('Admin/ui-kits/loader');
    });
    $routes->get('dropdown', function () {
        return view('Admin/ui-kits/dropdown');
    });
    $routes->get('according', function () {
        return view('Admin/ui-kits/according');
    });
    $routes->get('tab-bootstrap', function () {
        return view('Admin/ui-kits/tab/tab-bootstrap');
    });
    $routes->get('tab-material', function () {
        return view('Admin/ui-kits/tab/tab-material');
    });
    $routes->get('box-shadow', function () {
        return view('Admin/ui-kits/box-shadow');
    });
    $routes->get('list', function () {
        return view('Admin/ui-kits/list');
    });
});


// Bonus Ui
$routes->group('Bonus-ui', function ($routes) {
    $routes->get('scrollable', function () {
        return view('Admin/bonus-ui/scrollable');
    });
    $routes->get('tree', function () {
        return view('Admin/bonus-ui/tree');
    });
    $routes->get('bootstrap-notify', function () {
        return view('Admin/bonus-ui/bootstrap-notify');
    });
    $routes->get('rating', function () {
        return view('Admin/bonus-ui/rating');
    });
    $routes->get('dropzone', function () {
        return view('Admin/bonus-ui/dropzone');
    });
    $routes->get('tour', function () {
        return view('Admin/bonus-ui/tour');
    });
    $routes->get('sweet-alert2', function () {
        return view('Admin/bonus-ui/sweet-alert2');
    });
    $routes->get('animated-modal', function () {
        return view('Admin/bonus-ui/modal-animated');
    });
    $routes->get('owl-carousel', function () {
        return view('Admin/bonus-ui/owl-carousel');
    });
    $routes->get('ribbons', function () {
        return view('Admin/bonus-ui/ribbons');
    });
    $routes->get('pagination', function () {
        return view('Admin/bonus-ui/pagination');
    });
    $routes->get('breadcrumb', function () {
        return view('Admin/bonus-ui/breadcrumb');
    });
    $routes->get('range-slider', function () {
        return view('Admin/bonus-ui/range-slider');
    });
    $routes->get('image-cropper', function () {
        return view('Admin/bonus-ui/image-cropper');
    });
    $routes->get('sticky', function () {
        return view('Admin/bonus-ui/sticky');
    });
    $routes->get('basic-card', function () {
        return view('Admin/bonus-ui/basic-card');
    });
    $routes->get('creative-card', function () {
        return view('Admin/bonus-ui/creative-card');
    });
    $routes->get('tabbed-card', function () {
        return view('Admin/bonus-ui/tabbed-card');
    });
    $routes->get('dragable-card', function () {
        return view('Admin/bonus-ui/dragable-card');
    });
    $routes->get('timeline-v-1', function () {
        return view('Admin/bonus-ui/timeline/timeline-v-1');
    });
    $routes->get('timeline-v-2', function () {
        return view('Admin/bonus-ui/timeline/timeline-v-2');
    });
});


// Builders
$routes->group('builders', function ($routes) {
    $routes->get('form-builder-1', function () {
        return view('Admin/builders/form-builder-1');
    });
    $routes->get('form-builder-2', function () {
        return view('Admin/builders/form-builder-2');
    });
    $routes->get('pagebuild', function () {
        return view('Admin/builders/pagebuild');
    });
    $routes->get('button-builder', function () {
        return view('Admin/builders/button-builder');
    });
});


// Animation
$routes->group('animations', function ($routes) {
    $routes->get('animate', function () {
        return view('Admin/animation/animate');
    });
    $routes->get('AOS', function () {
        return view('Admin/animation/AOS');
    });
    $routes->get('scroll-reval', function () {
        return view('Admin/animation/scroll-reval');
    });
    $routes->get('tilt', function () {
        return view('Admin/animation/tilt');
    });
    $routes->get('wow', function () {
        return view('Admin/animation/wow');
    });
});


// Icons
$routes->group('icons', function ($routes) {
    $routes->get('flag-icon', function () {
        return view('Admin/Icons/flag-icon');
    });
    $routes->get('font-awesome', function () {
        return view('Admin/Icons/font-awesome');
    });
    $routes->get('ico-icon', function () {
        return view('Admin/Icons/ico-icon');
    });
    $routes->get('themify-icon', function () {
        return view('Admin/Icons/themify-icon');
    });
    $routes->get('whether-icon', function () {
        return view('Admin/Icons/whether-icon');
    });
    $routes->get('feather-icon', function () {
        return view('Admin/Icons/feather-icon');
    });
});


// Buttons
$routes->group('buttons', function ($routes) {
    $routes->get('default-buttons', function () {
        return view('Admin/buttons/buttons-default');
    });
    $routes->get('flat-buttons', function () {
        return view('Admin/buttons/buttons-flat');
    });
    $routes->get('edge-buttons', function () {
        return view('Admin/buttons/buttons-edge');
    });
    $routes->get('raised-button', function () {
        return view('Admin/buttons/raised-button');
    });
    $routes->get('group-button', function () {
        return view('Admin/buttons/button-group');
    });
});


// Charts
$routes->group('charts', function ($routes) {
    $routes->get('echarts', function () {
        return view('Admin/charts/echarts');
    });
    $routes->get('chart-apex', function () {
        return view('Admin/charts/chart-apex');
    });
    $routes->get('chart-google', function () {
        return view('Admin/charts/chart-google');
    });
    $routes->get('chart-sparkline', function () {
        return view('Admin/charts/chart-sparkline');
    });
    $routes->get('chart-flot', function () {
        return view('Admin/charts/chart-flot');
    });
    $routes->get('chart-knob', function () {
        return view('Admin/charts/chart-knob');
    });
    $routes->get('chart-morris', function () {
        return view('Admin/charts/chart-morris');
    });
    $routes->get('chartjs', function () {
        return view('Admin/charts/chartjs');
    });
    $routes->get('chartist', function () {
        return view('Admin/charts/chartist');
    });
    $routes->get('chart-peity', function () {
        return view('Admin/charts/chart-peity');
    });
});

// Others

// Error-Pages
$routes->group('error-pages', function ($routes) {
    $routes->get('error-400', function () {
        return view('Admin/others/error-page/error-400');
    });
    $routes->get('error-401', function () {
        return view('Admin/others/error-page/error-401');
    });
    $routes->get('error-403', function () {
        return view('Admin/others/error-page/error-403');
    });
    $routes->get('error-404', function () {
        return view('Admin/others/error-page/error-404');
    });
    $routes->get('error-500', function () {
        return view('Admin/others/error-page/error-500');
    });
    $routes->get('error-503', function () {
        return view('Admin/others/error-page/error-503');
    });
});


// Authentication
$routes->group('authentications', function ($routes) {
    $routes->get('login', function () {
        return view('Admin/others/authentication/login');
    });
    $routes->get('login_one', function () {
        return view('Admin/others/authentication/login_one');
    });
    $routes->get('login_two', function () {
        return view('Admin/others/authentication/login_two');
    });
    $routes->get('login-bs-validation', function () {
        return view('Admin/others/authentication/login-bs-validation');
    });
    $routes->get('login-bs-tt-validation', function () {
        return view('Admin/others/authentication/login-bs-tt-validation');
    });
    $routes->get('login-sa-validation', function () {
        return view('Admin/others/authentication/login-sa-validation');
    });
    $routes->get('sign-up', function () {
        return view('Admin/others/authentication/sign-up');
    });
    $routes->get('sign-up-one', function () {
        return view('Admin/others/authentication/sign-up-one');
    });
    $routes->get('sign-up-two', function () {
        return view('Admin/others/authentication/sign-up-two');
    });
    $routes->get('sign-up-wizard', function () {
        return view('Admin/others/authentication/sign-up-wizard');
    });
    $routes->get('unlock', function () {
        return view('Admin/others/authentication/unlock');
    });
    $routes->get('reset-password', function () {
        return view('Admin/others/authentication/reset-password');
    });
    $routes->get('maintenance', function () {
        return view('Admin/others/authentication/maintenance');
    });
    $routes->get('forget-password', function () {
        return view('Admin/others/authentication/forget-password');
    });
});

// Comming-soon
$routes->group('comming-soons', function ($routes) {
    $routes->get('comingsoon', function () {
        return view('Admin/others/coming-soon/comingsoon');
    });
    $routes->get('comingsoon-bg-img', function () {
        return view('Admin/others/coming-soon/comingsoon-bg-img');
    });
    $routes->get('comingsoon-bg-video', function () {
        return view('Admin/others/coming-soon/comingsoon-bg-video');
    });
});


// Email templates
$routes->group('email-templates', function ($routes) {
    $routes->get('basic-template', function () {
        return view('Admin/others/email-templates/basic-template');
    });
    $routes->get('ecommerce-templates', function () {
        return view('Admin/others/email-templates/ecommerce-templates');
    });
    $routes->get('email-header', function () {
        return view('Admin/others/email-templates/email-header');
    });
    $routes->get('email-order-success', function () {
        return view('Admin/others/email-templates/email-order-success');
    });
    $routes->get('basic-template', function () {
        return view('Admin/others/email-templates/basic-template');
    });
    $routes->get('template-email', function () {
        return view('Admin/others/email-templates/template-email');
    });
    $routes->get('template-email-2', function () {
        return view('Admin/others/email-templates/template-email-2');
    });
});


// Gallery
$routes->group('Gallery', function ($routes) {
    $routes->get('gallery', function () {
        return view('Admin/gallery/gallery');
    });
    $routes->get('description-gallery', function () {
        return view('Admin/gallery/gallery-with-description');
    });
    $routes->get('masonry-gallery', function () {
        return view('Admin/gallery/gallery-masonry');
    });
    $routes->get('gallery-hover', function () {
        return view('Admin/gallery/gallery-hover');
    });
    $routes->get('description-masonry-gallery', function () {
        return view('Admin/gallery/masonry-gallery-with-disc');
    });
});

// Blog
$routes->group('blog', function ($routes) {
    $routes->get('blog-details', function () {
        return view('Admin/Blog/blog');
    });
    $routes->get('single-blog', function () {
        return view('Admin/Blog/blog-single');
    });
    $routes->get('add-post', function () {
        return view('Admin/Blog/add-post');
    });
});

// Job Search
$routes->group('job-search', function ($routes) {
    $routes->get('job-cards-view', function () {
        return view('Admin/job-search/job-cards-view');
    });
    $routes->get('job-list-view', function () {
        return view('Admin/job-search/job-list-view');
    });
    $routes->get('job-details', function () {
        return view('Admin/job-search/job-details');
    });
    $routes->get('job-apply', function () {
        return view('Admin/job-search/job-apply');
    });
});

// Learning
$routes->group('learning', function ($routes) {
    $routes->get('learning-list-view', function () {
        return view('Admin/learning/learning-list-view');
    });
    $routes->get('learning-detailed', function () {
        return view('Admin/learning/learning-detailed');
    });
});

// Maps  
$routes->group('map', function ($routes) {
    $routes->get('map-js', function () {
        return view('Admin/Maps/map-js');
    });
    $routes->get('vector-map', function () {
        return view('Admin/Maps/vector-map');
    });
});

// Editors
$routes->group('editors', function ($routes) {
    $routes->get('summernote', function () {
        return view('Admin/editors/summernote');
    });
    $routes->get('ckeditor', function () {
        return view('Admin/editors/ckeditor');
    });
    $routes->get('simple-MDE', function () {
        return view('Admin/editors/simple-MDE');
    });
    $routes->get('ace-code-editor', function () {
        return view('Admin/editors/ace-code-editor');
    });
});



// File Manager
$routes->get('file-manager', function () {
    return view('Admin/file-manager');
});

// Kanban Board
$routes->get('kanban', function () {
    return view('Admin/kanban');
});

// Bookmark
$routes->get('bookmark', function () {
    return view('Admin/bookmark');
});

// Contacts
$routes->get('contacts', function () {
    return view('Admin/contacts');
});

// Task
$routes->get('task', function () {
    return view('Admin/task');
});

// Calendar-Basic
$routes->get('calendar-basic', function () {
    return view('Admin/calendar-basic');
});

// Social-App
$routes->get('social-app', function () {
    return view('Admin/social-app');
});

// To-do
$routes->get('to-do', function () {
    return view('Admin/to-do');
});

// Search
$routes->get('search', function () {
    return view('Admin/search');
});

// Sample Page
$routes->get('sample-page', function () {
    return view('Admin/sample-page');
});

// Internationalization
$routes->get('internationalization', function () {
    return view('Admin/internationalization');
});

// FAQ
$routes->get('faq', function () {
    return view('Admin/faq');
});

// Knowledgebase
$routes->get('knowledgebase', function () {
    return view('Admin/knowledgebase');
});

// Support Ticket
$routes->get('support-ticket', function () {
    return view('Admin/support-ticket');
});

// Admin unique-layout
$routes->group('layouts', function ($routes) {
    $routes->get('advance-type', function () {
        return view('Admin/admin_unique_layouts/advance-type');
    });
    $routes->get('box-layout', function () {
        return view('Admin/admin_unique_layouts/box-layout');
    });
    $routes->get('color-sidebar', function () {
        return view('Admin/admin_unique_layouts/color-sidebar');
    });
    $routes->get('compact-sidebar', function () {
        return view('Admin/admin_unique_layouts/compact-sidebar');
    });
    $routes->get('compact-small', function () {
        return view('Admin/admin_unique_layouts/compact-small');
    });
    $routes->get('compact-wrap', function () {
        return view('Admin/admin_unique_layouts/compact-wrap');
    });
    $routes->get('dark-sidebar', function () {
        return view('Admin/admin_unique_layouts/dark-sidebar');
    });
    $routes->get('default-body', function () {
        return view('Admin/admin_unique_layouts/default-body');
    });
    $routes->get('enterprice-type', function () {
        return view('Admin/admin_unique_layouts/enterprice-type');
    });
    $routes->get('material-icon', function () {
        return view('Admin/admin_unique_layouts/material-icon');
    });
    $routes->get('material-layout', function () {
        return view('Admin/admin_unique_layouts/material-layout');
    });
    $routes->get('modern-layout', function () {
        return view('Admin/admin_unique_layouts/modern-layout');
    });
});
