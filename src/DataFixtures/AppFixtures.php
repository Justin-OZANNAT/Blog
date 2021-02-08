<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        $user = new User();
        $user
            ->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'user'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPseudo($faker->firstName)
        ;
        $manager->persist($user);


        $admin = new User();
        $admin
            ->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPseudo($faker->firstName)
            ->setRoles(['ADMIN'])
        ;

        $manager->persist($admin);
        $manager->flush();
    }
}
