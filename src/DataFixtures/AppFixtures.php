<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryAttribute;
use App\Entity\Proposal;
use App\Entity\ProposalAttribute;
use App\Entity\Ressource;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Tree\TreeListener;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('Jb@craftly.com');
        $user->setName("La bite");

        $password = $this->encoder->encodePassword($user, 'aze123rty');
        $user->setPassword($password);

        $manager->persist($user);

        $uuid = Uuid::uuid4();

        $food = new Category();
        $food->setTitle('Food');

        $fruits = new Category();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Category();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);

        $manager->persist($food);
        $manager->persist($fruits);
        $manager->persist($vegetables);
        $manager->persist($carrots);
        $manager->flush();

        $categ_attribute = new CategoryAttribute();
        $categ_attribute->setCategory($fruits);
        $categ_attribute->setValue("Poids");
        $categ_attribute->setUnity("G");

        $farine = new Ressource();
        $farine->setName("Farine");
        $farine->setUuid($uuid);
        $farine->setCategory($food);

        $offer = new Proposal();
        $offer->setType(1);
        $offer->setUser($user);
        $offer->setRessource($farine);
        $offer->setPriority(0);

        $offer_attribute = new ProposalAttribute();
        $offer_attribute->setCategoryAttribute($categ_attribute);
        $offer_attribute->setValue(500);
        $offer_attribute->setUnity("G");
        $offer_attribute->setProposal($offer);



        $manager->persist($categ_attribute);

        $manager->persist($farine);
        $manager->persist($offer);
        $manager->persist($offer_attribute);
        $manager->flush();
    }
}
