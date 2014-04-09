<?php

class RelationManager{

	public static $relations = array();

	function __construct(){}

	public static function create_relation($model1,$model2){

		function check_for_relation($model1,$model2){
			if(class_exists($model1) && class_exists($model2)){
				$m1 = new $model1();
				$m2 = new $model2();
				if($m1 instanceof ModelAdapter && $m2 instanceof ModelAdapter){
					$present = false;
					$model1 = RelationManager::tabelize($model1);
					$model2 = RelationManager::tabelize($model2);
					$t1 = array($model1,$model2);
					$t2 = array($model2,$model1);
					foreach (RelationManager::$relations as $r) {
						if($r === $t1 || $r === $t2){
							$present = true;
							break;
						}
					}
					return $present;
				}else{
					throw new Exception("Models should be instance of ModelAdapter.");
				}
			}else{
				throw new Exception("Cannot create relationship between {$model1} and {$model2} because models doesn't exists.");
			}
		}

		function check_and_create_table($model1, $model2){
			$db = new dbConnect();

			$model1 = RelationManager::tabelize($model1);
			$model2 = RelationManager::tabelize($model2);

			$result = (int)$db->query("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DATABASE_NAME . "' AND TABLE_NAME = '{$model1}_{$model2}_mvcrelation' OR TABLE_NAME = '{$model2}_{$model1}_mvcrelation';")[0]['count'];

			if($result == 0){
				$db->query("CREATE TABLE {$model1}_{$model2}_mvcrelation (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), {$model1}_id INT, {$model2}_id INT   );");
			}
			$db->destruct();
		}

		if(!check_for_relation($model1,$model2)){
			check_and_create_table($model1,$model2);
			$model1 = RelationManager::tabelize($model1);
			$model2 = RelationManager::tabelize($model2);
			array_push(RelationManager::$relations,array($model1,$model2));
		}
	}

	public static function tabelize($name){
		$name = preg_replace('/(?!^)[A-Z]/', "_$0" ,$name);
		return strtolower($name);
	}

	public static function relations(){
		return RelationManager::$relations;
	}

	public static function get_relation_table_for_models($model1,$model2){
		$model1 = RelationManager::tabelize($model1);
		$model2 = RelationManager::tabelize($model2);
		$db = new dbConnect();
		$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DATABASE_NAME . "' AND TABLE_NAME = '{$model1}_{$model2}_mvcrelation' OR TABLE_NAME = '{$model2}_{$model1}_mvcrelation';";
		$result = $db->query($query);
		if($result != null){
			return $result[0]['TABLE_NAME'];
		}else{
			return null;
		}
		$db->destruct();
	}

	public static function get_relations_for_model($model){
		$model = RelationManager::tabelize($model);
		$temp_relations = array_filter(RelationManager::$relations,function($array) use($model){ return(in_array($model, $array)); });
		$relations = array();
		foreach ($temp_relations as $relation) {
			$position = (array_search($model, $relation) == 0 ? 1 : 0);
			array_push($relations,$relation[$position]);
		}
		return $relations;
	}

}

?>