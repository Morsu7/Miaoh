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