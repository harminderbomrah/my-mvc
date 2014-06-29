 <?php

class Cases extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_with_quantity(){
      $cases = self::query_db("SELECT a.id, a.title FROM cases a");
      return $cases;
    }

    public static function all_array(){
      $cases = self::query_db("SELECT a.id, a.title, UNIX_TIMESTAMP(a.publishDate)*1000 as `publishDate`, a.endDate, a.disabled, a.trash, a.top, a.hot, a.created_date, (SELECT category_id FROM cases_category_mvcrelation WHERE cases_id = a.id) as category FROM cases a");
      if($cases==null){
        $cases = [];
      }else{
        foreach ($cases as $key=>$case) {
          if($case['publishDate']=="0"){
            $cases[$key]['publishDate'] = strtotime($cases[$key]['created_date'])*1000;
          }
          $cases[$key]['trash'] = ($case['trash']==1) ? true : false;
          $cases[$key]['top'] = ($case['top']==1) ? true : false;
          $cases[$key]['hot'] = ($case['hot']==1) ? true : false;
          $cases[$key]['disabled'] = ($case['disabled']==1) ? true : false;
        }
      }
      return $cases;
    }
}

?>