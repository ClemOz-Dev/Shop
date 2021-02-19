<?php
namespace OShop\Models;
use OShop\Utils\Database;
use PDO;

class Category extends CoreModel
{
    // private $id;
    // private $name;
    // private $created_at;
    // private $updated_at;

    private $subtitle;
    private $picture;
    private $home_order;



    public function findAllForHome()
    {
        $pdo = Database::getPDO();

        $sql = "
            SELECT * FROM `category`
            WHERE `home_order` > 0
            ORDER BY `home_order` ASC
        ";

        $statement = $pdo->query($sql);
        $categories = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $categories;
    }


    // fonction permettant de récupérer tous les objets de la table product
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT
                *
            FROM `category`
        ";

        $statement = $pdo->query($sql);
        $categories = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $categories;
    }


    // cette méthode va nous permettre de récupérer un object Category grace à son id
    public function find($id)
    {
        // récupération d'un objet PDO qui va nous permettre de travailler avec la base de donnée

        $pdo = Database::getPDO();  //<- syntaxe arbitraire ; c'est codé comme ça

        // requête sql pour récupérer une categorie grace à son ID

        $sql = "
            SELECT
                *
            FROM `category`
            WHERE id={$id}
        ;";

        // execution de la requête et récupération du "résultat" dans un objet $statement (PDOStatement)
        $statement = $pdo->query($sql);

        // récupération de la ligne de résultats sous forme d'une objet Category
        $category = $statement->fetchObject(static::class);

        // on retourne l'objet (de type Category)
        return $category;
    }

    /**
     * Get the value of subtitle
     */ 
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     *
     * @return  self
     */ 
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

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
     * Get the value of home_order
     */ 
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     *
     * @return  self
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;

        return $this;
    }
}
