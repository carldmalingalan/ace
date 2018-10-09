
<?php
	require_once "../../../support/config.php";
	$primaryKey ='payment_id';
	$index=-1;
	
	$columns = array(
                array('db' => 'payment_id', 'dt' => ++$index),
                array('db' => 'transaction_id', 'dt' => ++$index),
                array('db' => 'reservation_id', 'dt' => ++$index),
                array(
                    'db' => 'f_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        return cleanHTML(fullName($d,$row['m_name'],$row['l_name']));
                    }    
                ),
        		array(
                'db'        => 'payment_id',
                'dt'        => ++$index,
        		'formatter' => function( $d, $row ) 
                {
                    $action_buttons = "<button type='button' class='btn btn-circle m-l-5 btn-primary waves-effect waves-float waves-circle' onclick='showInfo({$d})' data-toggle='tooltip' data-placement='left' title='See payment' ><i class='material-icons'>mode_edit</i></button>";
                    // if($row['status_name'] == "Pending"){
                    // $action_buttons .= "<button type='button' class='btn btn-circle btn-primary waves-effect waves-float waves-circle' data-toggle='tooltip' data-placement='left' title='Payment info.' onclick='showTrans({$d})'><i class='material-icons'>mode_edit</i></button>";
                    // if($row['balance'] == 0){
                    //     $action_buttons .=  "<button type='button' class='btn btn-circle m-l-5 btn-warning waves-effect waves-float waves-circle' data-toggle='tooltip' data-placement='left' title='Archive payment' ><i class='material-icons'>archive</i></button>                    ";
                    // }
                    
                    
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
"SELECT payment_id,reservation_id,transaction_id,payee_id,f_name,m_name,l_name FROM payment_records A JOIN users B ON A.payee_id = B.id WHERE A.is_deleted = 0";    

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
$recordsFiltered = $con->myQuery("SELECT payment_id,reservation_id,transaction_id,payee_id,f_name,m_name,l_name FROM payment_records A JOIN users B ON A.payee_id = B.id WHERE A.is_deleted = 0")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>