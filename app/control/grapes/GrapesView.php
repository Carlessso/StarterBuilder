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
        
        // $this->html->enableSection('main', array('form_title' => $this->form_title, 'form' => $this->form));
        $this->html->enableSection('main');
        
        parent::add($this->html);
    }
        
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('starter');
            $object = new Page($param['id']);

            $object->classe = $object->class;
            TTransaction::close();

            TForm::sendData('form-starter-page', $object);

            TScript::create("$('#classe').attr('readonly', 'readonly');");

            $html_name = strtolower($object->classe);

            $html_content = file_get_contents("app/resources/grapes_files/{$html_name}.html");

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
            
            $page = new Page;

            if (!empty($param['id'])) 
            {
                $page->id = $param['id'];
            }

            $page->name           = $param['name'];
            $page->path           = $param['path'];
            $page->system_user_id = TSession::getValue('userid');

            $page->store();

            TTransaction::close();

            new TMessage('info', 'Página salva com sucesso!');
            TForm::sendData('form-starter-page', $page);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function onLoad()
    {
        
    }

}