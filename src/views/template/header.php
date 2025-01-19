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
        <a class="navbar-brand" href="?#">
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo" class="logo">
                
                <!-- Site Name -->
                <h1 class="m-0 text-center flex-grow-1" style="font-size: 1.25rem; color: #6f42c1">MIAOH</h1>
            </div>
        </a>
        <a class="navbar-brand" href="?action=profile">
            <img src="<?php echo $picture ?>" alt="User" class="user-img"/>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="?#">Home</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Shop
            </a>
            <ul class="dropdown-menu active">
                <li><a class="dropdown-item" href="#">Accessori</a></li>
                <li><a class="dropdown-item" href="#">Cibo</a></li>
                <li><a class="dropdown-item" href="#">Giochi</a></li>
            </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="?action=shopping&subAction=carrello"><i class="bi bi-cart"></i> Carrello</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="?action=profile">Profilo</a>
            </li>
        </ul>
        </div>
    </div>
</nav>

<script src="public/script/header.js"></script>