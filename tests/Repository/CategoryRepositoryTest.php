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


        $vegetables = $this->em->getRepository('App:Category')->findOneBy(["name" => "Foodd"]);
        /** @var Category */
        $vegetables->setName('Food');
        $this->em->persist($vegetables);
        $this->em->flush();


        /*

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

        */
        //$category = new Category();
        //$vegetables->setName('Test');
        //$this->em->persist($vegetables);
        //$category->setParent($parentCategory);

        //$this->em->persist($category);
        //$this->em->flush();
        //$this->em->refresh($category);
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