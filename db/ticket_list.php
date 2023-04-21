<?php 

include_once 'config.php'; 

/**
 * Reference: https://www.codexworld.com/datatables-crud-operations-with-php-mysql/
 * 
 */

// Database connection info 
$dbDetails = array( 
    'host' => DB_HOST, 
    'user' => DB_USER, 
    'pass' => DB_PASS, 
    'db'   => DB_NAME 
); 
 
// DB table to use 
// $table = 'tickets';
$table = <<<EOT
 (
    SELECT 
    tickets.id, tickets.ticket_id as ticket_id, tickets.type_id as type_id,  tickets.c_status as c_status,   tickets.assignee_id as assignee_id, 
    tickets.assigned_date as assigned_date, tickets.plan_start_date as plan_start_date, tickets.plan_end_date as plan_end_date, tickets.actual_start_date as actual_start_date, tickets.actual_end_date as actual_end_date, tickets.planned_hrs as planned_hrs, tickets.actual_hrs as actual_hrs,
    ticket_types.type_name as ticket_type ,  c_status_types.type_name as c_type_name, assignees.name as assignee
    FROM tickets 
    LEFT JOIN ticket_types
    ON tickets.type_id = ticket_types.id
    LEFT JOIN c_status_types
    ON tickets.c_status = c_status_types.id
    LEFT JOIN 	assignees
    ON tickets.assignee_id = assignees.id
    ORDER BY tickets.id DESC
 ) temp
EOT; 
// $table = <<<EOT
//  (
//     SELECT 
//     tickets.*, ticket_types.type_name as ticket_type ,  c_status_types.type_name as c_type_name, assignees.name as assignee
//     FROM tickets 
//     LEFT JOIN ticket_types
//     ON tickets.type_id = ticket_types.id
//     LEFT JOIN c_status_types
//     ON tickets.c_status = c_status_types.id
//     LEFT JOIN 	assignees
//     ON tickets.assignee_id = assignees.id
//      ORDER BY tickets.id DESC
//  ) temp
// EOT; 
 
// Table's primary key 
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    // array( 'db' => 'type_id', 'dt' => -1 ), 
    // array( 'db' => 'c_status', 'dt' => -1 ), 
    // array( 'db' => 'assignee_id', 'dt' => -1 ), 

    array( 'db' => 'ticket_id', 'dt' => 0 ), 
    array( 'db' => 'ticket_type',  'dt' => 1 ), 
    array( 'db' => 'c_type_name',      'dt' => 2 ), 
    array( 'db' => 'assignee',     'dt' => 3 ), 
    array( 
        'db'        => 'assigned_date', 
        'dt'        => 4, 
        'formatter' => function( $d, $row ) { 
            return ($d != '0000-00-00 00:00:00') ?  date( 'jS M Y', strtotime($d)) : '';
            // return date( 'jS M Y', strtotime($d)); 
        } 
    ), 
    array( 
        'db'        => 'plan_start_date', 
        'dt'        => 5, 
        'formatter' => function( $d, $row ) { 
            return ($d != '0000-00-00 00:00:00') ?  date( 'jS M Y', strtotime($d)) : '';
        } 
    ),
    array( 
        'db'        => 'plan_end_date', 
        'dt'        => 6, 
        'formatter' => function( $d, $row ) { 
           return ($d != '0000-00-00 00:00:00') ?  date( 'jS M Y', strtotime($d)) : ''; 
        } 
    ),
    array( 
        'db'        => 'actual_start_date', 
        'dt'        => 7, 
        'formatter' => function( $d, $row ) { 
           return ($d != '0000-00-00 00:00:00') ?  date( 'jS M Y', strtotime($d)) : ''; 
        } 
    ),
    array( 
        'db'        => 'actual_end_date', 
        'dt'        => 8, 
        'formatter' => function( $d, $row ) { 
           return ($d != '0000-00-00 00:00:00') ?  date( 'jS M Y', strtotime($d)) : ''; 
        } 
    ),

    array( 
        'db'        => 'planned_hrs', 
        'dt'        => 9, 
        'formatter' => function( $d, $row ) { 
           return ($d != '0.00') ?  $d : ''; 
        } 
    ),
    array( 
        'db'        => 'actual_hrs', 
        'dt'        => 10, 
        'formatter' => function( $d, $row ) { 
           return ($d != '0.00') ?  $d : ''; 
        } 
    ),
    // array( 'db' => 'planned_hrs',     'dt' => 9 ), 
    // array( 'db' => 'actual_hrs',     'dt' => 10 ), 

    array( 
        'db'        => 'planned_hrs', 
        'dt'        => 11, 
        'formatter' => function( $d, $row ) {
            $variance = $row['planned_hrs'] - $row['actual_hrs'];// json_encode($row);
            return ($variance != '0') ?  $variance : ''; 
        } 
    ), 
    array( 
        'db'        => 'id', 
        'dt'        => 12,
        'formatter' => function( $d, $row ) { 
            
            return ' 
                <a href="javascript:void(0);" class="btn btn-warning" onclick="editData('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')">Edit</a>&nbsp; 
            '; 
        } 
    ),
    // array( 
    //     'db'        => 'id', 
    //     'dt'        => 7, 
    //     'formatter' => function( $d, $row ) { 
    //         return ' 
    //             <a href="javascript:void(0);" class="btn btn-warning" onclick="editData('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')">Edit</a>&nbsp; 
    //             <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteData('.$d.')">Delete</a> 
    //         '; 
    //     } 
    // )  
); 
 
// Include SQL query processing class 
require '../libraries/DataTables/ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);
