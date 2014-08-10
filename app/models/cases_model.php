 <?php

class Cases extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function cases_for_home(){
      $cases = self::query_db("SELECT A.id,A.title,A.publishDate,A.created_date,A.img,B.name AS `category` FROM `cases` AS `A`, `category` AS `B`, `cases_category_mvcrelation` AS `C` WHERE A.id = C.cases_id AND C.category_id = B.id ORDER BY `top` DESC, `hot` DESC, `publishDate` DESC, `created_date` DESC LIMIT 3");
      if($cases==null){
        $cases = [];
      }else{
        foreach ($cases as $key=>$case) {
          if($case['publishDate']=="0000-00-00 00:00:00"){
            $cases[$key]['date'] = strftime("%b %d, %Y",strtotime($cases[$key]['created_date']));
          }else{
            $cases[$key]['date'] = strftime("%b %d, %Y",strtotime($case['publishDate']));
          }
          $cases[$key]["img"] = ($case["img"] ? '/'.Assets::find($case["img"])->file['large']->path : "");
        }
      }
      return $cases;
    }

    public static function all_with_quantity(){
      $cases = self::query_db("SELECT a.id, a.title FROM cases a");
      return $cases;
    }

    public static function all_array($category=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($frontend) $trash_filter = "AND A.trash = false";

      $cases = self::query_db("
        SELECT 
          A.id, 
          A.title, 
          UNIX_TIMESTAMP(A.publishDate)*1000 as `publishDate`, 
          A.endDate, 
          A.disabled, 
          A.trash, 
          A.top, 
          A.img,
          A.hot, 
          A.created_date, 
          B.category_id AS category
        FROM 
          cases A,
          cases_category_mvcrelation AS B 
        WHERE
          A.id = B.cases_id {$category_filter} {$trash_filter}
          ");
      if($cases==null){
        $cases = [];
      }else{
        foreach ($cases as $key=>$case) {
          $cases[$key]['tags'] = self::query_db("SELECT * FROM tags WHERE id IN (SELECT tags_id FROM cases_tags_mvcrelation WHERE cases_id = '{$case['id']}')");

          if($cases[$key]['tags']==null) $cases[$key]['tags'] = [];

          if($case['publishDate']=="0"){
            $cases[$key]['publishDate'] = strtotime($cases[$key]['created_date'])*1000;
          }
          $img = ($case["img"] ? Assets::find($case["img"])->file["large"] : "");
          $cases[$key]['image'] = $img;
          $cases[$key]['trash'] = ($case['trash']==1) ? true : false;
          $cases[$key]['top'] = ($case['top']==1) ? true : false;
          $cases[$key]['hot'] = ($case['hot']==1) ? true : false;
          $cases[$key]['disabled'] = ($case['disabled']==1) ? true : false;
        }
      }
      return $cases;
    }

    public static function get_case($id){
      $case = Cases::find($id);

      $tags = [];
      foreach ($case->tags_relation_ids as $tag_id) {
        array_push($tags,Tags::find($tag_id)->name);
      }

      $products = [];
      foreach ($case->products_relation_ids as $product_id) {
        $product = Products::find($product_id);
        array_push($products,array("title"=>$product->title, "id"=>$product->id));
      }

      $links = [];
      foreach ($case->links_relation_ids as $link_id) {
        $link = Links::find($link_id);
        array_push($links,array("name"=>$link->name, "url"=>$link->url));
      }

      $status = [];
      if($case->hot) array_push($status, "Hot");
      if($case->top) array_push($status, "Top");

      return array(
        "title" => $case->title,
        "content" => $case->content,
        "img" => $case->img,
        "location" => $case->location,
        "status" => $status,
        "category" => Category::find($case->category_relation_ids[0])->name,
        "tags" => $tags,
        "products" => $products,
        "links" => $links
      );
    }
}

?>