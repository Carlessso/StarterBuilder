<?php
/**
 * class Class
 */
class Class extends TRecord
{
    const TABLENAME = 'class';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
        parent::addAttribute('name');
        parent::addAttribute('path');
        parent::addAttribute('dt_creation');
    }
}
