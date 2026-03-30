<?php
require_once 'view/partial/header.php' 
?>
<main>
    <h2>inscription</h2>

    <?php
    if ($errorMessage != ''){
        ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
        </div>
        <?php
    }
    ?>

    <form action="index.php" method="POST">

        <div>
            <label for="username">Pseudo</label><br>
            <input type="text" id="username" name="username" required>
        </div>

        <br>

        <div>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <br>

        <div>
            <label for="password">Mot de passe</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <br>

        <div>
            <label for="confirm_password">Confirmer le mot de passe</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <br>

        <div>
            <button type="submit" name="action" value="register">S'inscrire</button>
        </div>
    </form>
</main>

<?php
require_once 'view/partial/footer.php';
?>