<?php
namespace AdminUI;
use AdminUI\Menu;

class MenuFolder extends MenuItem
{
    public $label;
    public $id;
    public $menuItems = array();
    public $attributes = array();

    public function __construct($label, $attributes = array() , $id = null)
    {
        $this->label = $label;
        $this->attributes = $attributes;
        $this->setId( $id ?: crc32(microtime()) );
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function findMenuItemById($id)
    {
        foreach( $this->menuItems as $item ) {
            if ( $item->getId() === $id ) {
                return $item;
            }
        }
    }

    public function sortMenuFoldersToTop()
    {
        usort($this->menuItems, function($a,$b) {
            if ( $a instanceof MenuFolder && ! $b instanceof MenuFolder ) {
                return -1;
            } elseif ( $b instanceof MenuFolder && ! $a instanceof MenuFolder ) {
                return 1;
            }
            return 0;
        });
    }


    public function createMenuFolder($folderName, $linkAttrs = null, $attrs = array(), $id = null)
    {
        $folder = new MenuFolder($folderName, $linkAttrs, $attrs , $id );
        $this->menuItems[] = $folder;
        return $folder;
    }

    public function insertMenuFolder(MenuFolder $folder)
    {
        $this->menuItems[] = $folder;
    }




    // XXX: bad smell
    public function createCrudMenuItem($crudId,$label)
    {
        return $this->createMenuItem($label, array(
            'href' => '/bs/' . $crudId,
            'data-crud-id' => $crudId,
            'data-region-path' => "/bs/$crudId/crud/index",
            // let the main panel region to load the index region from CRUDHandler.
            'region' => array('path' => "/bs/$crudId/crud/index"),
        ));
    }



    /**
     * Insert MenuItem to the folder.
     *
     * @param MenuItem $item
     * @param integer $insertAt = 0
     */
    public function insertMenuItem(MenuItem $item, $insertAt = 0)
    {
        if( $insertAt == 0 ) {
            $this->menuItems[] = $item;
        } else {
            array_splice( $this->menuItems, $insertAt ,  0 , array( $item ) );
        }
    }


    public function createMenuItem($label, $linkAttrs = null, $attributes = array(), $id = null)
    {
        $menuItem = new MenuItem($label, $linkAttrs, $attributes, $id);
        $this->menuItems[] = $menuItem;
        return $menuItem;
    }


}



