<?php include './assets/constantes.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Menu
                </h2>
        </article>
        <article class="d-flex flex-row justify-content-evenly mt-5">
            <?php
            $iterador = new RecursiveArrayIterator($datosCards);
            foreach (new RecursiveIteratorIterator($iterador) as $key => $value) { ?>
                <a type="button" class="card card__Style" href=<?php echo "index.php?module=".strtolower(trim($key))?>>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $key ?></h5>
                        <p class="card-text"><?php echo $value ?></p>
                    </div>
                </a>
            <?php }?>
        </article>
    </main>
</body>
</html>
