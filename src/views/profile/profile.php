<?php
$user = Users::fromEmail($_SESSION['email']);
$picture = $picture = ImageManager::getUserImagePath($_SESSION['email']);
?>

<article class="profile">
    <h1>Profilo utente</h1>
    <section class="profile-image-big text-center mb-4">
        <!-- Foto profilo (verifica che la foto esista nel percorso specificato) -->
        <img src="<?php echo $picture; ?>" 
                alt="Foto Profilo" class="img-fluid rounded-circle user-img" width="150" height="150">
    </section>

    <h2>Dettagli personali</h2>
    <section class="profile-details">
        <ul class="list-group">
            <li class="list-group-item"><strong>E-Mail:</strong> <?php echo $user->getEmail(); ?></li>
            <li class="list-group-item"><strong>Username:</strong> <?php echo $user->getUsername(); ?></li>
            <li class="list-group-item"><strong>Nome:</strong> <?php echo $user->getSurname() . " " . $user->getName(); ?></li>
        </ul>
    </section>

    <footer class="text-center mt-4">
        <form action="?action=profile&subAction=logout" method="POST">
            <button type="submit">Log out</button>
        </form>
    </footer>
</article>