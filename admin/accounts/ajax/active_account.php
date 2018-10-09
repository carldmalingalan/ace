<?php
	require_once "../../../support/config.php";
	$primaryKey ='acc_id';
	$index=-1;
	
	$columns = array(
                array('db' => 'id', 'dt' => ++$index),
                array('db' => 'username', 'dt' => ++$index),
                array(
                    'db' => 'f_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row){
                        return htmlspecialchars($d." ".substr($row['m_name'],0,1).". ".$row['l_name']);
                    }
                ),
                array(
                    'db' => 'status_name', 
                    'dt' => ++$index,
                    'formatter' => function($d,$row) {
                        $badge = "";
                        switch($row['status_id']){
                            case 1:
                            $badge = "green";
                            break;
                            case 2:
                            $badge = "red";
                            break;
                            case 3:
                            $badge = "yellow";
                            break;

                        }
                        return '<span class="badge badge-pill bg-'.$badge.' text-center"> '.$d.' </span>';
                    }    
                ),
        		array(
                'db'        => 'id',
                'dt'        => ++$index,
        		'formatter' => function( $d, $row ) 
                {
        			$action_buttons = "";
                    $action_buttons .= "<button class='btn btn-sm btn-circle btn-primary waves-effect m-l-5 m-t-5 edit-user' onclick='userModal({$d});'><span class='fa fa-user-edit'></span></button>";
                    if($row['is_activated'] == 1){
                        $action_buttons .= "<button class='btn btn-sm btn-circle btn-danger waves-effect m-l-5 m-t-5' type='button' onclick='confirmDeact({$d})'><span class='fa fa-user-times'></span></button>";
                    }else{
                        $action_buttons .= "<button class='btn btn-sm btn-circle btn-success waves-effect m-l-5 m-t-5' type='button' onclick='confirmActive({$d})'><span class='fa fa-user-check'></span></button>";                       
                    }
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
$complete_query="SELECT * FROM users A JOIN acc_status B ON A.is_activated = B.status_id WHERE A.is_activated = 1 AND A.is_deleted = 0";    

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
$recordsFiltered = $con->myQuery("SELECT * FROM users WHERE is_activated = 1 AND is_deleted = 0")->rowCount();



$json['draw']=isset ( $request['draw'] ) ?intval( $request['draw'] ) :0;
$json['recordsTotal']=$recordsFiltered;
$json['recordsFiltered']=$recordsFiltered;
$json['data']=SSP::data_output($columns,$data);


// print_r($json);


echo json_encode($json);
	die;
?>