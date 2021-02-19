<?php
namespace OShop\Controllers;

class TestController  extends CoreController
{
    public function findBrand($parameters)
    {
        dump($parameters);

        $brandId = $parameters['brandId'];
        $brandModel = new Brand();
        $brand = $brandModel->find($brandId);
        dump($brand);
    }

    public function allBrand()
    {
        $brandModel = new Brand();
        $brands = $brandModel->findAll();
        dump($brands);
    }


    public function brandForFooter()
    {
        // instanciation d'un objet Brand du modèle
        $brandModel = new Brand();
        $brands = $brandModel->findAllForFooter();
        dump($brands);
    }
}