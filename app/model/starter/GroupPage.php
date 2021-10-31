<?php
/**
 * class GroupPages
 */
class GroupPages extends TRecord
{
    const TABLENAME = 'system_group_pages';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('page_id');
        parent::addAttribute('system_group_id');
        parent::addAttribute('readonly');
    }
}