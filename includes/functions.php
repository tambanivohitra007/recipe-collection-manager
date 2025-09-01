<?php
/**
 * Recipe Collection Manager - Core Functions
 * 
 * This file contains all the essential functions for managing recipes.
 * Students will implement these functions as part of their learning progression.
 * 
 * LEARNING PROGRESSION:
 * Week 1: Complete loadRecipes() and saveRecipes() functions
 * Week 2: Implement addNewRecipe() function
 * Week 3: Add getRecipeById(), updateRecipe(), and deleteRecipe() functions
 * Week 4: Implement search and category functionality
 * Week 5: Add input validation and error handling
 * Week 6: Enhance with additional features
 */

// Define constants for file paths
define('RECIPES_FILE', __DIR__ . '/../data/recipes.json');
define('CATEGORIES_FILE', __DIR__ . '/../data/categories.json');

/**
 * Load all recipes from the JSON file
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Check if the recipes.json file exists
 * 2. If file doesn't exist, return empty array []
 * 3. Read the file contents
 * 4. Decode JSON to PHP array
 * 5. Handle JSON decode errors gracefully
 * 6. Return array of recipes
 * 
 * Expected return format:
 * [
 *   [
 *     "id" => 1,
 *     "name" => "Recipe Name",
 *     "ingredients" => "List of ingredients",
 *     "instructions" => "Cooking instructions",
 *     "category" => "Category name",
 *     "created_at" => "2024-01-01"
 *   ]
 * ]
 * 
 * @return array Array of recipes
 */
function loadRecipes() {
    // TODO: Week 1 - Implement recipe loading from JSON file
    
    // HINT: Use file_exists() to check if file exists
    // HINT: Use file_get_contents() to read file
    // HINT: Use json_decode() to convert JSON to array
    // HINT: Always return an array, even if empty
    
    return []; // Placeholder - students will replace this
}

/**
 * Save recipes array to the JSON file
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Create the data directory if it doesn't exist
 * 2. Convert recipes array to JSON format
 * 3. Write JSON to recipes.json file
 * 4. Handle file write errors
 * 5. Return true on success, false on failure
 * 
 * @param array $recipes Array of recipes to save
 * @return bool True on success, false on failure
 */
function saveRecipes($recipes) {
    // TODO: Week 1 - Implement recipe saving to JSON file
    
    // HINT: Use dirname() and is_dir() to check directory
    // HINT: Use mkdir() to create directory if needed
    // HINT: Use json_encode() with JSON_PRETTY_PRINT for readable JSON
    // HINT: Use file_put_contents() to write file
    
    return false; // Placeholder - students will replace this
}

/**
 * Add a new recipe to the collection
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Load existing recipes
 * 2. Generate new unique ID (find highest existing ID + 1)
 * 3. Create recipe array with all required fields
 * 4. Add current date/time as created_at
 * 5. Add new recipe to recipes array
 * 6. Save updated recipes to file
 * 7. Return true on success, false on failure
 * 
 * @param string $name Recipe name
 * @param string $ingredients Recipe ingredients
 * @param string $instructions Cooking instructions
 * @param string $category Recipe category
 * @return bool True on success, false on failure
 */
function addNewRecipe($name, $ingredients, $instructions, $category) {
    // TODO: Week 2 - Implement adding new recipes
    
    // HINT: Use loadRecipes() to get existing recipes
    // HINT: Loop through recipes to find highest ID
    // HINT: Use date('Y-m-d H:i:s') for created_at timestamp
    // HINT: Create associative array with all recipe fields
    // HINT: Use array_push() or [] to add to recipes array
    // HINT: Use saveRecipes() to persist changes
    
    return false; // Placeholder - students will replace this
}

/**
 * Get a specific recipe by its ID
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Load all recipes
 * 2. Search through recipes array for matching ID
 * 3. Return recipe array if found
 * 4. Return null if not found
 * 
 * @param int $id Recipe ID to search for
 * @return array|null Recipe array if found, null otherwise
 */
function getRecipeById($id) {
    // TODO: Week 3 - Implement recipe lookup by ID
    
    // HINT: Use loadRecipes() to get all recipes
    // HINT: Use foreach loop or array_filter() to find matching ID
    // HINT: Make sure to compare ID as integer
    
    return null; // Placeholder - students will replace this
}

/**
 * Update an existing recipe
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Load all recipes
 * 2. Find recipe with matching ID
 * 3. Update recipe fields with new values
 * 4. Add updated_at timestamp
 * 5. Save updated recipes array
 * 6. Return true on success, false if recipe not found
 * 
 * @param int $id Recipe ID to update
 * @param string $name New recipe name
 * @param string $ingredients New ingredients
 * @param string $instructions New instructions
 * @param string $category New category
 * @return bool True on success, false on failure
 */
function updateRecipe($id, $name, $ingredients, $instructions, $category) {
    // TODO: Week 3 - Implement recipe updating
    
    // HINT: Use loadRecipes() to get all recipes
    // HINT: Loop through recipes to find matching ID
    // HINT: Update recipe fields in place
    // HINT: Add 'updated_at' field with current timestamp
    // HINT: Use saveRecipes() to persist changes
    
    return false; // Placeholder - students will replace this
}

