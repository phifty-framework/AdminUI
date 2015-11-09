<?php
namespace AdminUI;
use WebUI\Components\Menu\MenuItem;

class CRUDMenuItemFactory
{
    static public function create($crudId, $label) {
        $menuItem = new MenuItem($label);

        $menuItem->setLinkAttributes(array(
            'href' => '/bs/' . $crudId,
            'data-crud-id' => $crudId,

            'data-region-path' => "/bs/$crudId/crud/index",
            // let the main panel region to load the index region from CRUDHandler.
            'region' => array('path' => "/bs/$crudId/crud/index"),

            'data-region' => 'pageContent',
            'data-path' => "/bs/$crudId/crud/index",
        ));
        return $menuItem;
    }
}
