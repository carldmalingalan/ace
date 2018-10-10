
<?php
	require_once "../../../support/config.php";
	$primaryKey ='reservation_id';
	$index=-1;
	
	$columns = array(
                array('db' => 'reservation_id', 'dt' => ++$index),
                array(
                    'db' => 'f_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row){
                        $row['m_name'] = empty($row['m_name']) ? "" : substr($row['m_name'],0,1).".";
                        return htmlspecialchars($d." ".$row['m_name']." ".$row['l_name']);
                    }
                ),
                array(
                    'db' => 'reservation_date', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        return date_format(date_create($d),"F d, Y h:i:s A");
                    }    
                ),
                array(
                    'db' => 'status_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        $badge = "";
                        switch($row['reservation_status']){
                            case 1:
                            $badge = "amber";
                            break;
                            case 2:
                            $badge = "green";
                            break;
                            case 3:
                            $badge = "red";
                            break;
                        }
                        return '<span class="badge bg-'.$badge.' text-center"> '.ucfirst(cleanHTML($d)).' </span>';
                    }    
                ),
        		array(
                'db'        => 'reservation_id',
                'dt'        => ++$index,
        		'formatter' => function( $d, $row ) 
                {
                    $action_buttons = "";
                    // if($row['status_name'] == "Pending"){
                    $action_buttons .= "<button type='button' class='btn m-l-5 m-t-5 btn-circle btn-success waves-float waves-circle waves-effect' onclick='showInfo({$d})'><i class='material-icons'>build</i></button>";
                    $action_buttons .= "<button type='button' class='btn m-l-5 m-t-5 btn-circle bg-orange waves-float waves-circle waves-effect' onclick='archiveInfo({$d})'><i class='material-icons'>archive</i></button>";
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
"SELECT * FROM account_reservations A
JOIN users B ON A.user_id = B.id
JOIN reservation_status C ON A.reservation_status = C.status_id
WHERE A.is_deleted = 0
ORDER BY A.reservation_date DESC
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
$recordsFiltered = $con->myQuery("SELECT * FROM account_reservations A
JOIN users B ON A.user_id = B.id
JOIN reservation_status C ON A.reservation_status = C.status_id
WHERE A.is_deleted = 0
ORDER BY A.reservation_date DESC")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>