/**
 * Delete a recipe by its ID
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Load all recipes
 * 2. Find and remove recipe with matching ID
 * 3. Save updated recipes array
 * 4. Return true on success, false if recipe not found
 * 
 * @param int $id Recipe ID to delete
 * @return bool True on success, false on failure
 */
function deleteRecipe($id) {
    // TODO: Week 3 - Implement recipe deletion
    
    // HINT: Use loadRecipes() to get all recipes
    // HINT: Use array_filter() to remove recipe with matching ID
    // HINT: Re-index array with array_values() after filtering
    // HINT: Use saveRecipes() to persist changes
    
    return false; // Placeholder - students will replace this
}

/**
 * Load recipe categories from JSON file
 * 
 * TODO: Students need to implement this function
 * 
 * Requirements:
 * 1. Check if categories.json file exists
 * 2. If file doesn't exist, return default categories
 * 3. Read and decode JSON file
 * 4. Return array of category strings
 * 
 * @return array Array of category names
 */
function loadCategories() {
    // TODO: Week 4 - Implement category loading
    
    // Default categories if file doesn't exist
    $default_categories = [
        'Appetizer',
        'Main Course', 
        'Dessert',
        'Beverage',
        'Snack'
    ];
    
    // HINT: Similar to loadRecipes() but simpler
    // HINT: Return default categories if file doesn't exist
    
    return $default_categories; // Placeholder - students can enhance this
}

/**
 * Search recipes by name, ingredients, or category
 * 
 * TODO: Students can implement this as an enhancement
 * 
 * Requirements:
 * 1. Load all recipes
 * 2. Filter recipes based on search term
 * 3. Search in name, ingredients, and category fields
 * 4. Return array of matching recipes
 * 
 * @param string $search_term Search term
 * @return array Array of matching recipes
 */
function searchRecipes($search_term) {
    // TODO: Week 4 - Implement recipe search functionality
    
    // HINT: Use loadRecipes() to get all recipes
    // HINT: Use stripos() for case-insensitive search
    // HINT: Check multiple fields (name, ingredients, category)
    // HINT: Use array_filter() to filter results
    
    return loadRecipes(); // Placeholder - returns all recipes for now
}

/**
 * Get recipes by category
 * 
 * TODO: Students can implement this as an enhancement
 * 
 * Requirements:
 * 1. Load all recipes
 * 2. Filter recipes by exact category match
 * 3. Return array of recipes in specified category
 * 
 * @param string $category Category name
 * @return array Array of recipes in category
 */
function getRecipesByCategory($category) {
    // TODO: Week 4 - Implement category filtering
    
    // HINT: Use loadRecipes() to get all recipes
    // HINT: Use array_filter() to filter by category
    // HINT: Use exact string match for category
    
    return []; // Placeholder - students will implement this
}

/**
 * Validate recipe data
 * 
 * TODO: Students can implement this as an enhancement
 * 
 * Requirements:
 * 1. Check that all required fields are present
 * 2. Validate field lengths and formats
 * 3. Return array of validation errors
 * 
 * @param array $recipe_data Recipe data to validate
 * @return array Array of validation errors (empty if valid)
 */
function validateRecipeData($recipe_data) {
    // TODO: Week 5 - Implement input validation
    
    $errors = [];
    
    // HINT: Check for required fields
    // HINT: Validate string lengths
    // HINT: Check for valid category
    // HINT: Sanitize input data
    
    return $errors; // Return empty array for now
}

/**
 * Get recipe statistics
 * 
 * TODO: Students can implement this as an enhancement
 * 
 * Requirements:
 * 1. Count total recipes
 * 2. Count recipes by category
 * 3. Find most recent recipes
 * 4. Return statistics array
 * 
 * @return array Array of recipe statistics
 */
function getRecipeStats() {
    // TODO: Week 6 - Implement statistics functionality
    
    $recipes = loadRecipes();
    
    $stats = [
        'total_recipes' => count($recipes),
        'categories' => [],
        'recent_recipes' => []
    ];
    
    // HINT: Use array_count_values() for category counts
    // HINT: Use usort() to sort by date for recent recipes
    
    return $stats;
}

/**
 * Export recipes to different formats
 * 
 * TODO: Students can implement this as an advanced feature
 * 
 * Requirements:
 * 1. Support CSV export format
 * 2. Support plain text format
 * 3. Return formatted string
 * 
 * @param string $format Export format ('csv', 'txt')
 * @return string Formatted export data
 */
function exportRecipes($format = 'csv') {
    // TODO: Week 6 - Implement export functionality
    
    $recipes = loadRecipes();
    
    switch ($format) {
        case 'csv':
            // HINT: Create CSV headers and data rows
            return "Name,Category,Ingredients,Instructions\n"; // Placeholder
            
        case 'txt':
            // HINT: Format as readable text
            return "Recipe Collection Export\n"; // Placeholder
            
        default:
            return "Unsupported format";
    }
}

// Helper function to ensure data directory exists
function ensureDataDirectory() {
    $data_dir = __DIR__ . '/../data';
    if (!is_dir($data_dir)) {
        mkdir($data_dir, 0777, true);
    }
}

// Initialize data directory when this file is included
ensureDataDirectory();

?>