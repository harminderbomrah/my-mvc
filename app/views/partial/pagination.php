<?php if($paginate["total_pages"] > 1) { ?>
  <div class="pagination border-bottom text-center">
    <?php 
     $next = $_SERVER['REQUEST_URI'];
     $previous = $_SERVER['REQUEST_URI'];
      if(count($_GET) == 1){
        $next.= "?page=".($_GET["page"] + 1);
        $previous.= "?page=".($_GET["page"] - 1);
      }else if(isset($_GET["page"])){
        $next = str_replace("page={$_GET['page']}", "page=".($_GET["page"] + 1), $next);
        $previous = str_replace("page={$_GET['page']}", "page=".($_GET["page"] - 1), $previous);
      }else if(count($_GET) > 1 && !isset($_GET["page"])){
        $next.= "&page=".($_GET["page"] + 1);
        $previous.= "&page=".($_GET["page"] - 1);
      }
    ?>
    <p class="previous <?= ( !isset($_GET["page"]) || $_GET["page"] <= 1 ? "disabled" : "" ) ?>">
      <a href="<?= $previous ?>"><i class="fa fa-fw fa-arrow-left"></i></a>
    </p>
    <p class="next <?= ( $_GET["page"] == $paginate["total_pages"] ? "disabled" : "" ) ?> ">
      <a href="<?= $next ?>"><i class="fa fa-fw fa-arrow-right"></i></a>
    </p>

   
      <ul class="pagination-list list-inline">
        <?php 
            $start = $_GET["page"] - 2;
            $end = $_GET["page"] + 2;
            if($end > $paginate["total_pages"]){
              $end = $paginate["total_pages"];
              $start = $paginate["total_pages"] - 4;
            }
            if($start < 1){
              $start = 1;
              $end = 5;
            }
            $end = ($end > $paginate["total_pages"] ? $paginate["total_pages"] : $end);
           
            for($i = $start; $i <= $end; $i++){ 
              $qs = $_SERVER['REQUEST_URI'];
              if(count($_GET) == 1){
                $qs.= "?page={$i}";
              }else if(isset($_GET["page"])){
                $qs = str_replace("page={$_GET['page']}", "page={$i}", $qs);
              }else if(count($_GET) > 1 && !isset($_GET["page"])){
                $qs.="&page={$i}";
              }
          ?>
          <li class="pagination-item <?= ($paginate["current_page"] == $i ? "active" : "") ?>"><a href="<?= $qs ?>"><?= $i ?></a></li>
        <?php } ?>
      </ul>  
  </div>
<?php } ?>