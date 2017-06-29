<?php

use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Events\Manager as EventsManager;

/**
 * FactoryDefault es un inyector de dependencias que registra automáticamente los servicios que se utilizarán
 */
$di = new FactoryDefault();

/**
 * El componente URL es usado para generar las URLs de la aplicación
 */
$di->set('url', function() use ($config){
	$url = new UrlProvider();
	$url->setBaseUri($config->application->baseUri);
	return $url;
});

/**
 * El componente config
 */
$di->set('config', function() use ($config){
	return $config;
});

/**
 * Generación de vistas con plantillas volt
 */
$di->set('view', function() use ($config) {

	$view = new View();

	$view->setViewsDir(APP_PATH . $config->application->viewsDir);

	$view->registerEngines(array(
		".volt" => 'volt'
	));

	return $view;
});

/**
 * Configuración de volt
 */
$di->set('volt', function($view, $di) {

	$volt = new VoltEngine($view, $di);

	$volt->setOptions(array(
		"compiledPath" => APP_PATH . "cache/volt/"
	));

	$compiler = $volt->getCompiler();
	$compiler->addFunction('is_a', 'is_a');

	return $volt;
}, true);

/**
 * Componente de base de datos basado en el config.ini
 */
$di->set('db', function() use ($config) {
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	return new $dbclass(array(
		"host"     => $config->database->host,
		"username" => $config->database->username,
		"password" => $config->database->password,
		"dbname"   => $config->database->dbname,
		"charset"  => $config->database->charset
	));
});

/**
 * Componente de base de datos basado para conectar a delfi
 */
$di->set('db_delfi', function() use ($config) {
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	return new $dbclass(array(
		"host"     => $config->database->host,
		"username" => $config->database->username,
		"password" => $config->database->password,
		"dbname"   => "bddelfi_2017",
		"charset"  => $config->database->charset
	));
});

$di->set('modelsManager', function() {
	return new Phalcon\Mvc\Model\Manager();
});

/**
 * Se activa si está especificado en la configuración utilizar el adaptador metadata
 */
$di->set('modelsMetadata', function() {
	return new MetaData();
});

/**
 * Inicia la sesión con la primera vez que un componente solicita el servicio de sesión (session)
 */
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

/**
 * Registro del servicio de alertas (flash) con clasess CSS personalizadas
 */
$di->set('flash', function(){
	return new FlashSession(array(
		'error'   => 'alert alert-danger',
		'success' => 'alert alert-success',
		'notice'  => 'alert alert-info',
	));
});

/**
 * Registro del componente elements, ubicado en library, para generación de menús y elementos UI
 */
$di->set('elements', function(){
	return new Elements();
});
/**
 * We register the events manager
 */
$di->set('dispatcher', function() use ($di) {
	$eventsManager = new EventsManager;
	/**
	 * Check if the user is allowed to access certain action using the SecurityPlugin
	 */
	$eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);
	/**
	 * Handle exceptions and not-found exceptions using NotFoundPlugin
	 */
	//$eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);
	$dispatcher = new Dispatcher;
	$dispatcher->setEventsManager($eventsManager);
	return $dispatcher;
});

/**
 * Registro del componente conversiones, ubicado en library
 */
$di->set('conversiones', function(){
	return new Conversiones();
});

/**
 * Register del componente phpexcel, ubicado en library
 */
$di->set('phpexcel', function(){
	return new PHPExcel();
});

/**
 * Mail service
 */
$di->set('mail', function () {
	return new Mail();
});
