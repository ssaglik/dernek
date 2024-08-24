<?php
// Yeni üye ekleme formu

?>
<div class="wrap">
    <h1>Yeni Üye Ekle</h1>
    <form method="post">
        <label for="first_name">Ad:</label>
        <input type="text" name="first_name" id="first_name" class="regular-text"><br><br>

        <label for="last_name">Soyad:</label>
        <input type="text" name="last_name" id="last_name" class="regular-text"><br><br>

        <label for="role">Rol:</label>
        <select name="role" id="role" class="regular-text">
            <option value="subscriber">Abone</option>
            <!-- Diğer roller eklenebilir -->
        </select><br><br>

        <label for="durum">Durum:</label>
        <select name="durum" id="durum" class="regular-text">
            <option value="Aktif">Aktif</option>
            <option value="Pasif">Pasif</option>
        </select><br><br>

        <label for="sicil_no">Sicil No:</label>
        <input type="text" name="sicil_no" id="sicil_no" class="regular-text"><br><br>

        <label for="tc_kimlik_no">TC Kimlik No:</label>
        <input type="text" name="tc_kimlik_no" id="tc_kimlik_no" class="regular-text"><br><br>

        <label for="ev_ulke">Ev Ülke:</label>
        <input type="text" name="ev_ulke" id="ev_ulke" class="regular-text"><br><br>

        <label for="ev_adresi">Ev Adresi:</label>
        <textarea name="ev_adresi" id="ev_adresi" class="regular-text"></textarea><br><br>

        <label for="ev_il">Ev İl:</label>
        <select name="ev_il" id="ev_il" class="regular-text">
            <?php
            $iller = array('İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya'); // Türkiye'deki 81 il burada listelenebilir
            foreach ($iller as $il) {
                echo '<option value="' . $il . '">' . $il . '</option>';
            }
            ?>
        </select><br><br>

        <label for="ev_ilce">Ev İlçe:</label>
        <input type="text" name="ev_ilce" id="ev_ilce" class="regular-text"><br><br>

        <label for="giris_tarihi">Giriş Tarihi:</label>
        <input type="date" name="giris_tarihi" id="giris_tarihi" value="<?php echo date('Y-m-d'); ?>" class="regular-text"><br><br>

        <label for="uye_grup">Üye Grup:</label>
        <select name="uye_grup" id="uye_grup" class="regular-text">
            <option value="Asil Üye">Asil Üye</option>
            <option value="Yedek Üye">Yedek Üye</option>
        </select><br><br>

        <label for="cep_tel">Cep Tel:</label>
        <input type="text" name="cep_tel" id="cep_tel" class="regular-text"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="regular-text"><br><br>

        <label for="dogum_tarihi">Doğum Tarihi:</label>
        <input type="date" name="dogum_tarihi" id="dogum_tarihi" class="regular-text"><br><br>

        <label for="baba_adi">Baba Adı:</label>
        <input type="text" name="baba_adi" id="baba_adi" class="regular-text"><br><br>

        <label for="anne_adi">Anne Adı:</label>
        <input type="text" name="anne_adi" id="anne_adi" class="regular-text"><br><br>

        <input type="submit" name="submit" value="Yeni Üye Ekle" class="button button-primary">
    </form>
</div>
