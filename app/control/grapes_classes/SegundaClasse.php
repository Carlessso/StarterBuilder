<?php
/**
 *
 * Generated by StarterBuilder
 */
class SegundaClasse extends TPage
{
    protected $form; // form
    protected $form_title; // form_title
    private $html;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();

        $this->html = new THtmlRenderer('app/resources/grapes_pages/exemplocomfooter.html');
        
        $this->html->enableSection('main');
        
        parent::add($this->html);
    }
        
    public static function onSave($param)
    {
        var_dump($param);
    }
}