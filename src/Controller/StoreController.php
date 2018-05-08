<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:56 PM
 */

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends BaseController
{
    private $cart;

    protected function start()
    {
        parent::start();
    }

    /**
     * @return mixed
     * @Route("/store", name="store")
     */
    public function showStore()
    {
        $this->start();
        return $this->render("store.html.twig", array("navs" => $this->navs, "imgs" => $this->imgs));
    }
}