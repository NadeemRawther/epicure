<?php 
namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Epicureser1');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/','Home::index');
$routes->add('login','Epicureser1::login');
$routes->add('gettopratingfoods','Epicureser1::gettopratingfoods');
$routes->add('gettopratingcooks','Epicureser1::gettopratingcooks');
$routes->add('getserchedcookstoprating','Epicureser1::getserchedcookstoprating');
$routes->add('getserchedfoodstoprating','Epicureser1::getserchedfoodstoprating');
$routes->add('getsplashvidurl','Epicureser1::getsplashvidurl');
$routes->add('signup', 'Epicureser1::signup');
$routes->add('confirmotp','Epicureser1::confirmotp');
$routes->add('addusercomp','Epicureser1::addusercomp');
$routes->add('gettopratingcooksoftheweek','Epicureser1::createthisweekstopcooks');
$routes->add('gettopratingVegfoods','Epicureser1::gettopratingVegfoods');
$routes->add('getfooddetails','Epicureser1::getfooddetails');
$routes->add('adduserrecipe','Epicureser1::adduserrecipe');
$routes->add('getmyrecipes','Epicureser1::getmyrecipes');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
