<?php
// Helper returning the result of a data retrieval operation in a convenient form
class Helper{
	public static function select($db, $query, $type = 0){
		$result = mysqli_query($db, $query);
		$resultAsArray=array();
		$count = 0;
		while($row = mysqli_fetch_array($result)){
			$resultAsArray[$count] = $row;
			$count++;
		}
		if($type == 1){ 
			return $resultAsArray[0]; 
		}
		if($type == 2){ 
			return $resultAsArray[0][0]; 
		}
		return $resultAsArray;
	}
}
?>