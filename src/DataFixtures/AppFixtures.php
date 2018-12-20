<?php

namespace App\DataFixtures;

use App\Entity\MarquePage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("admin");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));
        $manager->persist($user);

        $user2 = new User();
        $user2->setUsername("user1");
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'user1'
        ));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername("user2");
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword($this->passwordEncoder->encodePassword(
            $user3,
            'user2'
        ));
        $manager->persist($user3);

        $mp1 = new MarquePage();
        $mp1->setTitre("mon marque page");
        $mp1->setURL("https://nclshart.net/wimsi/symfony/#/3/23");
        $mp1->setCommentaire("cours sf");
        $mp1->setDateCreate(new \DateTime());
        $mp1->setUser($user2);
        $manager->persist($mp1);

        $mp2 = new MarquePage();
        $mp2->setTitre("zaerty");
        $mp2->setURL("https://nclshart.net/wimsi/symfony/#/3/23");
        $mp2->setDateCreate(new \DateTime());
        $mp2->setUser($user2);
        $manager->persist($mp2);

        $mp2 = new MarquePage();
        $mp2->setTitre("coucou");
        $mp2->setURL("https://nclshart.net/wimsi/symfony/#/3/23");
        $mp2->setCommentaire("qergdgquzrheghguvclnqztequ");
        $mp2->setDateCreate(new \DateTime());
        $mp2->setUser($user2);
        $manager->persist($mp2);

        $manager->flush();
    }

}
