<?php 
if(isset($_SESSION['email'])){
    require_once "../src/models/images/ImageManager.php";

    $picture = ImageManager::getUserImagePath($_SESSION['email']);
}else{
    $picture = IMAGE_PATH . "/icons/profilePic.png";
}

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand d-flex align-items-center mx-auto logo-header" href="?#">
            <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" width="50" height="50" class="me-2"/>
            <span>MIAOH</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="?#">Home</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Shop
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Accessori</a></li>
                <li><a class="dropdown-item" href="#">Cibo</a></li>
                <li><a class="dropdown-item" href="#">Giochi</a></li>
            </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=shopping&subAction=carrello"><i class="bi bi-cart"></i> Carrello</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=profile">Profilo</a>
            </li>
        </ul>
    </div>

    <!-- User image aligned to the top-right, vertically centered -->
    <a class="navbar-brand d-flex align-items-center position-absolute top-50 end-0 translate-middle-y p-2" href="?action=profile">
        <img src="<?php echo $picture ?>" alt="User" class="user-img" width="60" height="60"/>
    </a>
</nav>

<script src="public/script/header.js"></script>