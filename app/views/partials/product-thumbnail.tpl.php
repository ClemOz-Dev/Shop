<?php
// nous demandons au router de nous générer un lien vers la page produit
$url = $router->generate(
    'catalog-product',
    [
        'idProduct' => $product->getId()
    ]
);
?>
<!-- product-->
<div class="product col-xl-3 col-lg-4 col-sm-6">
    <div class="product-image">
    <a href="<?=$url;?>" class="product-hover-overlay-link">
        <img src="<?=$product->getPicture();?>" alt="product" class="img-fluid">
    </a>
    </div>
    <div class="product-action-buttons">
    <a href="#" class="btn btn-outline-dark btn-product-left"><i class="fa fa-shopping-cart"></i></a>
    <a href="detail.html" class="btn btn-dark btn-buy"><i class="fa-search fa"></i><span class="btn-buy-label ml-2">Voir</span></a>
    </div>
    <div class="py-2">
        <p class="text-muted text-sm mb-1">Chausson</p>
        <h3 class="h6 text-uppercase mb-1">
            <a href="<?=$url;?>" class="text-dark"><?=$product->getName();?></a>
        </h3>
        <span class="text-muted"><?=$product->getPrice();?>€</span>
    </div>
</div>
<!-- /product-->