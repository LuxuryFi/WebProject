<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $hasher;

    public function __construct( UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("myprince");
        $user->setPassword($this->hasher->hashPassword($user,"123456789"));
        $user->setFullname("Nguyen Thi Hoa An");
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername("anbebong");
        $user->setPassword($this->hasher->hashPassword($user,"123456789"));
        $user->setFullname("Nguyen Thi Hoa An");
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->flush();
    }
}
