<?php
  RelationManager::create_relation("Users","Products");
  RelationManager::create_relation("Articles","Products");
  RelationManager::create_relation("Articles","Tags");
  RelationManager::create_relation("Articles","Category");
?>
