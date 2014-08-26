<?php
class ApplicationController extends MvcController{
  public $entries_per_page = 2;
  function authenticate_user(){
    $this->current_user->needs_authentication();
  }	

  function paginate_records($records){
    $this->paginate = array(
        "total_pages" => ceil(count($records) / $this->entries_per_page),
        "current_page" => ($this->params["page"] ? $this->params["page"] : 1)
    );
    if($this->paginate["current_page"] <= $this->paginate["total_pages"] && $this->paginate["current_page"] > 0){
        $start = ($this->paginate["current_page"] -1) * $this->entries_per_page;
        $end = (($start + $this->entries_per_page) > count($records) ? count($records) : $start + $this->entries_per_page);
        $paginated_data = array();
        for($i = $start; $i < $end; $i++){
          array_push($paginated_data, $records[$i]);
        }
        return $paginated_data;
    }else{
      return null;
    }
  }
}

?>