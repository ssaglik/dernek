<?php

/*

// Kullanıcı verilerini hazırlıyoruz
$userdata = array(
    'user_login'    => 'username', // Zorunlu: Kullanıcının giriş yaparken kullanacağı kullanıcı adı
    'user_pass'     => 'password', // Opsiyonel (Zorunlu değil): Kullanıcının şifresi (sağlanmazsa rastgele bir şifre oluşturulur)
    'user_email'    => 'email@example.com', // Opsiyonel: Kullanıcının e-posta adresi
    'user_url'      => 'http://example.com', // Opsiyonel: Kullanıcının web sitesi URL'si
    'user_nicename' => 'nice_name', // Opsiyonel: Kullanıcının görünen adı
    'display_name'  => 'Display Name', // Opsiyonel: Kullanıcının gösterilecek adı
    'nickname'      => 'Nickname', // Opsiyonel: Kullanıcının takma adı
    'first_name'    => 'First', // Opsiyonel: Kullanıcının adı
    'last_name'     => 'Last', // Opsiyonel: Kullanıcının soyadı
    'description'   => 'Description', // Opsiyonel: Kullanıcı açıklaması (bio)
    'role'          => 'subscriber', // Opsiyonel: Kullanıcının rolü (varsayılan 'abone')
    'jabber'        => 'jabber@example.com', // Opsiyonel: Jabber IM
    'aim'           => 'AIM Name', // Opsiyonel: AOL IM
    'yim'           => 'Yahoo IM', // Opsiyonel: Yahoo IM
);


Parametre Açıklamaları

* Zorunlu:
user_login: Kullanıcı adı. Bu, kullanıcı için benzersiz olmalıdır ve giriş yaparken kullanılır.

* Opsiyonel:

user_pass: Şifre. Sağlanmazsa rastgele bir şifre oluşturulur.
user_email: Kullanıcının e-posta adresi. Benzersiz olmalıdır.
user_url: Kullanıcının web sitesi URL'si.
user_nicename: Kullanıcının temizlenmiş görünen adı (URL dostu).
display_name: Kullanıcının gösterilecek adı. WordPress'te yayınlanan içeriklerde gösterilir.
nickname: Kullanıcının takma adı.
first_name: Kullanıcının adı.
last_name: Kullanıcının soyadı.
description: Kullanıcının biyografisi veya açıklaması.
role: Kullanıcının WordPress rolü (örn: subscriber, editor, administrator).
jabber: Kullanıcının Jabber IM adresi.
aim: Kullanıcının AOL IM adı.
yim: Kullanıcının Yahoo IM adı.

*/



class Dernek_Member {

    public static function add_member( $data ) {
        // Kullanıcıyı WordPress'e ekleyin
        $userdata = array(
            'user_login'  => $data['sicil_no'], // Kullanıcı adı Sicil No olacak
            'user_pass'   => $data['tc_kimlik_no'], // Şifre TC Kimlik No olacak
            'user_email'  => $data['email'],
            'first_name'  => $data['first_name'],
            'last_name'   => $data['last_name'],
            'role'        => isset($data['role']) ? sanitize_text_field($data['role']) : $default_role, // Varsayılan rol
        );
    
        $user_id = wp_insert_user( $userdata );
    
        if ( ! is_wp_error( $user_id ) ) {
            // Ekstra kullanıcı meta verilerini kaydedin
            update_user_meta( $user_id, 'durum', $data['durum'] );
            update_user_meta( $user_id, 'sicil_no', $data['sicil_no'] );
            update_user_meta( $user_id, 'tc_kimlik_no', $data['tc_kimlik_no'] );
            update_user_meta( $user_id, 'ev_ulke', $data['ev_ulke'] );
            update_user_meta( $user_id, 'ev_adresi', $data['ev_adresi'] );
            update_user_meta( $user_id, 'ev_il', $data['ev_il'] );
            update_user_meta( $user_id, 'ev_ilce', $data['ev_ilce'] );
            update_user_meta( $user_id, 'giris_tarihi', $data['giris_tarihi'] );
            update_user_meta( $user_id, 'uye_grup', $data['uye_grup'] );
            update_user_meta( $user_id, 'cep_tel', $data['cep_tel'] );
            update_user_meta( $user_id, 'dogum_tarihi', $data['dogum_tarihi'] );
            update_user_meta( $user_id, 'baba_adi', $data['baba_adi'] );
            update_user_meta( $user_id, 'anne_adi', $data['anne_adi'] );
    
            return true;
        } else {
            $add_member_error = $user_id->get_error_message();
            return $user_id;
        }
    }






