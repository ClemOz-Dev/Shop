<?php

// inclusion des bibliothèques gérées par composer
require __DIR__ . '/../vendor/autoload.php';



// récupération de la variable "_url"  dans les varibles GET
// le fichier .htaccess nous "transforme" l'url demandée en variable GET : ceci va vous permettre de pouvoir selectionner la page à afficher
$url = filter_input(INPUT_GET, '_url');

// gérons le cas où $url est vide (car qui arrive lorsque nous sommes sur la home page)
// si $url est vide ; nous donnons arbitrairement la valeur "/" à $url
if($url == '') {
    $url = '/';
}

// instanciation d'un nouvel nouvel AltoRouter;
$router = new AltoRouter();

// récupération dans la super globale $_SERVER de la valeur 'BASE_URI' qui stocke la racine de l'url du site web
// Attention BASE_URI n'est pas toujours disponible en fonction des configurations d'apache (ici c'est le fichier .htaccess qui gère ceci)
$baseURI = $_SERVER['BASE_URI'];

// il faut que nous disions à altoRouter quelle est "l'url racine" du site web
$router->setBasePath($baseURI);

//création d'une route pour la home ;  il faut utiliser la méthode map d'altorouter pour configurer une route

$router->map(
    'GET', // il faut choisir la méthode qui est utilisée pour appeler la page
    '/', // quel est l'url à surveiller (à partir de la racine du site configurée auparavant)
    [
        'controllerName' => 'MainController', // quel controller doit être instancicié si la route est valide
        'actionName' => 'home' // quelle méthode il faut appeler si la route est valide
    ],
    'main-home'  // nom de la route (ça nous permettra de gérer ultérieurement des trucs cools)
);

$router->map(
    'GET',
    '/legal-notice',
    [
        'controllerName' => 'MainController',
        'actionName' => 'legalNotice'
    ],
    'main-legalNotice'
);

//===========================================================
// Routes du catalogue

// configuration de la route pour les categories
$router->map(
    'GET',
    // configuration de la route "variable"
    // entre [] , nous configurons la la partie variable de l'url
    // i: signifie que nous voulons avoir un nombre (int) dans l'url
    // id, est la clé qui dans laquelle sera stocké le nombre capturé dans l'url
    '/catalog/category/[i:idCategory]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'category'
    ],
    'catalog-category'
);

$router->map(
    'GET',
    '/catalog/brand/[i:idBrand]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'brand'
    ],
    'catalog-brand'
);

$router->map(
    'GET',
    '/catalog/type/[i:idType]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'type'
    ],
    'catalog-type'
);

$router->map(
    'GET',
    '/catalog/product/[i:idProduct]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'product'
    ],
    'catalog-product'
);



$router->map(
    'GET',
    // [a:nomVariable]  ; le a: est pour dire "n'importe quel type"
    // https://altorouter.com/usage/mapping-routes.html
    '/catalog/search',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'search'
    ],
    'catalog-search'
);


$router->map(
    'GET',
    // [a:nomVariable]  ; le a: est pour dire "n'importe quel type"
    // https://altorouter.com/usage/mapping-routes.html
    '/catalog/search/[a:searchedWord]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'searchExemple'
    ],
    'catalog-search-exemple'
);



// ===========================================================
// Routes pour tester
$router->map(
    'GET',
    '/test/find-brand/[i:brandId]',
    [
        'controllerName' => 'TestController',
        'actionName' => 'findBrand'
    ],
    'test-find-brand'
);

$router->map(
    'GET',
    '/test/all-brand',
    [
        'controllerName' => 'TestController',
        'actionName' => 'allBrand'
    ],
    'test-all-brand'
);

$router->map(
    'GET',
    '/test/brand-for-footer',
    [
        'controllerName' => 'TestController',
        'actionName' => 'brandForFooter'
    ],
    'test-brand-for-footer'
);


$router->map(
    'GET',
    '/test/hello-world',
    [
        'controllerName' => 'DemoController',
        'actionName' => 'helloWorld'
    ],
    'test-hello-world'
);




//===========================================================
//Routes bonus
$router->map(
    'GET',
    '/catalog/product-less-than/[i:maximumPrice]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'productLessThan'
    ],
    'catalog-product-less-than'
);


$router->map(
    'GET',
    '/catalog/product-between/[i:minimumPrice]/[i:maximumPrice]',
    [
        'controllerName' => 'CatalogController',
        'actionName' => 'productLessThan'
    ],
    'catalog-product-between'
);

//===========================================================



// demandons à altorouter de "gérer" le routing ("que dois je faire" en fonction de l'url demandée par le visiteur)

$match = $router->match();

//xdebug_break();

// si match ne vaut pas false ; ceci signifie qu'une route correspond (match) à l'url demandée
if($match !== false) {

    // dans l'index 'target' (arbitraire, fourni par altorouter), nous retrouvons la configuration que l'on avait définie pour la route courrante
    $routeData = $match['target'];

    $controllerName = 'OShop\Controllers\\'. $routeData['controllerName'];

    // instanciation d'un objet du type demandé (le type demandé est stocké dans la variable $controllerName)
    $controller = new $controllerName();

    // récupération du nom de la méthode à appeller
    $methodName = $routeData['actionName'];


    // récupération des variables capturées dans l'url par altorouter
    // $match['params'] est un peu comme $_GET
    $variables = $match['params'];

    // appel de la méthode "dynamiquement"
    // pour la home page c'est comme si nous faisions $controller->home();
    $controller->$methodName($variables);
}
else {
    echo "TODO page 404";
    echo __FILE__.':'.__LINE__; exit();
}

/*
// déclarons un tableau de configuration qui pour chaque url demandée par le visiteur, fait correspondre un nom de controlleur à instancier, et un nom de méthode à appeler

$routes = [

    // lorsque le visiteur demande la home page ($url vaut alors "/")
    // nous allons instancier un objet MainController puis appeler la méthode  home()
    '/' => [
        'controllerName' => 'MainController',
        'methodName' => 'home'
    ],
    '/category' => [
        'controllerName' => 'CatalogController',
        'methodName' => 'category'
    ],
];

// nous voulons vérifier si l'url demandée par le visiteur existe dans notre tableau de configuration
if(isset($routes[$url])) {
    // récupération des informations pour l'url demandée
    $routeData = $routes[$url];

    $controllerName = $routeData['controllerName'];

    // instanciation d'un objet du type demandé (le type demandé est stocké dans la variable $controllerName)
    $controller = new $controllerName();

    // récupération du nom de la méthode à appeller
    $methodName = $routeData['methodName'];

    // appel de la méthode "dynamiquement"
    // pour la home page c'est comme si nous faisions $controller->home();
    $controller->$methodName();
}
else {
    echo 'GERER LA PAGE 404';
    echo __FILE__.':'.__LINE__; exit();
}
*/

