<?php
namespace AdminUI;
use AdminUI\MenuFolder;
use AdminUI\Menu;

class MenuItem
{
    public $label;
    public $attributes = array();

    public function __construct($label, $attributes = array() , $id = null )
    {
        $this->label = $label;
        $this->attributes = $attributes;
        $this->setId( $id ?: crc32(microtime()) );
    }

    public function setHref($href)
    {
        $this->attributes['href'] = $href;
    }

    public function setTarget($target)
    {
        $this->attributes['target'] = $target;
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function isMenuFolder()
    {
        return $this instanceof MenuFolder;
    }

    public function isMenuItem()
    {
        return $this instanceof MenuItem;
    }


    public function renderAttributes()
    {
        $active = '';
        if ( isset($_SERVER['PATH_INFO']) ) {
            if ( isset($this->attributes['href']) && $_SERVER['PATH_INFO'] == $this->attributes['href'] ) {
                $active = ' active';
            }
        }

        $html = '';
        //  region => { path => , attributes => }
        if ( isset($this->attributes['region']) ) {
            $r = $this->attributes['region'];
            $json = isset($r['attributes']) ? json_encode($r['attributes']) : '{}';
            $this->attributes['onclick'] = "
                var a = this;
                \$(a).parents('ul').find('.active').removeClass('active');
                \$(a).parent().addClass('active');
                \$('#panel').asRegion().load('{$r['path']}',$json,function() {
                    if(typeof $.scrollTo !== 'undefined') {
                        $.scrollTo( \$('#panel'), 300);
                    }
                });
                return false;
            ";
            unset($this->attributes['region']);
        }
        foreach( $this->attributes as $key => $value ) {
            $html .= sprintf( ' %s="%s"', $key , $value );
        }
        return $html;
    }
}

