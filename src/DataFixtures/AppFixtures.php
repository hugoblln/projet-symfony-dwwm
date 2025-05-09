<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Users;
use App\Entity\Terrains;
use App\Entity\Complexes;
use App\Entity\TarifHeure;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {

    }
    public function load(ObjectManager $manager): void
    {
      

        $user = (new Users)
            ->setLastName('Bellin')
            ->setFirstName('hugo')
            ->setEmail('hugobellin@yahoo.com')
            ->setRoles(['ROLE_ADMIN','ROLE_PROPRIETAIRE'])
            ->setPassword($this->hasher->hashPassword(new Users, 'Test1234!'));

            $manager->persist($user);

            
            for($i=0;$i < 10; $i++) {
                $user = (new Users)
                    ->setLastName('user')
                    ->setFirstName($i)
                    ->setEmail("user-$i@test.com")
                    ->setPassword(
                        $this->hasher->hashPassword($user, 'Test1234!')
                    );

                    $manager->persist($user);
            };

        $manager->flush();

        $proprietaire = $manager->getRepository(Users::class)->findOneBy(['email' =>'hugobellin@yahoo.com']);

        $complexe1 = (new Complexes())
            ->setNom('Complexe A')
            ->setAdresse('123 Rue Principale')
            ->setDescription('Un complexe sportif moderne.')
            ->setTelephone('0123456789')
            ->setVille('Ville A')
            ->setHeureOuverture(new \DateTime('08:00:00'))
            ->setHeureFermeture(new \DateTime('22:00:00'))
            ->setProprietaire($proprietaire)
            ->setEnable(true);
        $manager->persist($complexe1);

        $complexe2 = (new Complexes())
            ->setNom('Complexe B')
            ->setAdresse('456 Avenue Secondaire')
            ->setDescription('Un complexe sportif avec plusieurs terrains.')
            ->setTelephone('0987654321')
            ->setVille('Ville B')
            ->setHeureOuverture(new \DateTime('07:00:00'))
            ->setHeureFermeture(new \DateTime('23:00:00'))
            ->setProprietaire($proprietaire)
            ->setEnable(true);
        $manager->persist($complexe2);

        $manager->flush();

        // Pour faire référence à ces complexes dans d'autres fixtures 
        $this->addReference('complexe-1', $complexe1);
        $this->addReference('complexe-2', $complexe2);

        $complexe1 = $this->getReference('complexe-1');
        $complexe2 = $this->getReference('complexe-2');

        $terrain1 = new Terrains();
        $terrain1->setNom('Terrain 1')
            ->setDescription('Un terrain de football.')
            ->setTypeTerrain('Football')
            ->setTaille(100.0)
            ->setTarifHeure(50.0)
            ->setComplexe($complexe1)
            ->setEnable(true);
        $manager->persist($terrain1);

        $terrain2 = new Terrains();
        $terrain2->setNom('Terrain 2')
            ->setDescription('Un terrain de basketball.')
            ->setTypeTerrain('Basketball')
            ->setTaille(50.0)
            ->setTarifHeure(40.0)
            ->setComplexe($complexe1)
            ->setEnable(true);
        $manager->persist($terrain2);

        $terrain3 = new Terrains();
        $terrain3->setNom('Terrain 3')
            ->setDescription('Un terrain de tennis.')
            ->setTypeTerrain('Tennis')
            ->setTaille(30.0)
            ->setTarifHeure(30.0)
            ->setComplexe($complexe2)
            ->setEnable(true);
        $manager->persist($terrain3);

        $manager->flush();

    }


}
