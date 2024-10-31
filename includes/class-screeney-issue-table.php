<?php

class Screeney_Issue_Table extends WP_List_Table {

    private $data;
    private $found_data;
    private $project_id;

    public function add_data( $data ) {
        $this->data = $data;
    }

    public function set_project_id( $id ) {
        $this->project_id = $id;
    }

    public function get_columns() {
        $columns = array(
            'issue'      => __( 'Issue Name', 'screeney' ),
            'created_at' => __( 'Issue Added', 'screeney' ),
            'completed'  => __( 'Issue Completed', 'screeney' ),
            'actions'    => '&nbsp;',
        );

        return $columns;
    }

    public function prepare_items() {
        $per_page     = 15;
        $current_page = $this->get_pagenum();
        $total_items  = count( $this->data );

        $this->found_data = array_slice( $this->data, ( ( $current_page - 1 ) * $per_page ), $per_page );

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page                     //WE have to determine how many items to show on a page
        ) );

        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = array();
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $this->items           = $this->found_data;
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'issue':
            case 'created_at':
            case 'actions':
                return $item->{$column_name};
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    public function column_created_at( $item ) {
        $date = new DateTime( $item->created_at );

        return $date->format( 'd/m/Y H:i' );
    }

    public function column_actions( $item ) {

        $data = array(
            'screenshot'   => $item->screenshot,
            'issue'        => $item->issue,
            'url'          => $item->url,
            'data'         => $item->data,
            'created_at'   => $item->created_at,
            'completed'    => $item->completed,
            'completed_on' => $item->completed_on,
            'completed_by' => $item->completed_by,
            'name'         => $item->name,
            'email'        => $item->email,
            'issue_url'    => $item->issue_url,
            'id'           => $item->id,
            'project'      => $this->project_id,
        );

        return sprintf( '<button class="button js-screeney-view-issue" data-issue="%s"><span class="dashicons dashicons-visibility"></span></span></buttonclass>', htmlspecialchars( json_encode( $data ) ) );
    }

    public function column_completed( $item ) {
        return $item->completed == 0 ? __( 'No', 'screeney' ) : __( 'Yes', 'screeney' );
    }
}