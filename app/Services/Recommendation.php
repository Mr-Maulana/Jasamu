<?php

namespace App\Services;

class Recommendation
{
    protected $categories;

    public function __construct()
    {
        // Membaca daftar kategori dari file category.txt
        $categoryFilePath = storage_path('app/category.txt');
        $this->categories = file($categoryFilePath, FILE_IGNORE_NEW_LINES);
    }

    public function recommendCategories($serviceName)
    {
        $serviceWords = explode(' ', strtolower($serviceName));

        $recommendedCategories = [];

        foreach ($this->categories as $category) {
            $categoryWords = explode(' ', strtolower($category));
            $similarity = count(array_intersect($serviceWords, $categoryWords));
            
            if ($similarity > 0) {
                $recommendedCategories[] = $category;
            }
        }

        return $recommendedCategories;
    }
}
