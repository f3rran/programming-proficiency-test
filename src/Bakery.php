<?php

namespace App;

class Bakery
{
    /**
     * Calculate the output of cakes for a giver recipe
     *
     * @param array $recipe      Contains the necessary ingredients to make one cake
     * @param array $ingredients Contains the amount of ingredients you have available to bake
     *
     * @return int The number of cakes you can bake
     */
    public static function calculateOutput(array $recipe, array $ingredients): int
    {
        $numberOfCakes = 0;

        $max_per_ingredient = array();
        foreach ($recipe as $key => $recipeIngredient) {
            if($ingredients[$key] ?? false)
                array_push($max_per_ingredient, intdiv($ingredients[$key], $recipeIngredient));
            else
                return 0;
        }
        $numberOfCakes = min($max_per_ingredient);

        return $numberOfCakes;
    }
}