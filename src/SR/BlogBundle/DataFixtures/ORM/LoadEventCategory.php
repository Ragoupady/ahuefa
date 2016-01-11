<?php
// src/SR/UserBundle/DataFixtures/ORM/LoadEventCategory.php

namespace SR\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SR\BlogBundle\Entity\EventCategory;

class LoadEventCategory implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Les noms des catégories
    $listNames = array('Voyage transculturel', 'Séminaire');

    foreach ($listNames as $name) {
      // On crée la catégorie
      $eventcategory = new EventCategory;

      // Le nom des catégories
      $eventcategory->setName($name);
      


      // On le persiste
      $manager->persist($eventcategory);
    }

    // On déclenche l'enregistrement
    $manager->flush();
  }
}