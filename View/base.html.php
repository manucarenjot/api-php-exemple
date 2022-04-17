<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body> <?php
echo "<pre>";
var_dump([
    'user in session' => isset($_SESSION['user']),
    'user_connected' => UserController::isUserConnected(),
]);
echo "</pre>";
    // Handling error messages.
    if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);

        foreach($errors as $error) { ?>
            <div class="alert alert-error"><?= $error ?></div> <?php
        }
    }

    // Handling sucecss messages.
    if(isset($_SESSION['success'])) {
        $message = $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <div class="alert alert-success"><?= $message ?></div> <?php
    }
    ?>
    <header>
        <nav>
            <ul>
                <li><a href="/index.php?c=user" title="Utilisateurs">Utilisateurs</a></li>
                <li><a href="/index.php?c=article&a=add-article">Ajouter un article</a></li> <?php
                if(!UserController::isUserConnected()) { ?>
                    <li><a href="/index.php?c=user&a=register">S'enregistrer</a></li>
                    <li><a href="/index.php?c=user&a=login">Se Connecter</a></li> <?php
                }
                else { ?>
                    <li><a href="/index.php?c=user&a=logout">Se déconnecter</a></li> <?php
                }

                ?>

            </ul>
        </nav>
    </header>

    <main class="container">
        <?= $html ?>
    </main>

    <footer>
        <div>Infos de contact</div>
        <div>Horaires</div>
    </footer>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/article.js"></script>
</body>
</html>
