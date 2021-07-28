<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixtures extends Fixture
{
    public const PROFIL_ADMIN = 'profil_admin';
    public const PROFIL_PERSONNEL = 'profil_personnel';
    public const PROFIL_SECRETAIRE = 'profil_secretaire';

    public function load(ObjectManager $manager)
    {
       $array=['profil_admin','profil_personnel','profil_secretaire'];
       $LibelleArray = ['ADMIN','PERSONNEL','SECRETAIRE'];

       foreach($array as $key => $value){
           $profil = new Profil();
           $profil->settype($LibelleArray[$key])
           ->setArchive(false);
           $this->addReference($value, $profil);
           $manager->persist($profil);
       }

        $manager->flush();
    }
}
