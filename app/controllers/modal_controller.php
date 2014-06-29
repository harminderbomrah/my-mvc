<?php

class modalController extends ApplicationController{
  var $controller_layout = "modal";
  function index() {
    return render();
  }
  function fileManage() {
    $this->initial = array(
      "file" => array(
        array("id" => 134512, "name" => "stone01", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone01.jpg",
          "medium" => "/public/file/image/m_stone01.jpg",
          "large" => "/public/file/image/l_stone01.jpg",
          "original" => "/public/file/image/stone01.jpg"
        )),
        array("id" => 683432, "name" => "stone02", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone02.jpg",
          "medium" => "/public/file/image/m_stone02.jpg",
          "large" => "/public/file/image/l_stone02.jpg",
          "original" => "/public/file/image/stone02.jpg"
        )),
        array("id" => 923741, "name" => "stone03", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone03.jpg",
          "medium" => "/public/file/image/m_stone03.jpg",
          "large" => "/public/file/image/l_stone03.jpg",
          "original" => "/public/file/image/stone03.jpg"
        )),
        array("id" => 965728, "name" => "stone04", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone04.jpg",
          "medium" => "/public/file/image/m_stone04.jpg",
          "large" => "/public/file/image/l_stone04.jpg",
          "original" => "/public/file/image/stone04.jpg"
        )),
        array("id" => 456891, "name" => "stone05", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone05.jpg",
          "medium" => "/public/file/image/m_stone05.jpg",
          "large" => "/public/file/image/l_stone05.jpg",
          "original" => "/public/file/image/stone05.jpg"
        )),
        array("id" => 763452, "name" => "stone06", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone06.jpg",
          "medium" => "/public/file/image/m_stone06.jpg",
          "large" => "/public/file/image/l_stone06.jpg",
          "original" => "/public/file/image/stone06.jpg"
        )),
        array("id" => 904246, "name" => "stone07", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone07.jpg",
          "medium" => "/public/file/image/m_stone07.jpg",
          "large" => "/public/file/image/l_stone07.jpg",
          "original" => "/public/file/image/stone07.jpg"
        )),
        array("id" => 782469, "name" => "stone08", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone08.jpg",
          "medium" => "/public/file/image/m_stone08.jpg",
          "large" => "/public/file/image/l_stone08.jpg",
          "original" => "/public/file/image/stone08.jpg"
        )),
        array("id" => 893279, "name" => "stone09", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone09.jpg",
          "medium" => "/public/file/image/m_stone09.jpg",
          "large" => "/public/file/image/l_stone09.jpg",
          "original" => "/public/file/image/stone09.jpg"
        )),
        array("id" => 004352, "name" => "stone10", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone10.jpg",
          "medium" => "/public/file/image/m_stone10.jpg",
          "large" => "/public/file/image/l_stone10.jpg",
          "original" => "/public/file/image/stone10.jpg"
        )),
        array("id" => 121783, "name" => "stone11", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone11.jpg",
          "medium" => "/public/file/image/m_stone11.jpg",
          "large" => "/public/file/image/l_stone11.jpg",
          "original" => "/public/file/image/stone11.jpg"
        )),
        array("id" => 727682, "name" => "stone12", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone12.jpg",
          "medium" => "/public/file/image/m_stone12.jpg",
          "large" => "/public/file/image/l_stone12.jpg",
          "original" => "/public/file/image/stone12.jpg"
        )),
        array("id" => 893272, "name" => "stone13", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone13.jpg",
          "medium" => "/public/file/image/m_stone13.jpg",
          "large" => "/public/file/image/l_stone13.jpg",
          "original" => "/public/file/image/stone13.jpg"
        )),
        array("id" => 663278, "name" => "stone14", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone14.jpg",
          "medium" => "/public/file/image/m_stone14.jpg",
          "large" => "/public/file/image/l_stone14.jpg",
          "original" => "/public/file/image/stone14.jpg"
        )),
        array("id" => 246782, "name" => "stone15", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone15.jpg",
          "medium" => "/public/file/image/m_stone15.jpg",
          "large" => "/public/file/image/l_stone15.jpg",
          "original" => "/public/file/image/stone15.jpg"
        )),
        array("id" => 832472, "name" => "stone16", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone16.jpg",
          "medium" => "/public/file/image/m_stone16.jpg",
          "large" => "/public/file/image/l_stone16.jpg",
          "original" => "/public/file/image/stone16.jpg"
        )),
        array("id" => 768315, "name" => "stone17", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone17.jpg",
          "medium" => "/public/file/image/m_stone17.jpg",
          "large" => "/public/file/image/l_stone17.jpg",
          "original" => "/public/file/image/stone17.jpg"
        )),
        array("id" => 935629, "name" => "stone18", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone18.jpg",
          "medium" => "/public/file/image/m_stone18.jpg",
          "large" => "/public/file/image/l_stone18.jpg",
          "original" => "/public/file/image/stone18.jpg"
        )),
        array("id" => 589035, "name" => "stone19", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone19.jpg",
          "medium" => "/public/file/image/m_stone19.jpg",
          "large" => "/public/file/image/l_stone19.jpg",
          "original" => "/public/file/image/stone19.jpg"
        )),
        array("id" => 802468, "name" => "stone20", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone20.jpg",
          "medium" => "/public/file/image/m_stone20.jpg",
          "large" => "/public/file/image/l_stone20.jpg",
          "original" => "/public/file/image/stone20.jpg"
        )),
        array("id" => 890356, "name" => "stone21", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone21.jpg",
          "medium" => "/public/file/image/m_stone21.jpg",
          "large" => "/public/file/image/l_stone21.jpg",
          "original" => "/public/file/image/stone21.jpg"
        )),
        array("id" => 793517, "name" => "stone22", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone22.jpg",
          "medium" => "/public/file/image/m_stone22.jpg",
          "large" => "/public/file/image/l_stone22.jpg",
          "original" => "/public/file/image/stone22.jpg"
        )),
        array("id" => 045619, "name" => "stone23", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone23.jpg",
          "medium" => "/public/file/image/m_stone23.jpg",
          "large" => "/public/file/image/l_stone23.jpg",
          "original" => "/public/file/image/stone23.jpg"
        )),
        array("id" => 467035, "name" => "stone24", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone24.jpg",
          "medium" => "/public/file/image/m_stone24.jpg",
          "large" => "/public/file/image/l_stone24.jpg",
          "original" => "/public/file/image/stone24.jpg"
        )),
        array("id" => 935627, "name" => "stone25", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone25.jpg",
          "medium" => "/public/file/image/m_stone25.jpg",
          "large" => "/public/file/image/l_stone25.jpg",
          "original" => "/public/file/image/stone25.jpg"
        )),
        array("id" => 468035, "name" => "stone26", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone26.jpg",
          "medium" => "/public/file/image/m_stone26.jpg",
          "large" => "/public/file/image/l_stone26.jpg",
          "original" => "/public/file/image/stone26.jpg"
        )),
        array("id" => 368285, "name" => "stone27", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone27.jpg",
          "medium" => "/public/file/image/m_stone27.jpg",
          "large" => "/public/file/image/l_stone27.jpg",
          "original" => "/public/file/image/stone27.jpg"
        )),
        array("id" => 239367, "name" => "stone28", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone28.jpg",
          "medium" => "/public/file/image/m_stone28.jpg",
          "large" => "/public/file/image/l_stone28.jpg",
          "original" => "/public/file/image/stone28.jpg"
        )),
        array("id" => 582256, "name" => "stone29", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone29.jpg",
          "medium" => "/public/file/image/m_stone29.jpg",
          "large" => "/public/file/image/l_stone29.jpg",
          "original" => "/public/file/image/stone29.jpg"
        )),
        array("id" => 799356, "name" => "stone30", "type" => "jpg", "source" => array(
          "small" => "/public/file/image/s_stone30.jpg",
          "medium" => "/public/file/image/m_stone30.jpg",
          "large" => "/public/file/image/l_stone30.jpg",
          "original" => "/public/file/image/stone30.jpg"
        ))
      )
    );
    return render();
  }
  function delete_confirm() {
    return render();
  }
  function delete_category() {
    return render();
  }
  function delete_tag() {
    return render();
  }
}
?>