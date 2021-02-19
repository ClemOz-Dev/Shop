<?php
namespace OShop\Controllers;
use OShop\Models\Brand;
use OShop\Models\Product;
use OShop\Models\Type;
use OShop\Models\Category;

class CatalogController extends CoreController
{


    // méthode pour afficher la page de category
    public function category($capturedByAltoRouterVariables)
    {

        // récupération de l'id de la catégorie que l'on doit afficher
        $idCategory = $capturedByAltoRouterVariables['idCategory'];

        // instantiation  d'un objet du du model Category pour pouvoir récupérer des informations depuis la base de données
        $categoryModel = new Category();

        // test de la  méthode finAll de l'objet Category
        // $allCategories = $categoryModel->findAll();

        // récupération de la catégorie grace à son id
        $category = $categoryModel->find($idCategory);

        // récupération de tous les produits
        // instanciation d'une classe de la couche modèle (la couche qui s'occupe des accès à la base de donnée)
        $productModel = new Product();

        // test méthode find find sur product
        // $product = $productModel ->find(2);

        $products = $productModel->findAllInCategory($idCategory);

        $viewVars = [
            'idCategory' => $capturedByAltoRouterVariables['idCategory'],
            'category' => $category, // $category est un objet Category
            'products' => $products,
        ];

        $this->show('category', $viewVars);
    }


    public function brand($parameters)
    {

        $idBrand = $parameters['idBrand'];
        $productModel = new Product();
        $products = $productModel->findAllInBrand($idBrand);

        // récupération de la marque
        $brandModel = new Brand();
        $brand = $brandModel->find($idBrand);

        $viewVars = [
            'idBrand' => $parameters['idBrand'],
            'products' => $products,
            'brand' => $brand,
        ];

        $this->show('brand', $viewVars);
    }

    public function type($parameters)
    {

        $idType = $parameters['idType'];
        $typeModel = new Type();
        $type = $typeModel->find($idType);

        $productModel = new Product();
        $products = $productModel->findAllInType($idType);


        $viewVars = [
            'idType' => $parameters['idType'],
            'type' => $type,
            'products' => $products,
        ];

        $this->show('type', $viewVars);
    }


    public function product($parameters)
    {
        // instanciation d'un model
        $productModel = new Product();
        // récupération du produit sélectionné

        $product = $productModel->find($parameters['idProduct']);

        $viewVars = [
            'idProduct' => $parameters['idProduct'],
            'product' => $product
        ];


        $this->show('product', $viewVars);
    }

    //===========================================================
    // Methodes bonus
    public function productLessThan($parameters)
    {

        $productModel = new Product();
        $products = $productModel->findAllLessThan($parameters['maximumPrice']);

        $viewVars = [
            'maximumPrice' => $parameters['maximumPrice'],
            'products' => $products
        ];

        $this->show('product-less-than', $viewVars);
    }

    public function search()
    {
        $searchedWord = filter_input(INPUT_GET, 'search');
        // il faut demander à notre "fournisseur" (la couche modèle) de nous renvoyer les produits dont le nom contient le termer recherché

        // on instancie la classe du modèle
        $productModel = new Product();
        $products = $productModel->search($searchedWord);

        $viewVars = [
            'searchedWord' => $searchedWord,
            'products' => $products
        ];

        $this->show('search', $viewVars);
    }


    public function searchExemple($parameters)
    {
        $searchedWord = $parameters['searchedWord'];
        // il faut demander à notre "fournisseur" (la couche modèle) de nous renvoyer les produits dont le nom contient le termer recherché

        // on instancie la classe du modèle
        $productModel = new Product();
        $products = $productModel->searchInName($searchedWord);

        $viewVars = [
            'searchedWord' => $searchedWord,
            'products' => $products
        ];

        $this->show('search', $viewVars);
    }

}
