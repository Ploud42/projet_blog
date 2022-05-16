<div class="card w-100">
    <img class="card-img-top" src="./asset/img/banner.png" alt="rétro pgm, les meilleurs jeux, par les meilleurs">
    <!--     <div class="card-img-overlay">
        <?php
        if (isset($_SESSION['pseudo'], $_SESSION['pwd'])) {
            echo '<p class="card-text mb-0">Bonjour <strong>' . $_SESSION['pseudo'] . '</strong>, ravis de vous revoir.</p>';
            echo '<p class="card-text mb-0"><a href="./create_post.php">Créer un article</a></p>';
            echo '<p class="card-text mb-0"><a href="./author_posts.php?author_id=' . $_SESSION['id'] . '">Vos articles</a></p>';
            echo '<p class="card-text mb-0"><a href="./login_deco.php">Se déconnecter</a></p>';
        } else {
            echo '<p class="card-text mb-0"><a href="./login_form.php">Se connecter</a></p>';
        }
        ?>
    </div> -->
</div>
<!-- <img src="./asset/img/banner.png" class="img-fluid w-100" alt="rétro pgm, les meilleurs jeux, par les meilleurs"> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!--         <a class="navbar-brand" href="#">Menu</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./welcome.php">Home</a>
                </li>
                <!--                 <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Catégories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            echo '<li><a class="dropdown-item" href="./category_posts.php?category_id=' . $category['id'] . '">' . $category['name'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav me-2 mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['pseudo'], $_SESSION['pwd'], $_SESSION['id'])) {
                ?>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo 'Bonjour <strong class="text-info">' . $_SESSION['pseudo'] . '</strong>, ravis de vous revoir.'; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./create_post.php">Créer un article</a></li>
                            <?php echo '<li><a class="dropdown-item" href="./author_posts.php?author_id=' . $_SESSION['id'] . '">Vos articles</a></li>'; ?>
                            <li><a class="dropdown-item" href="./login_deco.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                <?php
                } else
                    echo '<li class="nav-item"><a class="nav-link text-primary" href="./login_form.php">Se connecter</a></li>';
                ?>
            </ul>
            <!--             <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
        </div>
    </div>
</nav>