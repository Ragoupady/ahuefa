<?php
// src/SR/UserBundle/DataFixtures/ORM/LoadNewsCategory.php

namespace SR\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SR\BlogBundle\Entity\NewsCategory;

class LoadUser implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Les noms des catégories
    $listNames = array('Psychologie', 'Enfance', 'Cinéma');

    foreach ($listNames as $name) {
      // On crée la catégorie
      $newscategory = new NewsCategory;

      // Le nom des catégories
      $newscategory->setName($name);
      


      // On le persiste
      $manager->persist($newscategory);
    }

    // On déclenche l'enregistrement
    $manager->flush();
  }
}