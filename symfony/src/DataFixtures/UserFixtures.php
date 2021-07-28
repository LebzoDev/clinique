<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\DataFixtures\ProfilFixtures;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
   private $encoder;
   private $repoProfil;
   public function __construct(UserPasswordEncoderInterface $encoder,ProfilRepository $repoProfil){
        $this->repoProfil = $repoProfil;
        $this->encoder = $encoder;
   }
    public function load(ObjectManager $manager)
    {
       $faker = Factory::create("fr_FR");

        for($i=1; $i<=3; $i++){
            $user = new User();
            $password = $this->encoder->encodePassword($user,'passer');
            if($i==1){
                $user->setProfil($this->getReference(ProfilFixtures::PROFIL_ADMIN));
            }elseif ($i==2) {
                $user->setProfil($this->getReference(ProfilFixtures::PROFIL_PERSONNEL));
            }else{
                $user->setProfil($this->getReference(ProfilFixtures::PROFIL_SECRETAIRE));
            }
            $user->setPrenom($faker->firstName)
            ->setNom($faker->lastName)
            ->setUsername($faker->userName)
            ->setPassword($password)
            ->setTelephone($faker->phoneNumber)
            ->setEmail($faker->email)
            ->setArchive(false);
            //->setPhoto($faker->image($dir = '/tmp', $width = 640, $height = 480));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfilFixtures::class,
        ];
    }
}
