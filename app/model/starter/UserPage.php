<?php
/**
 * class UserPages
 */
class UserPages extends TRecord
{
    const TABLENAME = 'system_user_pages';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('page_id');
        parent::addAttribute('system_user_id');
        parent::addAttribute('readonly');
    }
}