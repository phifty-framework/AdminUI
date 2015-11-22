<?php
namespace AdminUI;
use WebUI\Components\Menu\MenuItem;

class CRUDMenuItemFactory
{


    static public function viewRecordPage($crudId, $recordId, $label)
    {
        $queryString = http_build_query([ 'id' => intval($recordId), '_form_controls' => true, ]);
        $menuItem = new MenuItem($label);
        $menuItem->setLinkAttributes(array(
            'href' => '/bs/' . $crudId . '/view?' . $queryString,
            'data-crud-id' => $crudId,
            'data-region-path' => "/bs/$crudId/crud/view?" . $queryString,

            // let the main panel region to load the index region from CRUDHandler.
            'region' => array('path' => "/bs/$crudId/crud/view?" . $queryString),

            'data-region' => 'pageContent',
            'data-path' => "/bs/$crudId/crud/view?" . $queryString,
        ));
        return $menuItem;
    }


    static public function editRecordPage($crudId, $recordId, $label)
    {
        $queryString = http_build_query([ 'id' => intval($recordId), '_form_controls' => true, ]);
        $menuItem = new MenuItem($label);
        $menuItem->setLinkAttributes(array(
            'href' => '/bs/' . $crudId . '/edit?' . $queryString,
            'data-crud-id' => $crudId,
            'data-region-path' => "/bs/$crudId/crud/edit?" . $queryString,

            // let the main panel region to load the index region from CRUDHandler.
            'region' => array('path' => "/bs/$crudId/crud/edit?" . $queryString),

            'data-region' => 'pageContent',
            'data-path' => "/bs/$crudId/crud/edit?" . $queryString,
        ));
        return $menuItem;
    }


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
