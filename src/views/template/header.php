<?php 
if(isset($_SESSION['email'])){
    require_once "../src/models/users/User.php";
    require_once "../src/models/users/Users.php";

    $user = Users::fromEmail($_SESSION['email']);
    $picture = IMAGE_PATH . "profilepictures/" . $user->getUsername() . "." . $user->getImageExtension();
}else{
    $picture = IMAGE_PATH . "/icons/profilePic.png";
}

?>
<header class="d-flex align-items-center justify-content-between px-3 py-2">
        <!-- Menu Button (pulsante menu a tendina) -->
        <button class="btn btn-outline-primary menu-button" data-bs-toggle="collapse" data-bs-target="#menu">
            ☰
        </button>

        <!-- Logo accanto al titolo -->
        <div class="d-flex align-items-center">
            <!-- Logo -->
            <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo" class="logo">
            
            <!-- Site Name -->
            <h1 class="m-0 text-center flex-grow-1" style="font-size: 1.25rem; color: #6f42c1">MIAOH</h1>
        </div>

        <!-- User Image -->
        <a href="?action=profile" class="d-block py-2 text-decoration-none"><img src="<?php echo $picture ?>" alt="User" class="user-img"/></a>
    </header>

<!-- Menu Dropdown -->
<div id="menu" class="collapse bg-light">
    <ul class="list-unstyled m-0 p-3">
        <li><a href="?#" class="d-block py-2 text-decoration-none">Home</a></li>
        <li><a href="#" class="d-block py-2 text-decoration-none">Shop</a></li>
        <li><a href="#" class="d-block py-2 text-decoration-none">Cart</a></li>
        <li><a href="?action=profile" class="d-block py-2 text-decoration-none">Profile</a></li>
    </ul>
</div>