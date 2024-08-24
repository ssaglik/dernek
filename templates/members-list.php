<?php
// Üyeler listesi şablonu

// Veritabanından tüm üyeleri çek
global $wpdb;
$table_name = $wpdb->prefix . 'users'; // WordPress kullanıcı tablosu
$results = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );
?>

<div class="wrap">
    <h1>Tüm Üyeler</h1>
    <form method="get">
        <input type="hidden" name="page" value="dernek-members">
        <label for="search">Ara:</label>
        <input type="text" name="search" id="search" class="regular-text">
        <input type="submit" value="Ara" class="button button-primary">
    </form>
    <table class="widefat fixed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Durum</th>
                <th>Sicil No</th>
                <th>TC Kimlik No</th>
                <th>Ev Ülke</th>
                <th>Ev Adresi</th>
                <th>Ev İl</th>
                <th>Ev İlçe</th>
                <th>Giriş Tarihi</th>
                <th>Üye Grup</th>
                <th>Cep Tel</th>
                <th>Email</th>
                <th>Doğum Tarihi</th>
                <th>Baba Adı</th>
                <th>Anne Adı</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $user): ?>
                <tr>
                    <td><?php echo esc_html($user['ID']); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'first_name', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'last_name', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'durum', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'sicil_no', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'tc_kimlik_no', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'ev_ulke', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'ev_adresi', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'ev_il', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'ev_ilce', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'giris_tarihi', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'uye_grup', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'cep_tel', true)); ?></td>
                    <td><?php echo esc_html($user['user_email']); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'dogum_tarihi', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'baba_adi', true)); ?></td>
                    <td><?php echo esc_html(get_user_meta($user['ID'], 'anne_adi', true)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