    public static function add_member_from_import() {
        global $wpdb;
    
        // Maksimum yürütme süresini sınırsız yapın
        // set_time_limit(0);

        // `z_import` tablosundan verileri çek
        $results = $wpdb->get_results("SELECT * FROM wp_z_import limit 5", ARRAY_A);
    
        foreach ($results as $row) {
            // Veriyi uygun şekilde temizle
            /*
            $data = array(
                'durum'        => sanitize_text_field($row['durum']),
                'sicil_no'     => sanitize_text_field($row['sicil_no']),
                'tc_kimlik_no' => sanitize_text_field($row['tc_kimlik_no']),
                'ev_ulke'      => sanitize_text_field($row['ev_ulke']),
                'ev_adresi'    => sanitize_textarea_field($row['ev_adresi']),
                'ev_il'        => sanitize_text_field($row['ev_il']),
                'ev_ilce'      => sanitize_text_field($row['ev_ilce']),
                'giris_tarihi' => sanitize_text_field($row['giris_tarihi']),
                'uye_grup' => sanitize_text_field($row['uye_grup']),
                'cep_tel'      => sanitize_text_field($row['cep_tel']),
                'dogum_tarihi' => sanitize_text_field($row['dogum_tarihi']),
                'baba_adi'     => sanitize_text_field($row['baba_adi']),
                'anne_adi'     => sanitize_text_field($row['anne_adi']),
            );
            */
    
            $data = $row;
            // Kullanıcıyı WordPress'e ekleyin
            $userdata = array(
                'user_login'  => $data['sicil_no'], // Kullanıcı adı Sicil No olacak
                'user_pass'   => $data['tc_kimlik_no'], // Şifre TC Kimlik No olacak
                'user_email'  => $data['email'],
                'first_name'  => $data['first_name'],
                'last_name'   => $data['last_name'],
                'role'        => "dernek_uye_rolu",
            );

            $user_id = wp_insert_user( $userdata );

            if ( ! is_wp_error( $user_id ) ) {
                // Ekstra kullanıcı meta verilerini kaydedin
                update_user_meta( $user_id, 'durum', $data['durum'] );
                update_user_meta( $user_id, 'sicil_no', $data['sicil_no'] );
                update_user_meta( $user_id, 'tc_kimlik_no', $data['tc_kimlik_no'] );
                update_user_meta( $user_id, 'ev_ulke', $data['ev_ulke'] );
                update_user_meta( $user_id, 'ev_adresi', $data['ev_adresi'] );
                update_user_meta( $user_id, 'ev_il', $data['ev_il'] );
                update_user_meta( $user_id, 'ev_ilce', $data['ev_ilce'] );
                update_user_meta( $user_id, 'giris_tarihi', $data['giris_tarihi'] );
                update_user_meta( $user_id, 'uye_grup', $data['uye_grup'] );
                update_user_meta( $user_id, 'cep_tel', $data['cep_tel'] );
                update_user_meta( $user_id, 'dogum_tarihi', $data['dogum_tarihi'] );
                update_user_meta( $user_id, 'baba_adi', $data['baba_adi'] );
                update_user_meta( $user_id, 'anne_adi', $data['anne_adi'] );

               // return true;
            } else {
                $add_member_error = $user_id->get_error_message();
                //return $user_id;
            }

        }
    }
    




    
}
