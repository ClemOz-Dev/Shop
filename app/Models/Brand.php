<?php
namespace OShop\Models;
use OShop\Utils\Database;
use PDO;


// la classe Brand est un enfant de la classe CoreModel
class Brand extends CoreModel
{
    // Nous n'avons plus besoin de ces propriétés, elles sont "Héritées" de la classe parente CoreModel
    // private $id;
    // private $name;
    // private $created_at;
    // private $updated_at;
    private $footer_order;


    // remonte les marques qui doivent s'afficher dans le footer
    public function findAllForFooter()
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT * FROM `brand`
            WHERE `footer_order` > 0
            ORDER BY `footer_order` ASC
        ";

        $statement = $pdo->query($sql);
        $brands = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $brands;

    }

    // méthode nous permettant de récupérer UNE marque via son id
    public  function find($id)
    {
        // étape 1 récupération d'un objet pdo
        $pdo = Database::getPDO();

        // étape 2 écriture de la  requête
        $sql = "
            SELECT * FROM `brand`
            WHERE `id`={$id};
        ";

        // étape 3 execution de la requête et récupération du résultat dans  un "PDOStatement"
        $statement = $pdo->query($sql);

        // étape 4 récupération, de LA ligne de résultat sous forme d'objet Brand
        $brand = $statement->fetchObject(static::class);

        return $brand;
    }

    // fonction permettant de récupérer tous les objets de la table product
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT
                *
            FROM `brand`
        ";

        $statement = $pdo->query($sql);
        $brands = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $brands;
    }


    /**
     * Get the value of footer_order
     */ 
    public function getFooterOrder()
    {
        return $this->footer_order;
    }

    /**
     * Set the value of footer_order
     *
     * @return  self
     */ 
    public function setFooterOrder($footer_order)
    {
        $this->footer_order = $footer_order;

        return $this;
    }
}
