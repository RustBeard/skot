<?php

class IncomeCategories
{
  private static array $categories = [
    1 => [
      'name' => 'Salary'
    ],
    2 => [
      'name' => 'Refunds'
    ],
    3 => [
      'name' => 'Gifts'
    ],
    4 => [
      'name' => 'Child Support'
    ]
  ];

  /**
   * Get all categories with their subcategories
   * @return array
   */
  public static function getAllCategories(): array
  {
    return self::$categories;
  }

  /**
   * Get category name by ID
   * @param int $categoryId
   * @return string|null
   */
  public static function getCategoryName(int $categoryId): ?string
  {
    return self::$categories[$categoryId]['name'] ?? null;
  }

  /**
   * Get subcategory name by ID
   * @param int $subcategoryId
   * @return string|null
   */
  public static function getSubcategoryName(int $subcategoryId): ?string
  {
    foreach (self::$categories as $category) {
      if (isset($category['subcategories'][$subcategoryId])) {
        return $category['subcategories'][$subcategoryId];
      }
    }
    return null;
  }

  /**
   * Get full category path (Category > Subcategory)
   * @param int $subcategoryId
   * @return string|null
   */
  public static function getCategoryPath(int $subcategoryId): ?string
  {
    foreach (self::$categories as $category) {
      if (isset($category['subcategories'][$subcategoryId])) {
        return $category['name'] . ' > ' . $category['subcategories'][$subcategoryId];
      }
    }
    return null;
  }
}
