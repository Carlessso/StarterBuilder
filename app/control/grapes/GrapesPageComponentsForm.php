<?php
/**
 * GrapesPageComponentsForm Registration
 * @author  <your name here>
 */
class GrapesPageComponentsForm extends TPage
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_page_component');
        $this->form->setFormTitle('<h5>Página</h5>');
        $this->form->setProperty('style', 'margin:0;border:0');
        $this->form->setClientValidation(true);
        
        // master fields
        $id   = new TEntry('id');
        $name = new TEntry('name');
        
        // detail fields
        $page_component_unqid = new THidden('page_component_uniqid');
        $page_component_id    = new THidden('page_component_id');
        $component_id         = new TCombo('component_id');

        TTransaction::open('starter');
        $component_id->addItems(Component::getIndexedArray('id', 'name'));
        TTransaction::close(); 

        $component_id->setSize('70%');
        $name->setSize('70%');

        $component_id->enableSearch();

        // adjust field properties
        $id->setEditable(false);

        $id->setSize('30%');
        
        // add master form fields
        $this->form->addFields( [new TLabel('Código')], [$id] );

        $this->form->addFields( [new TLabel('Nome (*)', '#FF0000')], [$name] );
        
        $this->form->addContent( ['<h5>COMPONENTES</h5><hr>'] );
        $this->form->addFields( [ $page_component_unqid], [$page_component_id] );
        $this->form->addFields( [ new TLabel('Componente (*)', '#FF0000') ], [$component_id]);
        
        $add_component = TButton::create('add_component', [$this, 'onComponentAdd'], 'Adicionar', 'fa:plus-circle green');
        $add_component->getAction()->setParameter('static','1');
        $this->form->addFields( [], [$add_component] );
        
        $this->component_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->component_list->setHeight(150);
        $this->component_list->makeScrollable();
        $this->component_list->setId('components_list');
        $this->component_list->generateHiddenFields();
        $this->component_list->style = "min-width: 700px; width:100%;margin-bottom: 10px";
        
        $col_uniq  = new TDataGridColumn('uniqid', 'Uniqid', 'center', '10%');
        $col_id    = new TDataGridColumn('id', 'ID', 'center', '10%');
        $col_cid   = new TDataGridColumn('component_id', 'Código componente', 'center', '20%');
        $col_cname = new TDataGridColumn('component_id', 'Nome componente', 'center', '60%');

        $col_cname->setTransformer(function($value) {
            return Component::findInTransaction('starter', $value)->name;
        });

        $this->component_list->addColumn( $col_uniq );
        $this->component_list->addColumn( $col_id );
        $this->component_list->addColumn( $col_cid );
        $this->component_list->addColumn( $col_cname );
        
        $col_id->setVisibility(false);
        $col_uniq->setVisibility(false);
        
        // creates two datagrid actions
        $action1 = new TDataGridAction([$this, 'onEditComponent'] );
        $action1->setFields( ['uniqid', '*'] );
        
        $action2 = new TDataGridAction([$this, 'onDeleteComponent']);
        $action2->setField('uniqid');
        
        // add the actions to the datagrid
        $this->component_list->addAction($action1, _t('Edit'), 'far:edit blue');
        $this->component_list->addAction($action2, _t('Delete'), 'far:trash-alt red');
        
        $this->component_list->createModel();
        
        $panel = new TPanelGroup;
        $panel->add($this->component_list);
        $panel->getBody()->style = 'overflow-x:auto';
        $this->form->addContent( [$panel] );
        
        $this->form->addAction( 'Salvar',  new TAction([$this, 'onSave'], ['static'=>'1']), 'fa:save green');
        $this->form->addAction( 'Limpar', new TAction([$this, 'onClear']), 'fa:eraser red');
        $this->form->addActionLink('Listar',  new TAction(array('GrapesPagesList', 'onReload')), 'fa:table blue');
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    /**
     * Pre load some data
     */
    public function onLoad($param)
    {

    }
    
    
    /**
     * Clear form
     * @param $param URL parameters
     */
    function onClear($param)
    {
        $this->form->clear();
    }
    
    /**
     * Add a product into item list
     * @param $param URL parameters
     */
    public function onComponentAdd( $param )
    {
        try
        {
            $this->form->validate();
            $data = $this->form->getData();
            
            if( (!$data->component_id))
            {
                throw new Exception('The field component is required');
            }
            
            $uniqid = !empty($data->page_component_uniqid) ? $data->page_component_uniqid : uniqid();
            
            $grid_data = ['uniqid'  => $uniqid,
                          'id'      => $data->page_component_id,
                          'component_id' => $data->component_id];
            
            // insert row dynamically
            $row = $this->component_list->addItem( (object) $grid_data );
            $row->id = $uniqid;
            
            TDataGrid::replaceRowById('components_list', $uniqid, $row);
            
            // clear product form fields after add
            $data->page_component_uniqid  = '';
            $data->page_component_id      = '';
            $data->component_id           = '';
            
            // send data, do not fire change/exit events
            TForm::sendData( 'form_page_component', $data, false, false );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            new TMessage('error', $e->getMessage());
        }
    }
    
    /**
     * Edit a product from item list
     * @param $param URL parameters
     */
    public static function onEditComponent( $param )
    {
        $data = new stdClass;
        $data->page_component_uniqid  = $param['uniqid'];
        $data->page_component_id      = $param['id'];
        $data->component_id           = $param['component_id'];
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_page_component', $data, false, false );
    }
    
    /**
     * Delete a product from item list
     * @param $param URL parameters
     */
    public static function onDeleteComponent( $param )
    {
        $data = new stdClass;
        $data->page_component_uniqid     = '';
        $data->page_component_id         = '';
        $data->component_id = '';
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_page_component', $data, false, false );
        
        // remove row
        TDataGrid::removeRowById('components_list', $param['uniqid']);
    }
    
    /**
     * Edit Sale
     */
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('starter');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new Page($key);
                $page_components = PageComponent::where('component_id', '=', $object->id)->load();
                
                foreach( $page_components as $item )
                {
                    $item->uniqid = uniqid();
                    $row = $this->component_list->addItem( $item );
                    $row->id = $item->uniqid;
                }
                $this->form->setData($object);
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Save the sale and the sale items
     */
    public function onSave($param)
    {
        try
        {
            TTransaction::open('starter');
            
            $data = $this->form->getData();
            $this->form->validate();
                        
            $page = new Page;

            if (!empty($param['id'])) 
            {
                $page->id = $param['id'];
            }

            $page->name           = $param['name'];
            $page->path           = ' ';
            $page->system_user_id = TSession::getValue('userid');

            $page->store();
            
            PageComponent::where('page_id', '=', $page->id)->delete();
            
            $total = 0;

            if(!empty($param['components_list_component_id'] ))
            {
                foreach( $param['components_list_component_id'] as $key => $item_id )
                {
                    $pageComponent = new PageComponent;

                    $pageComponent->page_id      = $page->id;
                    $pageComponent->component_id = $item_id;
                    
                    $pageComponent->store();
                }
            }

            $page->path = GrapesService::storePageComponents($page, $param['components_list_component_id']);
            
            $page->store();

            // $sale->total = $total;
            // $sale->store(); // stores the object
            
            TForm::sendData('form_page_component', $page);
            
            TTransaction::close(); // close the transaction
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback();
        }
    }

}