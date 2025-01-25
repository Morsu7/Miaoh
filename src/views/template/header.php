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
            <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" width="50" height="50" class="me-2" alt="Miaoh Logo"/>
            <span>MIAOH</span>
        </a>

        <div class="position-relative d-inline-block">
            <!-- User image aligned to the top-right, vertically centered -->
            <a class="d-flex align-items-center ml-auto top-50 end-0" href="?action=profile">
                <img src="<?php echo $picture ?>" alt="User" class="user-img user-icon" width="60" height="60"/>
            </a>
            
            <!-- Notification Dot -->
            <span style="display: none" id="notification-dot" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New notifications</span>
            </span>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="?#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=shopping&subAction=carrello"><i class="bi bi-cart"></i> Carrello</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=profile">Profilo</a>
            </li>
        </ul>
    </div>
</nav>

<script src="public/script/header.js"></script>