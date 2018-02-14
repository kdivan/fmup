<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_ingredient")

 */
class RecipeIngredient
{
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="recipeRecipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Ingredient", inversedBy="recipeIngredient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredient;

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
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
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * @param mixed $ingredient
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;
    }

}