<?php
namespace OShop\Controllers;

use OShop\Models\Brand;
use OShop\Models\Product;
use OShop\Models\Type;
use OShop\Models\Category;

class CoreController
{

    protected function show($viewName, $viewVars = [])
    {

        // attention pas propre ! PHP va chercher la variable $router dans l'espace global
        global $router;

        // transformation des indexes du tableau $viewVars en tant que varibles
        $viewVars['baseURI'] = $_SERVER['BASE_URI'];
        extract($viewVars);

        // récupération des 5 marques qui doivent remonter dans le footer
        $brandModel = new Brand();
        // la variable $brandsForFooter est désormais disponible dans toutes nos vues (templates)
        $brandsForFooter = $brandModel->findAllForFooter();

        // récupération des types qui doivent remonter dans le footer
        $typeModel = new Type();
        $typesForFooter = $typeModel->findAllForFooter();



        require __DIR__ . '/../views/partials/header.tpl.php';
        require __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require __DIR__ . '/../views/partials/footer.tpl.php';
    }
}