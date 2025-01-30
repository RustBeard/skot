<?php

class Categories
{
    private static array $categories = [
        'income' => [
            1 => [
                'name' => 'Salary',
                'type' => 'income'
            ],
            2 => [
                'name' => 'Refunds',
                'type' => 'income'
            ],
            3 => [
                'name' => 'Gifts',
                'type' => 'income'
            ],
            4 => [
                'name' => 'Child Support',
                'type' => 'income'
            ]
        ],
        'expense' => [
            1 => [
                'name' => 'Food',
                'type' => 'expense',
                'subcategories' => [
                    101 => 'Groceries',
                    102 => 'Snacks and sweets',
                    103 => 'Restaurants and fast food'
                ]
            ],
            2 => [
                'name' => 'General Shopping',
                'type' => 'expense',
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
                'type' => 'expense',
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
                'type' => 'expense',
                'subcategories' => [
                    401 => 'Smartphone (bills)',
                    402 => 'Internet',
                    403 => 'Software & subscriptions'
                ]
            ],
            5 => [
                'name' => 'Transport',
                'type' => 'expense',
                'subcategories' => [
                    501 => 'Public transport',
                    502 => 'Taxi',
                    503 => 'Other'
                ]
            ],
            6 => [
                'name' => 'Car',
                'type' => 'expense',
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
                'type' => 'expense',
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
                'type' => 'expense',
                'subcategories' => [
                    801 => 'Adult clothing',
                    802 => 'Children\'s clothing'
                ]
            ],
            9 => [
                'name' => 'Entertainment & Hobbies',
                'type' => 'expense',
                'subcategories' => [
                    901 => 'Typical entertainment',
                    902 => 'Developmental & active'
                ]
            ],
            10 => [
                'name' => 'Education',
                'type' => 'expense'
            ],
            11 => [
                'name' => 'Children',
                'type' => 'expense',
                'subcategories' => [
                    1101 => 'School',
                    1102 => 'Toys'
                ]
            ],
            12 => [
                'name' => 'Vacations & Travel',
                'type' => 'expense'
            ],
            13 => [
                'name' => 'Gifts & Donations',
                'type' => 'expense'
            ],
            14 => [
                'name' => 'Other',
                'type' => 'expense'
            ]
        ]
    ];

    /**
     * Get all categories (both income and expense)
     * @return array
     */
    public static function getAllCategories(): array
    {
        return self::$categories;
    }

    /**
     * Get all income categories
     * @return array
     */
    public static function getIncomeCategories(): array
    {
        return self::$categories['income'];
    }

    /**
     * Get all expense categories
     * @return array
     */
    public static function getExpenseCategories(): array
    {
        return self::$categories['expense'];
    }

    /**
     * Get category by ID and type
     * @param int $categoryId
     * @param string $type ('income' or 'expense')
     * @return array|null
     */
    public static function getCategoryById(int $categoryId, string $type): ?array
    {
        return self::$categories[$type][$categoryId] ?? null;
    }

    /**
     * Get category name by ID and type
     * @param int $categoryId
     * @param string $type ('income' or 'expense')
     * @return string|null
     */
    public static function getCategoryName(int $categoryId, string $type): ?string
    {
        return self::$categories[$type][$categoryId]['name'] ?? null;
    }

    /**
     * Get subcategories for an expense category
     * @param int $categoryId
     * @return array|null
     */
    public static function getExpenseSubcategories(int $categoryId): ?array
    {
        return self::$categories['expense'][$categoryId]['subcategories'] ?? null;
    }

    /**
     * Get subcategory name by category ID and subcategory ID
     * @param int $categoryId
     * @param int $subcategoryId
     * @return string|null
     */
    public static function getExpenseSubcategoryName(int $categoryId, int $subcategoryId): ?string
    {
        return self::$categories['expense'][$categoryId]['subcategories'][$subcategoryId] ?? null;
    }
}
