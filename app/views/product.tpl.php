  <section class="hero">
    <div class="container">
      <!-- Breadcrumbs -->
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <?php
          $category = $product->getCategory();
          $url = $router->generate(
            'catalog-category',
            [
              'idCategory' => $category->getId()
            ]
            );
        ?>
        &nbsp;/&nbsp; <a href="<?=$url;?>">
        <li class="breadcrumb-item active"><?=$category->getName();?></li></a>
      </ol>
    </div>
  </section>

  <section class="products-grid">
    <div class="container-fluid">

      <div class="row">
        <!-- product-->
        <div class="col-lg-6 col-sm-12">
          <div class="product-image">
            <a href="detail.html" class="product-hover-overlay-link">
              <img src="<?=$baseURI;?>/<?=$product->getPicture();?>" alt="product" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12">
          <div class="mb-3">
            <h3 class="h3 text-uppercase mb-1"><?=$product->getName();?></h3>
            <div class="text-muted">by <em>
              <?php
                $brandObject = $product->getBrand();
                // génération du lien pointant vers la page brand
                $url = $router->generate(
                  'catalog-brand',
                  [
                    'idBrand' => $brandObject->getId()
                  ]
                );

                echo '<a href="' . $url . '">';
                  echo $brandObject->getName();
                echo '</a>';
              ?>
            </em></div>
            <div>
              <?php
                $rate = $product->getRate();

                // affichage des étoiles "pleines" qui correspondent à la note
                for($i = 0; $i < $rate ; $i++) {
                  echo '<i class="fa fa-star"></i> ';
                }

                // calcul du nombre d'étoiles vide à récupérer
                $emptyStarNumber = 5 - $rate;
                // affichage des étoiles vides
                for($i = 0; $i < $emptyStarNumber ; $i++) {
                  echo '<i class="fa fa-star-o"></i> ';
                }
              ?>

            </div>
          </div>
          <div class="my-2">
            <div class="text-muted"><span class="h4"><?=$product->getPrice();?> €</span> TTC</div>
          </div>
          <div class="product-action-buttons">
            <form action="" method="post">
              <input type="hidden" name="product_id" value="1">
              <button class="btn btn-dark btn-buy"><i class="fa fa-shopping-cart"></i><span class="btn-buy-label ml-2">Ajouter au panier</span></button>
            </form>
          </div>
          <div class="mt-5">
            <p>
            <?=$product->getDescription();?>
            </p>
          </div>
        </div>
        <!-- /product-->
      </div>

    </div>
  </section>