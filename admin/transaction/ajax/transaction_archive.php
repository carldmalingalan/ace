
<?php
	require_once "../../../support/config.php";
	$primaryKey ='transaction_id';
	$index=-1;
	
	$columns = array(
                array('db' => 'transaction_id', 'dt' => ++$index),
                array('db' => 'reservation_id', 'dt' => ++$index),
                array(
                    'db' => 'f_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        $row['m_name'] = empty($row['m_name']) ? "" : substr($row['m_name'],0,1).".";
                        return htmlspecialchars($d." ".$row['m_name']." ".$row['l_name']);
                    }    
                ),
                array(
                    'db' => 'room_number', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        return cleanHTML($d);
                    }    
                ),
                array(
                    'db' => 'mop_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        return cleanHTML($d);
                    }    
                ),
        		array(
                'db'        => 'transaction_id',
                'dt'        => ++$index,
        		'formatter' => function( $d, $row ) 
                {
                    $action_buttons = "";
                    // if($row['status_name'] == "Pending"){
                    // $action_buttons .= "<button type='button' class='btn btn-circle btn-primary waves-effect waves-float waves-circle' data-toggle='tooltip' data-placement='left' title='Payment info.' onclick='showTrans({$d})'><i class='material-icons'>mode_edit</i></button>";
                    
                    
                    // }
           
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
$where.= !empty($where) ? " AND ".$whereAll:"WHERE ".$whereAll;
$bindings=jp_bind($bindings);
$complete_query=
"SELECT * FROM transaction A 
JOIN users B ON A.user_id = B.id
JOIN room_type C ON A.room_type = C.room_type_id
JOIN mop D ON A.mop = D.mop_id
JOIN rooms E ON A.room_number = E.room_id
WHERE A.is_deleted = 1
";    

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
$recordsFiltered = $con->myQuery("SELECT * FROM transaction A 
JOIN users B ON A.user_id = B.id
JOIN room_type C ON A.room_type = C.room_type_id
JOIN mop D ON A.mop = D.mop_id
WHERE A.is_deleted = 1")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>