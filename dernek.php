<?php
/*
Plugin Name: Dernek Üye Yönetimi
Description: Dernek üye yönetimi eklentisi.
Version: 1.0
Author: TURKSOFT
Author URI: https://www.turksoft.com.tr
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Doğrudan erişim önlendi
}

// Dernek sınıfları için otomatik yükleyici
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Dernek_') === 0) {
        $file = plugin_dir_path(__FILE__) . 'includes/class-' . strtolower(str_replace('_', '-', $class_name)) . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            error_log("Dosya yüklenemedi: " . $file . " - Sınıf adı: " . $class_name);
        }
    }
});

// Eklentiyi başlatın
function dernek_init() {
    Dernek_Admin_Menu::init();
}
add_action('init', 'dernek_init', 20); // 20 öncelik sırasıdır


function add_dernek_role() {
    // Yeni rolü ekleyin
    add_role(
        'dernek_uye_rolu', // Rol ID'si
        __('Dernek Üyesi', 'dernek-uye-yonetimi'), // Rolün Görünen Adı
        array(
            'read' => true, // Kullanıcıların dashboard'a erişmesine izin ver
            'edit_posts' => false, // Kendi yazılarını düzenlemelerine izin verme
            'delete_posts' => false, // Yazı silmeye izin verme
            // Diğer yetkileri burada ekleyebilirsiniz
        )
    );
}

/**
 * Rol ve Yetki Tanımlamaları: add_dernek_role fonksiyonunu eklentiyi etkinleştirme anında çalıştırmak daha uygun olacaktır.
 */
function dernek_activate() {
    add_dernek_role();
}
register_activation_hook(__FILE__, 'dernek_activate');


/**
 * Ayrıca, eklenti devre dışı bırakıldığında yapilacak işlemler
 */
function dernek_deactivate() {
    // Bu role sahip kullanıcıları alın
    $users = get_users(array('role' => 'dernek_uye_rolu'));
    foreach ($users as $user) {
        // Eğer kullanıcı sadece bu role sahipse, 'subscriber' rolüne taşı
        if (count($user->roles) === 1 && in_array('dernek_uye_rolu', $user->roles)) {
            $user->set_role('subscriber');
        } else {
            // Diğer rolleri saklayarak bu rolü kaldır
            $user->remove_role('dernek_uye_rolu');
        }
    }
    
    // Rolü kaldır
    remove_role('dernek_uye_rolu');
}

register_deactivation_hook(__FILE__, 'dernek_deactivate');

/**
 * Eklenti dil dosyası
 */
function dernek_load_textdomain() {
    load_plugin_textdomain('dernek-uye-yonetimi', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'dernek_load_textdomain');
