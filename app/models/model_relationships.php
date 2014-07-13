<?php
  RelationManager::create_relation("Users","Products");
  RelationManager::create_relation("Articles","Products");
  RelationManager::create_relation("Articles","Cases");
  RelationManager::create_relation("Articles","Tags");
  RelationManager::create_relation("Articles","Links");
  RelationManager::create_relation("Articles","Category");

  RelationManager::create_relation("Cases","Products");
  RelationManager::create_relation("Cases","Tags");
  RelationManager::create_relation("Cases","Links");
  RelationManager::create_relation("Cases","Category");

  RelationManager::create_relation("Products","Category");
  RelationManager::create_relation("Products","ProductSpecs");
  RelationManager::create_relation("Products","Tags");
  RelationManager::create_relation("Products","Assets");
?>
