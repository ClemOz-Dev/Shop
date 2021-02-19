<?php
namespace OShop\Controllers;
use OShop\Models\Brand;
use OShop\Models\Product;
use OShop\Models\Type;
use OShop\Models\Category;


class MainController extends CoreController
{
    // méthode pour afficher la home page
    public function home()
    {

        $categoryModel = new Category();
        $categories = $categoryModel->findAllForHome();

        $viewVars = [
            'categories' => $categories
        ];

        $this->show('home', $viewVars);
    }

    public function legalNotice()
    {
        $this->show('legal-notice');
    }

}
