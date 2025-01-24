<link rel="stylesheet" href="public/style/notifications_user.css"/>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mt-3 position-relative">
        <h2 class="mb-0">Notifiche - 
            <select class="form-select d-inline w-auto ms-2 border-0" id="period-select" style="font-size: inherit;">
                <option value="Ultima settimana" style="font-size: small;">Ultima settimana</option>
                <option value="Ultimo mese" style="font-size: small;">Ultimo mese</option>
                <option value="Ultimi 6 mesi" style="font-size: small;">Ultimi 6 mesi</option>
                <option value="Ultimo anno" style="font-size: small;">Ultimo anno</option>
                <option value="Sempre" style="font-size: small;">Sempre</option>
            </select>
        </h2>
    </div>
    <div class="row" id="notifications-container" style="font-size: large;">
        
    </div>
</div>

<script src="public/script/notifications_user.js"></script>
