<?php
namespace AdminUI;
use WebUI\Components\Menu\MenuItem;

class MenuItemFactory
{
    static public function createMenuItemForCRUD($crudId, $label) {

        $menuItem = new MenuItem($label, array(
            'href' => '/bs/' . $crudId,
            'data-crud-id' => $crudId,
            'data-region-path' => "/bs/$crudId/crud/index",
            // let the main panel region to load the index region from CRUDHandler.
            'region' => array('path' => "/bs/$crudId/crud/index"),
        ));
        return $menuItem;
    }
}