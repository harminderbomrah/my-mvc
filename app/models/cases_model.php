 <?php

class Cases extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function cases_for_home(){
      $cases = self::query_db("SELECT A.id,A.title,A.publishDate,A.created_date,B.name AS `category` FROM `cases` AS `A`, `category` AS `B`, `cases_category_mvcrelation` AS `C` WHERE A.id = C.cases_id AND C.category_id = B.id ORDER BY `top` DESC, `hot` DESC, `publishDate` DESC, `created_date` DESC LIMIT 3");
      if($cases==null){
        $cases = [];
      }else{
        foreach ($cases as $key=>$case) {
          if($case['publishDate']=="0000-00-00 00:00:00"){
            $cases[$key]['date'] = strftime("%b %d, %Y",strtotime($cases[$key]['created_date']));
          }else{
            $cases[$key]['date'] = strftime("%b %d, %Y",strtotime($case['publishDate']));
          }
          $assets = self::query_db("SELECT assets_id FROM cases_assets_mvcrelation WHERE cases_id = '{$case['id']}' LIMIT 0,1");
          if($assets != null){
            $cases[$key]["img"] = '/'.Assets::find($assets[0]["assets_id"])->file['large']->path;
          }
        }
      }
      return $cases;
    }

    public static function all_with_quantity(){
      $cases = self::query_db("SELECT a.id, a.title FROM cases a");
      return $cases;
    }

    public static function all_array($category=null, $tag=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($tag!=null){
       $tag_filter = "AND A.id = C.cases_id AND C.tags_id={$tag}";
       $put_table = ", cases_tags_mvcrelation AS C";
      }
      if($frontend) $trash_filter = "AND A.trash = false AND (A.publishDate<=NOW() OR A.publishDate=0) AND (A.endDate>NOW() OR A.endDate=0)";
   

      $cases = self::query_db("
        SELECT 
          A.id, 
          A.title, 
          UNIX_TIMESTAMP(A.publishDate)*1000 as `publishDate`, 
          A.endDate, 
          A.disabled, 
          A.trash, 
          A.top, 
          A.hot, 
          A.created_date, 
          B.category_id AS category
          {$put_table}
        FROM 
          cases AS A,
          cases_category_mvcrelation AS B
        WHERE
          A.id = B.cases_id {$category_filter} {$tag_filter} {$trash_filter} GROUP BY A.id
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

          $assets = self::query_db("SELECT assets_id FROM cases_assets_mvcrelation WHERE cases_id = '{$case['id']}'");
          $images = [];
          if($assets != null){
            foreach ($assets as $a) {
              array_push($images, Assets::find($a["assets_id"])->file["medium"]);
            }
          }

          $cases[$key]['image'] = $images;
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
      if(!$case->can_publish()){
        return null;
      }
      $tags = [];
      foreach ($case->tags_relation_ids as $tag_id) {
        array_push($tags,Tags::find($tag_id)->name);
      }

      $products = [];
      foreach ($case->products_relation_ids as $product_id) {
        $product = Products::find($product_id);
        $img = self::query_db("SELECT assets_id FROM products_assets_mvcrelation WHERE products_id = '{$product_id}' LIMIT 0,1");
        $image = Assets::find($img[0]["assets_id"])->file["large"];
        array_push($products,array("title"=>$product->title, "id"=>$product->id, "depiction"=>$product->depiction, "image"=>$image));
      }

      $links = [];
      foreach ($case->links_relation_ids as $link_id) {
        $link = Links::find($link_id);
        array_push($links,array("name"=>$link->name, "url"=>$link->url));
      }

      $status = [];
      if($case->hot) array_push($status, "Hot");
      if($case->top) array_push($status, "Top");

      $assets = $case->assets_relation_ids;
      $images = [];
      if($assets != null){
        foreach ($assets as $a) {
          array_push($images, Assets::find($a));
        }
      }

      return array(
        "title" => $case->title,
        "date" => strftime("%b %d, %Y",strtotime(($case->publishDate != "0000-00-00 00:00:00" ? $case->publishDate : $case->created_date ))),
        "content" => $case->content,
        "imgs" => $images,
        "location" => $case->location,
        "status" => $status,
        "category" => Category::find($case->category_relation_ids[0])->name,
        "tags" => $tags,
        "products" => $products,
        "links" => $links,
        "info" => []
      );
    }

    function can_publish(){
      if($this->publishDate == "0000-00-00 00:00:00"){
        return true;
      }
      $pdate = DateTime::createFromFormat("Y-m-d",strftime("%Y-%m-%d",strtotime($this->publishDate)));
      $edate = DateTime::createFromFormat("Y-m-d",strftime("%Y-%m-%d",strtotime($this->endDate)));
      $date = new DateTime();
      if($pdate <= $date && $edate >= $date){
        return true;
      }else{
        return false;
      }
    }
}

?>