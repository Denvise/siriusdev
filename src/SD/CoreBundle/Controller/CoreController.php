<?php

namespace SD\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {

        $datetime1 = new \DateTime('now');
        $datetime2 = new \DateTime('1991-03-31');
        $interval = $datetime1->diff($datetime2);
        $age = $interval->format('%Y%');
        return $this->render('SDCoreBundle::index.html.twig', [
            'age' => $age
        ]);
    }
}
