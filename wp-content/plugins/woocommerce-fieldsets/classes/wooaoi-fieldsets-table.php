<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WooAOI_List_Table extends WP_List_Table {
	
	function get_data() {
	
	$sets=WooAOI_get_sets();
	
	$return=array();
	foreach ($sets as $set) {
		$return[]=array('ID'=>$set['ID'],'name'=>'<strong>'.htmlentities(stripslashes($set['name'])).'</strong>','fields'=>WooAOI_count_fields($set['ID']),'actions'=>__('Edit set','woo-aoi').' | '.__('Remove entire set','woo-aoi'));
	}
	
	return $return;
	}

    function __construct(){
    global $status, $page;

        parent::__construct( array(
            'singular'  => __( 'fieldset', 'woo-aoi' ),     //singular name of the listed records
            'plural'    => __( 'fieldsets', 'woo-aoi' ),   //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
    ) );

    }
	
  function column_name($item){
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>',
            /*$1%s*/ $item['name'],
            /*$2%s*/ $item['ID']
            /*$3%s $this->row_actions($actions)*/
        );
    }
  
   function column_actions($item){
        
        //Build row actions
		$nonce = wp_create_nonce( 'aoi-delete' );
        $actions = array(
            //'edit'      => sprintf('<a href="?page=%s&action=%s&set=%s">'.__('Edit set','woo-aoi').'</a>','woo_aoi_set','edit',$item['ID']),
			'edit'      => sprintf('<a href="post.php?post=%s&action=%s">'.__('Edit set','woo-aoi').'</a>',$item['ID'],'edit'),
            'delete'    => sprintf('<a href="?page=%s&action=%s&set=%s&_wpnonce=%s">'.__('Delete set','woo-aoi').'</a>',$_REQUEST['page'],'delete',$item['ID'],$nonce),
        );
        
        //Return the title contents
        return sprintf('%1$s | %2$s',
            /*$1%s $item['name'],
            /*$3%s*/ $actions['edit'], 
			$actions['delete']
        );
    }

  function column_default( $item, $column_name ) {
    switch( $column_name ) { 
        case 'name':
        case 'fields':
        case 'actions':
            return $item[ $column_name ];
        default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
    }
  }

      function get_sortable_columns() {
        $sortable_columns = array(
            'name'     => array('name',true),     //true means it's already sorted
            'fields'    => array('fields',false),
        );
        return $sortable_columns;
    }

  
	function get_columns(){
        $columns = array(
            'name' => __( 'Name', 'woo-aoi' ),
            'fields'    => __( '# Fields', 'woo-aoi' ),
            'actions'      => __( 'Actions', 'woo-aoi' ),
        );
         return $columns;
    }
	
	function process_bulk_action() {
		

		if( 'delete'===$this->current_action() ) {
			if(wp_verify_nonce( $_REQUEST['_wpnonce'], 'aoi-delete' )) {
				wp_delete_post($_GET['set']);
				wp_redirect('?page=woo_aoi');
			} else { wp_die( __("You do not have sufficient permissions to access this page.", "woo-aoi" ) );  }
        } 
    }
	
	function prepare_items() {
		$columns  = $this->get_columns();
	
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$data = $this->get_data();
		$this->process_bulk_action();
  
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'name'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        
		usort($data, 'usort_reorder');
  
		$per_page = 25;
		$current_page = $this->get_pagenum();
        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}

} //class