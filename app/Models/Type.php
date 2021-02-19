<?php
namespace OShop\Models;
use OShop\Utils\Database;

class Type extends CoreModel
{
    // private $id;
    // private $name;
    // private $created_at;
    // private $updated_at;

    private $footer_order;




    // méthode nous permettant de récupérer UN type via son id
    public  function find($id)
    {
        // étape 1 récupération d'un objet pdo
        $pdo = Database::getPDO();

        // étape 2 écriture de la  requête
        $sql = "
            SELECT * FROM `type`
            WHERE `id`={$id};
        ";

        // étape 3 execution de la requête et récupération du résultat dans  un "PDOStatement"
        $statement = $pdo->query($sql);

        // étape 4 récupération, de LA ligne de résultat sous forme d'objet Type
        $type = $statement->fetchObject(static::class);
        return $type;
        
    }




    // fonction nous retournant la liste des types qui doivent remonter dans le footer
    public function findAllForFooter()
    {
        $pdo = Database::getPDO();

        $sql = "
            SELECT * FROM `type`
            WHERE `footer_order` > 0
            ORDER BY `footer_order` ASC
        ";

        $statement = $pdo->query($sql);

        // il est possible de récupérer le nom de la classe dans un objet en utilisant static::class

        $types = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
        return $types;
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
