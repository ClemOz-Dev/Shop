<?php

namespace OShop\Controllers;
use OShop\Models\Stupid;

class DemoController extends CoreController
{
    public function helloWorld()
    {
        $stupidModelJouflu = new Stupid();
        dump($stupidModelJouflu->findAll());
    }
}