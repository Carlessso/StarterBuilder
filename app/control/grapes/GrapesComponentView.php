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
class GrapesComponentView extends TPage
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

        $this->html = new THtmlRenderer('app/resources/grapes_component_view.html');
        
        // $this->html->enableSection('main', array('form_title' => $this->form_title, 'form' => $this->form));
        $this->html->enableSection('main');
        
        parent::add($this->html);
    }
        
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('starter');
            $object = new Component($param['id']);
            TTransaction::close();

            TForm::sendData('form-component-page', $object);

            TScript::create("$('#classe').attr('readonly', 'readonly');");

            $html_content = file_get_contents("{$object->path}");

            TScript::create("let sethtmlgrapes = setTimeout(function() {
                          editor.setComponents('{$html_content}');
                        }, 2000)");

        }
        catch (Exception $e)
        {

        }
    }

    public static function onSave($param)
    {
        try
        {
            TTransaction::open('starter');
            
            $page = new Component;

            if (!empty($param['id'])) 
            {
                $page->id = $param['id'];
            }

            $page->name           = $param['name'];
            $page->path           = $param['path'];
            $page->system_user_id = TSession::getValue('userid');

            $page->store();

            TTransaction::close();

            new TMessage('info', 'Componente salvo com sucesso!');
            TForm::sendData('form-component-page', $page);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function onLoad()
    {
        TScript::create("let clearhtmlGrapes = setTimeout(function() {
              editor.setComponents(' ');
            }, 2000)");   
    }

}