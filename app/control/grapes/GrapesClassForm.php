<?php
/**
 * GrapesClassForm 
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class GrapesClassForm extends TPage
{
    protected $form; // form
    
    // trait with onSave, onClear, onEdit
    use Adianti\Base\AdiantiStandardFormTrait;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('starter');    // defines the database
        $this->setActiveRecord('Classe');   // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_classe');
        $this->form->setFormTitle('Class Form');
        $this->form->setClientValidation(true);
        
        // create the form fields
        $id   = new TEntry('id');
        $name = new TEntry('name');
        $page = new TCombo('page_id');

        TTransaction::open('starter');
        $page->addItems(Page::getIndexedArray('id', 'name'));
        TTransaction::close(); 

        $page->setSize('100%');

        $page->enableSearch();

        $id->setEditable(FALSE);
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')], [$id] );
        $this->form->addFields( [new TLabel('Name', 'red')], [$name] );
        $this->form->addFields( [new TLabel('Page', 'red')], [$page] );
        
        $name->addValidation( 'Name', new TRequiredValidator);
        
        // define the form action
        $this->form->addAction('Save', new TAction(array($this, 'onSave'), ['static' => 1]), 'fa:save green');
        $this->form->addActionLink('Clear',  new TAction(array($this, 'onClear')), 'fa:eraser red');
        $this->form->addActionLink('Listing',  new TAction(array('GrapesClassesList', 'onReload')), 'fa:table blue');
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        // $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        parent::add($vbox);
    }

    public static function onSave($param)
    {
        try
        {
            TTransaction::open('starter');
            
            $classe = new Classe;

            if (!empty($param['id'])) 
            {
                $page->id = $param['id'];
            }

            $classe->name           = $param['name'];
            $classe->path           = GrapesService::saveClass($param['page_id'], $classe->name);
            $classe->page_id        = $param['page_id'];
            $classe->system_user_id = TSession::getValue('userid');

            $classe->store();

            TTransaction::close();

            new TMessage('info', "Classe criada com sucesso! O caminho do arquivo para programação é:<br>{$classe->path}");
            TForm::sendData('form_classe', $classe);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        } 
    }
}
