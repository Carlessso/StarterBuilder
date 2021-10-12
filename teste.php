<?php
require_once 'init.php';

$code = '<h1>Hello World Component!
</h1>
<form method="get">
  <div>
    <label>Name</label>
    <input type="text"/>
  </div>
  <div>
    <label>Email</label>
    <input type="email"/>
  </div>
  <div>
    <label>Gender</label>
    <input type="checkbox" value="M"/>
    <label>M</label>
    <input type="checkbox" value="F"/>
    <label>F</label>
  </div>
  <div>
    <label>Message</label>
    <textarea></textarea>
  </div>
  <div>
    <button type="button">Send</button>
  </div>
</form>';

$dom = new DOMDocument();
$dom->loadHTML($code);

$forms = $dom->getElementsByTagName('form');

foreach ($forms as $form) 
{
    $form->setAttribute("name", "generated-starter-form");
}

echo $dom->saveXML();die;

var_dump($form);die;


$result = GrapesService::storeHtml(['code' => $code]);

echo '<pre>' , var_dump($result) , '</pre>';