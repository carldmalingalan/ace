<?php
	require_once "../../../support/config.php";
	$primaryKey ='ID';
	$index=-1;
	
	$columns = array(
                array('db' => 'ID', 'dt' => ++$index),
                array(
                    'db' => 'promo_name', 
                    'dt' => ++$index,
                    'formatter' => function($d, $row) {
                        return cleanHTML($d);
                    }
                ),
                array(
                    'db' => 'due', 
                    'dt' => ++$index,
                    'formatter' => function($d, $row) {
                        return date_format(date_create($d),"F d, Y");
                    }
                ),
                array(
                    'db' => 'pax', 
                    'dt' => ++$index,
                    'formatter' => function($d, $row) {
                        return cleanHTML($d);
                    }
                ),
                array(
                    'db' => 'cost', 
                    'dt' => ++$index,
                    'formatter' => function($d, $row) {
                        return cleanPeso($d);
                    }
                ),
        		array(
                'db'        => 'ID',
                'dt'        => ++$index,
        		'formatter' => function( $d, $row ) 
                {
                    $action_buttons = "
                        <button class='btn btn-circle btn-danger waves-effect waves-circle waves-float' onclick='deleteMeta({$d})'><i class='material-icons'>delete</i></button>
                        <button class='btn btn-circle btn-primary waves-effect waves-circle waves-float' onclick='editMeta({$d})'><i class='material-icons'>mode_edit</i></button>
                    ";
                    return $action_buttons;
                }
                )
        	);
	require( '../../../support/ssp.class.php' );

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::order( $_GET, $columns );

		$where = SSP::filter( $_GET, $columns, $bindings );
		$whereAll="";
		$whereResult="";

		$filter_sql="";
		$whereAll=" is_deleted = 0" ;
		$whereAll.=$filter_sql;
		function jp_bind($bindings)
{
    $return_array=array();
    if ( is_array( $bindings ) ) 
    {
        for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) 
        {
            //$binding = $bindings[$i];
            // $stmt->bindValueb   	qA@( $binding['key'], $binding['val'], $binding['type'] );
            $return_array[$bindings[$i]['key']]=$bindings[$i]['val'];
        }
    }
    return $return_array;
}
// $where.= !empty($where) ? " AND ".$whereAll:"WHERE ".$whereAll;
$bindings=jp_bind($bindings);
$complete_query="SELECT * FROM promos WHERE is_deleted = 0";    

//NEED TO CREATE VIEWS.
$sub_complete = $complete_query;

// Magic function
        function returnNumRow($sub) {
                global $con;
                $sub .= " ";
                $val = $con->myQuery($sub)->rowCount();
                return $val;
        }


// var_dump($recordsFiltered);
// print_r($recordsFiltered);
$data= $con->myQuery($complete_query,$bindings)->fetchAll();
$recordsFiltered = $con->myQuery("SELECT * FROM promos WHERE is_deleted = 0")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>