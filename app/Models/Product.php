<?php
namespace OShop\Models;
use OShop\Utils\Database;
use PDO;

class Product extends CoreModel
{
    // private $id;
    // private $name;
    // private $created_at;
    // private $updated_at;

    private $description;
    private $picture;
    private $price;
    private $rate;
    private $status;
    private $brand_id;
    private $category_id;
    private $type_id;





    // cette méthode va nous permettre de récupérer un object Product grace à son id
    public function find($id)
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT
                *
            FROM `product`
            WHERE id={$id}
        ;";

        $statement = $pdo->query($sql);

        $product = $statement->fetchObject(static::class);
        return $product;
    }

    // cette méthode va nous retourner l'objet OShop\Models\Category correspondant au produit
    public function getCategory()
    {
        // utilisation du Model category
        $categoryModel = new Category();
        // on demande au model Category de nous retourner la catégorie correspondant à l'id du produit "courrant"

        $productCategory = $categoryModel->find(
            $this->getCategoryId()
        );
        return $productCategory;
    }


    // fonction permettant de récupérer tous les objets de la table product
    public function findAll()
    {
        //récupértion d'un objet PDO
        $pdo = Database::getPDO();

        $sql = "
            SELECT
                *
            FROM `product`
        ";

        // Execution de la requête SQL
        $statement = $pdo->query($sql);

        // syntaxe pour récupérer les résultats sous forme d'un tableau d'objets
        // premier argument PDO::FETCH_CLASS =>  nous demandons de nous renvoyer les résultats sous forme d'objet
        // second argument : 'Product' => quel type type nous souhaitons avoir
        // DOC : https://www.php.net/manual/en/pdostatement.fetchall.php
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);

        // on retourne la liste des produits
        return $products;
    }

    // récupération de tous les produits pour un type donnée
    public function findAllInType($idType)
    {
        //récupértion d'un objet PDO
        $pdo = Database::getPDO();

        $sql = "
            SELECT
                *
            FROM `product`
            WHERE
                `type_id` = {$idType}
        ";

        $statement = $pdo->query($sql);
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }


    // récupération de tous les produits pour une marque donnée
    public function findAllInBrand($idBrand)
    {
        //récupértion d'un objet PDO
        $pdo = Database::getPDO();

        $sql = "
            SELECT
                *
            FROM `product`
            WHERE
                `brand_id` = {$idBrand}
        ";

        $statement = $pdo->query($sql);
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }


    // récupération de tous les produits pour une catégorie donnée
    public function findAllInCategory($idCategory)
    {
        //récupértion d'un objet PDO
        $pdo = Database::getPDO();

        $sql = "
            SELECT
                *
            FROM `product`
            WHERE
                `category_id` = {$idCategory}
        ";

        $statement = $pdo->query($sql);
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }


    // cette méthode va retourner l'objet Brand correspondant au produit
    // C'EST UN OBJET QUE L'ON RETOURNE
    /**
     * @return Brand
     */
    public function getBrand()
    {
        $brandModel = new Brand();
        $brand = $brandModel->find(
            $this->getBrandId()
        );
        return $brand;
    }



    //BONUS !!!=========================================================

    public function findAllLessThan($maximumPrice)
    {
        $pdo = Database::getPDO();

        $sql = "
            SELECT
                *
            FROM `product`
            WHERE `price` < {$maximumPrice}
        ";

        $statement = $pdo->query($sql);

        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }


    public function searchInName($searchedWord)
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT
                *
            FROM `product`
            WHERE
                `name` LIKE '%{$searchedWord}%'
        "; // le '%' signifie "nimporte quelle chaine de caractère"

        $statement = $pdo->query($sql);
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }


    public function search($searchedWord)
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT
                -- selectionne tous les champs de la table product
                `product`.*
            FROM `product`
            INNER JOIN `category`
                ON `category`.`id` = `product`.`category_id`
            INNER JOIN `brand`
                ON `brand`.`id` = `product`.`brand_id`
            LEFT JOIN `type`
                ON `type`.`id` = `product`.`type_id`
            WHERE
                `product`.`name` LIKE '%{$searchedWord}%'
                OR `product`.`description` LIKE '%{$searchedWord}%'
                OR `category`.`name` LIKE '%{$searchedWord}%'
                OR `brand`.`name` LIKE '%{$searchedWord}%'
                OR `type`.`name` LIKE '%{$searchedWord}%'
        "; // le '%' signifie "nimporte quelle chaine de caractère"

        $statement = $pdo->query($sql);
        $products = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $products;
    }



    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @return  self
     */ 
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of brand_id
     */ 
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */ 
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of category_id
     */ 
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of type_id
     */ 
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @return  self
     */ 
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}