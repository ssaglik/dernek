<?php
class Dernek_Admin_Menu {

    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_menu_items'));
        add_action('admin_init', array(__CLASS__, 'add_screen_options'));
    }

    public static function add_screen_options() {
        add_filter('set_screen_option_members_per_page', array(__CLASS__, 'save_screen_option'));
    }

    public static function save_screen_option($status, $option, $value) {
        return $value;
    }

    public static function add_menu_items() {
        $hook = add_menu_page(
            'Dernek Üyeleri',
            'Dernek Üyeleri',
            'manage_options',
            'dernek_members',
            array(__CLASS__, 'members_page'),
            'dashicons-groups'
        );

        add_action("load-$hook", array(__CLASS__, 'set_screen_options'));

        add_submenu_page(
            'dernek_members',
            'Yeni Üye Ekle',
            'Yeni Üye Ekle',
            'manage_options',
            'dernek_add_member',
            array(__CLASS__, 'add_member_page')
        );

        add_submenu_page(
            'dernek_members',
            'İçe Aktar',
            'İçe Aktar',
            'manage_options',
            'dernek_import',
            array(__CLASS__, 'import_page')
        );
    }


    public static function set_screen_options() {
        $option = 'per_page';
        $args = array(
            'label' => 'Üyeler per page',
            'default' => 10,
            'option' => 'members_per_page'
        );
        add_screen_option($option, $args);
    }
    
    public static function members_page() {

        $membersListTable = new Dernek_Members_List_Table();
        $membersListTable->prepare_items();
    
        echo '<div class="wrap">';
        echo '<h1 class="wp-heading-inline">Tüm Üyeler</h1>';
        echo '<form method="post">';
        $membersListTable->search_box('Ara', 'search_id');
        $membersListTable->display(); // Bu satırın olduğundan emin olun
        echo '</form>';
        echo '</div>';
    }
    



    public static function add_member_page() {
        if ( $_POST['submit'] ) {
            $result = Dernek_Member::add_member( $_POST );
            if ( is_wp_error( $result ) ) {
                echo '<div class="error"><p>Üye eklenirken bir hata oluştu.</p></div>';
            } else {
                echo '<div class="updated"><p>Yeni üye başarıyla eklendi.</p></div>';
            }
        }
    
        // Şablon dosyasını çağır
        include plugin_dir_path( __FILE__ ) . '../templates/add-member-form.php';
    }
    
    
    public static function import_page() {
        if (isset($_POST['import'])) {
            // `add_member_from_import` fonksiyonunu çağır
            Dernek_Member::add_member_from_import();
            echo '<div class="updated"><p>Veriler başarıyla aktarıldı.</p></div>';
        }
    
        ?>
        <div class="wrap">
            <h1>İçe Aktar</h1>
            <p>Buradan verileri `z_import` tablosundan alarak üyelerinizi WordPress'e aktarabilirsiniz.</p>
            <form method="post">
                <input type="submit" name="import" value="Aktar" class="button button-primary">
            </form>
        </div>
        <?php
    }
    



}


// Başlangıç metodunu tetikleyin
Dernek_Admin_Menu::init();
