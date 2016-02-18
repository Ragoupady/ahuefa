<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BlogController : Ce controller permet de factoriser le code pour les controlleurs qui vont l'étendre
 *
 */
class BlogController extends Controller
{

    protected function createDeleteForm($route)
    {
        return $this->createFormBuilder()
            ->setAction($route)
            ->setMethod('POST')
            ->getForm()
            ->add('Supprimer', 'submit');
    }

}



