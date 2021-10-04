<?php
/**
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Matheus Carlesso
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class GrapesView extends TPage
{
    protected $form; // form
    protected $form_title; // form_title
    private $html;
    private $id;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();

        $this->html = new THtmlRenderer('app/resources/grapes_view.html');
        
        // $this->form       = $this->makeFormularioProva($param);
        // $this->form_title = $this->makeFormularioTitle($param);
        
        // $this->html->enableSection('main', array('form_title' => $this->form_title, 'form' => $this->form));
        $this->html->enableSection('main');
        
        parent::add($this->html);
    }
        

}