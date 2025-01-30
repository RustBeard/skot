<?php

class ExpenseCategories {
    private static array $categories = [
        1 => [
            'name' => 'Food',
            'subcategories' => [
                101 => 'Groceries',
                102 => 'Snacks and sweets',
                103 => 'Restaurants and fast food'
            ]
        ],
        2 => [
            'name' => 'General Shopping',
            'subcategories' => [
                201 => 'Home furnishings',
                202 => 'Kitchen equipment',
                203 => 'Electronics',
                204 => 'Tools',
                205 => 'Household chemicals'
            ]
        ],
        3 => [
            'name' => 'Housing',
            'subcategories' => [
                301 => 'Rent',
                302 => 'Mortgage',
                303 => 'Utilities',
                304 => 'Repairs',
                305 => 'Other'
            ]
        ],
        4 => [
            'name' => 'Communication & Digital Services',
            'subcategories' => [
                401 => 'Smartphone (bills)',
                402 => 'Internet',
                403 => 'Software & subscriptions'
            ]
        ],
        5 => [
            'name' => 'Transport',
            'subcategories' => [
                501 => 'Public transport',
                502 => 'Taxi',
                503 => 'Other'
            ]
        ],
        6 => [
            'name' => 'Car',
            'subcategories' => [
                601 => 'Fuel',
                602 => 'Parking',
                603 => 'Repairs & maintenance',
                604 => 'Leasing',
                605 => 'Other'
            ]
        ],
        7 => [
            'name' => 'Health & Beauty',
            'subcategories' => [
                701 => 'Medicine',
                702 => 'Supplements',
                703 => 'Doctor visits',
                704 => 'Cosmetics',
                705 => 'Other'
            ]
        ],
        8 => [
            'name' => 'Clothing & Accessories',
            'subcategories' => [
                801 => 'Adult clothing',
                802 => 'Children\'s clothing'
            ]
        ],
        9 => [
            'name' => 'Entertainment & Hobbies',
            'subcategories' => [
                901 => 'Typical entertainment (movies, games, parties)',
                902 => 'Developmental & active (sports, books, crafts)'
            ]
        ],
        10 => [
            'name' => 'Education',
            'subcategories' => [
                1001 => 'Courses, training, academic books'
            ]
        ],
        11 => [
            'name' => 'Children',
            'subcategories' => [
                1101 => 'School',
                1102 => 'Toys'
            ]
        ],
        12 => [
            'name' => 'Vacations & Travel',
            'subcategories' => [
                1201 => 'Vacations & Travel'
            ]
        ],
        13 => [
            'name' => 'Gifts & Donations',
            'subcategories' => [
                1301 => 'Gifts & Donations'
            ]
        ],
        14 => [
            'name' => 'Other',
            'subcategories' => [
                1401 => 'Other'
            ]
        ]
    ];

    /**
     * Get all categories with their subcategories
     * @return array
     */
    public static function getAllCategories(): array {
        return self::$categories;
    }

    /**
     * Get category name by ID
     * @param int $categoryId
     * @return string|null
     */
    public static function getCategoryName(int $categoryId): ?string {
        return self::$categories[$categoryId]['name'] ?? null;
    }

    /**
     * Get subcategory name by ID
     * @param int $subcategoryId
     * @return string|null
     */
    public static function getSubcategoryName(int $subcategoryId): ?string {
        foreach (self::$categories as $category) {
            if (isset($category['subcategories'][$subcategoryId])) {
                return $category['subcategories'][$subcategoryId];
            }
        }
        return null;
    }

    /**
     * Get parent category ID for a subcategory
     * @param int $subcategoryId
     * @return int|null
     */
    public static function getParentCategoryId(int $subcategoryId): ?int {
        foreach (self::$categories as $categoryId => $category) {
            if (isset($category['subcategories'][$subcategoryId])) {
                return $categoryId;
            }
        }
        return null;
    }

    /**
     * Generate HTML select element with all categories
     * @param int|null $selectedId Selected subcategory ID
     * @return string
     */
    public static function generateSelectHtml(?int $selectedId = null): string {
        $html = '<select name="expense_category" id="expense_category" class="form-control">';
        
        foreach (self::$categories as $categoryId => $category) {
            $html .= sprintf('<optgroup label="%s">', htmlspecialchars($category['name']));
            
            foreach ($category['subcategories'] as $subId => $subName) {
                $selected = ($selectedId === $subId) ? ' selected' : '';
                $html .= sprintf(
                    '<option value="%d"%s>%s</option>',
                    $subId,
                    $selected,
                    htmlspecialchars($subName)
                );
            }
            
            $html .= '</optgroup>';
        }
        
        $html .= '</select>';
        return $html;
    }

    /**
     * Get full category path (Category > Subcategory)
     * @param int $subcategoryId
     * @return string|null
     */
    public static function getCategoryPath(int $subcategoryId): ?string {
        $parentId = self::getParentCategoryId($subcategoryId);
        if ($parentId === null) {
            return null;
        }

        $categoryName = self::getCategoryName($parentId);
        $subcategoryName = self::getSubcategoryName($subcategoryId);

        return $categoryName . ' > ' . $subcategoryName;
    }
}
