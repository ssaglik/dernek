<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Dernek_Members_List_Table extends WP_List_Table {

    
    public function __construct() {
        parent::__construct( array(
            'singular' => 'Üye',
            'plural'   => 'Üyeler',
            'ajax'     => false,
        ) );
    }

    public function get_hidden_columns()
    {
        return array();
    }


    public function get_sortable_columns()
    {
        return array('ID' => array('ID', false));
    }


    public function get_columns() {
        return array(
            'ID'          => 'ID',
            'user_email'  => 'Email',
        );
    }

    public function prepare_items() {

       global $wpdb;

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $per_page = $this->get_option('members_per_page', 10);
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;
        
        $total_query = "SELECT COUNT(*) FROM {$wpdb->prefix}users";
        $total = $wpdb->get_var($total_query);
    
        $query = $wpdb->prepare("SELECT ID, user_email FROM {$wpdb->prefix}users LIMIT %d OFFSET %d", $per_page, $offset);
        $data = $wpdb->get_results($query, ARRAY_A);
    
        $this->set_pagination_args(array(
            'total_items' => $total,
            'per_page'    => $per_page,
            'total_pages' => ceil($total / $per_page)
        ));
    
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;

    }

    public function column_default( $item, $column_name ) {
        //error_log('column_default çalıştı: ' . $column_name);
        //return isset($item[$column_name]) ? esc_html($item[$column_name]) : 'N/A';

        switch ( $column_name ) {
            case 'ID':
            case 'user_email':
                return  $item[ $column_name ];
            default:
                return print_r( $item, true ); 
        }
    }


    public function get_option($option, $default = 0) {
        $screen = get_current_screen();
        $user_option = get_user_meta(get_current_user_id(), $screen->id . '_' . $option, true);
    
        if ( !empty($user_option) ) {
            return intval($user_option);
        }
    
        return intval($default);
    }
   

}


// Ekran ayarlarını ayarlamak için kullanılan fonksiyonlar
function members_screen_option() {
    $screen = get_current_screen();
    // Screen id kontrol ederek doğru ekranda olduğunuzdan emin olun
    if ( 'toplevel_page_members-list' == $screen->id ) {
        $args = array(
            'label'   => 'Members per page',
            'default' => 10,
            'option'  => 'members_per_page'
        );
        add_screen_option( 'per_page', $args );
    }
}


add_action('admin_menu', function() {
    $hook = add_menu_page('Members List', 'Members', 'manage_options', 'members-list', 'render_members_list_page');
    add_action("load-$hook", 'members_screen_option');
});
