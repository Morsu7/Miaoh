<article class="profile">
    <h1>Profilo utente</h1>
    <div class="profile-image-big text-center mb-4">
        <!-- Foto profilo (verifica che la foto esista nel percorso specificato) -->
        <img src="<?php echo $picture; ?>" 
                alt="Foto Profilo" class="img-fluid rounded-circle user-img" width="150" height="150">
    </div>

    <!-- Horizontal Navbar -->
    <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php if($subAction == 'profile') echo 'active'?>" id="tab1" href="#content1" data-bs-toggle="tab">Generale</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php if($subAction == 'orders') echo 'active'?>" id="tab2" href="#content2" data-bs-toggle="tab">Ordini</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php if($subAction == 'pro') echo 'active'?>" id="tab3" href="#content3" data-bs-toggle="tab">Notifiche</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content content-section">
        <div id="content1" class="tab-pane fade <?php if($subAction == 'profile') echo 'show active'?>"><?php include_once $profile_details;?></div>
        <div id="content2" class="tab-pane fade <?php if($subAction == 'orders') echo 'show active'?>"><?php include_once $orders;?></div>
        <div id="content3" class="tab-pane fade <?php if($subAction == 'pro') echo 'show active'?>"><?php include_once $notifications_view;?></div>
    </div>
</article>