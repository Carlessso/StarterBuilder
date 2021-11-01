<?php
/**
 * class PageComponent
 */
class PageComponent extends TRecord
{
    const TABLENAME = 'page_components';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('page_id');
        parent::addAttribute('component_id');
    }

}
