<?php
$user = Users::fromEmail($_SESSION['email']);
?>

<article class="profile">
    <section class="profile-image text-center mb-4">
        <!-- Foto profilo (verifica che la foto esista nel percorso specificato) -->
        <img src="path/to/images/<?php echo $user->getProfilePicture(); ?>" 
                alt="Foto Profilo" class="img-fluid rounded-circle" width="150" height="150">
    </section>

    <section class="profile-details">
        <ul class="list-group">
            <li class="list-group-item"><strong>Username:</strong> ciaoo <?php echo "weee" . $user->getUsername(); ?></li>
        </ul>
    </section>

    <footer class="text-center mt-4">
        <form action="?action=profile&subAction=logout" method="POST">
            <button type="submit">Log out</button>
        </form>
    </footer>
</article>