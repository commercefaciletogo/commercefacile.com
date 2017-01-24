<?php

namespace App\Repos;

use App\Category;

class CategoryRepo
{
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoryRepo constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all(){}
}