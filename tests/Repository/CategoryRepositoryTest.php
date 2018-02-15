<?php

namespace App\Tests\Repository;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CategoryRepositoryTest
 *
 * @package App\Tests\Repository
 */
class CategoryRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
                           ->get('doctrine')
                           ->getManager();
    }

    public function testNewCategory()
    {
        $food = new Category();
        $food->setName('Food');

        $fruits = new Category();
        $fruits->setName('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setName('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Category();
        $carrots->setName('Carrots');
        $carrots->setParent($vegetables);

        $this->em->persist($food);
        $this->em->persist($fruits);
        $this->em->persist($vegetables);
        $this->em->persist($carrots);
        $this->em->flush();


        /** @var Category $carrots */
        $food = $this->em->getRepository('App:Category')->findOneBy(["name" => "Food"]);
        $carrots = $this->em->getRepository('App:Category')->findOneBy(["name" => "Carrots"]);
        $vegetables = $this->em->getRepository('App:Category')->findOneBy(["name" => "Vegetables"]);


        $this->assertEquals('Food', $food->getPath());
        $this->assertEquals('Food\\Vegetables\\Carrots', $carrots->getPath());
        $this->assertEquals('Food\\Vegetables', $vegetables->getPath());

        /** @var Category */
        $food->setName('New Food Name');
        $this->em->persist($food);
        $this->em->flush();

        $food = $this->em->getRepository('App:Category')->findOneBy(["name" => "New Food Name"]);
        $carrots = $this->em->getRepository('App:Category')->findOneBy(["name" => "Carrots"]);
        $vegetables = $this->em->getRepository('App:Category')->findOneBy(["name" => "Vegetables"]);

        $this->assertEquals('New Food Name', $food->getPath());
        $this->assertEquals('New Food Name\\Vegetables\\Carrots', $carrots->getPath());
        $this->assertEquals('New Food Name\\Vegetables', $vegetables->getPath());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}