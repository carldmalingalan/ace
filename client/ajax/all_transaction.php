
<?php
	require_once "../../support/config.php";
	$primaryKey ='acc_id';
	$index=-1;
	
	$columns = array(
                array('db' => 'payment_id', 'dt' => ++$index),
                array(
                    'db' => 'payment_date', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row){
                        return date_format(date_create($d),'F d, Y h:i:s A');
                    }
                ),
                array(
                    'db' => 'payment_total', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row){
                        return cleanPeso($d);
                    }
                ),
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
        			$action_buttons = "";
                    $action_buttons .= '<form action="print_payment.php" method="POST" target="_blank">';
                    $action_buttons .= '<input type="hidden" name="print_id" value="'.$d.'">';
                    $action_buttons .= '<button type="submit" class="btn bg-grey btn-circle waves-effect waves-float waves-light"><i class="material-icons">print</i></button>';
                    $action_buttons .= '</form>';
                    return $action_buttons;
                }
                )
        	);
	require( '../../support/ssp.class.php' );

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
$complete_query="SELECT A.payment_id,A.payment_date,A.payment_total,B.f_name,B.m_name,B.l_name FROM payment_records A JOIN users B ON A.payment_recipient = B.id WHERE payee_id = {$_SESSION[WEB]['id']}";    

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
$recordsFiltered = $con->myQuery("SELECT A.payment_id,A.payment_date,A.payment_total,B.f_name,B.m_name,B.l_name FROM payment_records A JOIN users B ON A.payment_recipient = B.id WHERE payee_id = {$_SESSION[WEB]['id']}")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>