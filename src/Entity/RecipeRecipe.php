<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_recipe")

 */
class RecipeRecipe
{
    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="recipeRecipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="recipeRecipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associatedRecipe;

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param mixed $recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @return mixed
     */
    public function getAssociatedRecipe()
    {
        return $this->associatedRecipe;
    }

    /**
     * @param mixed $associatedRecipe
     */
    public function setAssociatedRecipe($associatedRecipe)
    {
        $this->associatedRecipe = $associatedRecipe;
    }
}