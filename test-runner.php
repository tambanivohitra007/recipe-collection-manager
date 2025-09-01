<?php
/**
 * Recipe Collection Manager - Test Runner
 * 
 * This script provides basic automated testing for the Recipe Collection Manager.
 * It runs a series of functionality tests to verify that core features work correctly.
 * 
 * GRADING CRITERIA (100 points total):
 * - File operations work (25 pts)
 * - Recipe creation functions (25 pts) 
 * - Forms process data correctly (25 pts)
 * - Basic validation implemented (25 pts)
 * 
 * Usage: Run this file in a web browser or via command line PHP
 */

// Include the functions file
require_once 'includes/functions.php';

// Test results storage
$test_results = [];
$total_points = 0;
$max_points = 100;

/**
 * Helper function to run a test and record results
 */
function runTest($test_name, $test_function, $points_possible) {
    global $test_results, $total_points;
    
    echo "<div class='test-group'>";
    echo "<h3>🧪 Testing: {$test_name}</h3>";
    
    try {
        $result = $test_function();
        $points_earned = $result ? $points_possible : 0;
        $total_points += $points_earned;
        
        $status = $result ? 'PASS' : 'FAIL';
        $status_class = $result ? 'test-pass' : 'test-fail';
        
        echo "<div class='test-result {$status_class}'>";
        echo "<strong>{$status}</strong> - {$test_name} ";
        echo "({$points_earned}/{$points_possible} points)";
        echo "</div>";
        
        $test_results[] = [
            'name' => $test_name,
            'passed' => $result,
            'points_earned' => $points_earned,
            'points_possible' => $points_possible
        ];
        
    } catch (Exception $e) {
        echo "<div class='test-result test-error'>";
        echo "<strong>ERROR</strong> - {$test_name}: " . $e->getMessage();
        echo " (0/{$points_possible} points)";
        echo "</div>";
        
        $test_results[] = [
            'name' => $test_name,
            'passed' => false,
            'points_earned' => 0,
            'points_possible' => $points_possible,
            'error' => $e->getMessage()
        ];
    }
    
    echo "</div>";
}

/**
 * Test 1: Check if required files exist
 */
function test_required_files_exist() {
    $required_files = [
        'includes/functions.php',
        'data/recipes.json', 
        'data/categories.json',
        'assets/style.css',
        'index.php',
        'add-recipe.php',
        'edit-recipe.php'
    ];
    
    $missing_files = [];
    foreach ($required_files as $file) {
        if (!file_exists($file)) {
            $missing_files[] = $file;
        }
    }
    
    if (!empty($missing_files)) {
        echo "<div class='test-detail'>Missing files: " . implode(', ', $missing_files) . "</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ All required files are present</div>";
    return true;
}

/**
 * Test 2: Check if functions are defined
 */
function test_functions_defined() {
    $required_functions = [
        'loadRecipes',
        'saveRecipes', 
        'addNewRecipe',
        'getRecipeById',
        'deleteRecipe',
        'loadCategories'
    ];
    
    $missing_functions = [];
    foreach ($required_functions as $function) {
        if (!function_exists($function)) {
            $missing_functions[] = $function;
        }
    }
    
    if (!empty($missing_functions)) {
        echo "<div class='test-detail'>Missing functions: " . implode(', ', $missing_functions) . "</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ All required functions are defined</div>";
    return true;
}

/**
 * Test 3: Test loadRecipes function
 */
function test_load_recipes_function() {
    // Test with empty file
    $recipes = loadRecipes();
    
    if (!is_array($recipes)) {
        echo "<div class='test-detail'>❌ loadRecipes() should return an array</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ loadRecipes() returns an array</div>";
    return true;
}

/**
 * Test 4: Test saveRecipes function
 */
function test_save_recipes_function() {
    $test_recipes = [
        [
            'id' => 1,
            'name' => 'Test Recipe',
            'ingredients' => 'Test ingredients',
            'instructions' => 'Test instructions',
            'category' => 'Test',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    $result = saveRecipes($test_recipes);
    
    if (!$result) {
        echo "<div class='test-detail'>❌ saveRecipes() should return true on success</div>";
        return false;
    }
    
    // Verify file was actually created/updated
    if (!file_exists('data/recipes.json')) {
        echo "<div class='test-detail'>❌ recipes.json file not created</div>";
        return false;
    }
    
    // Clean up - restore empty array
    saveRecipes([]);
    
    echo "<div class='test-detail'>✅ saveRecipes() successfully saves data</div>";
    return true;
}

/**
 * Test 5: Test addNewRecipe function
 */
function test_add_new_recipe_function() {
    // Clear existing recipes first
    saveRecipes([]);
    
    $result = addNewRecipe('Test Recipe', 'Test ingredients', 'Test instructions', 'Dessert');
    
    if (!$result) {
        echo "<div class='test-detail'>❌ addNewRecipe() should return true on success</div>";
        return false;
    }
    
    // Verify recipe was actually added
    $recipes = loadRecipes();
    if (empty($recipes)) {
        echo "<div class='test-detail'>❌ Recipe was not added to the collection</div>";
        return false;
    }
    
    $recipe = $recipes[0];
    if ($recipe['name'] !== 'Test Recipe') {
        echo "<div class='test-detail'>❌ Recipe name not saved correctly</div>";
        return false;
    }
    
    if (!isset($recipe['id']) || !isset($recipe['created_at'])) {
        echo "<div class='test-detail'>❌ Recipe missing required fields (id, created_at)</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ addNewRecipe() successfully adds recipes with proper structure</div>";
    return true;
}

/**
 * Test 6: Test getRecipeById function
 */
function test_get_recipe_by_id_function() {
    $recipes = loadRecipes();
    
    if (empty($recipes)) {
        // Add a test recipe first
        addNewRecipe('Test Recipe for ID', 'Test ingredients', 'Test instructions', 'Dessert');
        $recipes = loadRecipes();
    }
    
    if (empty($recipes)) {
        echo "<div class='test-detail'>❌ No recipes available to test getRecipeById()</div>";
        return false;
    }
    
    $first_recipe = $recipes[0];
    $found_recipe = getRecipeById($first_recipe['id']);
    
    if (!$found_recipe) {
        echo "<div class='test-detail'>❌ getRecipeById() should find existing recipe</div>";
        return false;
    }
    
    if ($found_recipe['id'] !== $first_recipe['id']) {
        echo "<div class='test-detail'>❌ getRecipeById() returned wrong recipe</div>";
        return false;
    }
    
    // Test non-existent ID
    $non_existent = getRecipeById(99999);
    if ($non_existent !== null) {
        echo "<div class='test-detail'>❌ getRecipeById() should return null for non-existent recipe</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ getRecipeById() works correctly</div>";
    return true;
}

/**
 * Test 7: Test deleteRecipe function
 */
function test_delete_recipe_function() {
    $recipes_before = loadRecipes();
    
    if (empty($recipes_before)) {
        // Add a test recipe first
        addNewRecipe('Recipe to Delete', 'Test ingredients', 'Test instructions', 'Dessert');
        $recipes_before = loadRecipes();
    }
    
    if (empty($recipes_before)) {
        echo "<div class='test-detail'>❌ No recipes available to test deleteRecipe()</div>";
        return false;
    }
    
    $recipe_to_delete = $recipes_before[0];
    $result = deleteRecipe($recipe_to_delete['id']);
    
    if (!$result) {
        echo "<div class='test-detail'>❌ deleteRecipe() should return true on success</div>";
        return false;
    }
    
    $recipes_after = loadRecipes();
    if (count($recipes_after) >= count($recipes_before)) {
        echo "<div class='test-detail'>❌ Recipe count should decrease after deletion</div>";
        return false;
    }
    
    // Verify recipe is actually gone
    $found_recipe = getRecipeById($recipe_to_delete['id']);
    if ($found_recipe !== null) {
        echo "<div class='test-detail'>❌ Deleted recipe should not be findable</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ deleteRecipe() successfully removes recipes</div>";
    return true;
}

/**
 * Test 8: Test loadCategories function
 */
function test_load_categories_function() {
    $categories = loadCategories();
    
    if (!is_array($categories)) {
        echo "<div class='test-detail'>❌ loadCategories() should return an array</div>";
        return false;
    }
    
    if (empty($categories)) {
        echo "<div class='test-detail'>❌ loadCategories() should return at least some categories</div>";
        return false;
    }
    
    // Check for expected categories
    $expected_categories = ['Appetizer', 'Main Course', 'Dessert'];
    $found_expected = 0;
    foreach ($expected_categories as $expected) {
        if (in_array($expected, $categories)) {
            $found_expected++;
        }
    }
    
    if ($found_expected < 2) {
        echo "<div class='test-detail'>⚠️ Categories loaded but may not include expected defaults</div>";
    }
    
    echo "<div class='test-detail'>✅ loadCategories() returns array of categories</div>";
    return true;
}

/**
 * Test 9: Test file structure integrity
 */
function test_file_structure_integrity() {
    // Test that data directory exists and is writable
    if (!is_dir('data')) {
        echo "<div class='test-detail'>❌ Data directory does not exist</div>";
        return false;
    }
    
    if (!is_writable('data')) {
        echo "<div class='test-detail'>❌ Data directory is not writable</div>";
        return false;
    }
    
    // Test JSON files are valid
    $recipes_content = file_get_contents('data/recipes.json');
    $recipes_decoded = json_decode($recipes_content, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<div class='test-detail'>❌ recipes.json contains invalid JSON</div>";
        return false;
    }
    
    $categories_content = file_get_contents('data/categories.json');
    $categories_decoded = json_decode($categories_content, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<div class='test-detail'>❌ categories.json contains invalid JSON</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ File structure and JSON integrity verified</div>";
    return true;
}

/**
 * Test 10: Test form processing simulation
 */
function test_form_processing_simulation() {
    // Simulate form data processing
    $form_data = [
        'name' => 'Form Test Recipe',
        'ingredients' => 'Test ingredient 1\nTest ingredient 2',
        'instructions' => 'Step 1: Test\nStep 2: More testing',
        'category' => 'Dessert'
    ];
    
    // Test input validation (basic)
    if (empty($form_data['name'])) {
        echo "<div class='test-detail'>❌ Form validation should catch empty name</div>";
        return false;
    }
    
    if (strlen($form_data['name']) > 100) {
        echo "<div class='test-detail'>❌ Form should validate name length</div>";
        return false;
    }
    
    // Test adding recipe with form data
    $result = addNewRecipe(
        $form_data['name'],
        $form_data['ingredients'], 
        $form_data['instructions'],
        $form_data['category']
    );
    
    if (!$result) {
        echo "<div class='test-detail'>❌ Form data processing failed</div>";
        return false;
    }
    
    echo "<div class='test-detail'>✅ Form processing simulation successful</div>";
    return true;
}

// HTML output starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Manager - Test Runner</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .test-group {
            background: white;
            margin-bottom: 20px;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .test-group h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
        }
        
        .test-result {
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .test-pass {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .test-fail {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .test-error {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .test-detail {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            margin: 5px 0;
            font-size: 0.9em;
            border-left: 3px solid #dee2e6;
        }
        
        .summary {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        
        .score {
            font-size: 1.5em;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .grade {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .grade-a { background-color: #28a745; }
        .grade-b { background-color: #17a2b8; }
        .grade-c { background-color: #ffc107; color: #333; }
        .grade-d { background-color: #fd7e14; }
        .grade-f { background-color: #dc3545; }
        
        .recommendations {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #2196f3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🧪 Recipe Manager Test Runner</h1>
        <p>Automated testing for PHP Recipe Collection Manager</p>
    </div>

    <?php
    // Run all tests
    echo "<div class='tests-container'>";
    
    runTest('Required Files Exist', 'test_required_files_exist', 10);
    runTest('Functions Defined', 'test_functions_defined', 10);
    runTest('Load Recipes Function', 'test_load_recipes_function', 12);
    runTest('Save Recipes Function', 'test_save_recipes_function', 13);
    runTest('Add New Recipe Function', 'test_add_new_recipe_function', 15);
    runTest('Get Recipe By ID Function', 'test_get_recipe_by_id_function', 10);
    runTest('Delete Recipe Function', 'test_delete_recipe_function', 10);
    runTest('Load Categories Function', 'test_load_categories_function', 8);
    runTest('File Structure Integrity', 'test_file_structure_integrity', 7);
    runTest('Form Processing Simulation', 'test_form_processing_simulation', 5);
    
    echo "</div>";
    
    // Calculate grade
    $percentage = ($total_points / $max_points) * 100;
    $letter_grade = 'F';
    $grade_class = 'grade-f';
    
    if ($percentage >= 90) {
        $letter_grade = 'A';
        $grade_class = 'grade-a';
    } elseif ($percentage >= 80) {
        $letter_grade = 'B';
        $grade_class = 'grade-b';
    } elseif ($percentage >= 70) {
        $letter_grade = 'C';
        $grade_class = 'grade-c';
    } elseif ($percentage >= 60) {
        $letter_grade = 'D';
        $grade_class = 'grade-d';
    }
    
    // Display summary
    ?>
    
    <div class="summary">
        <div class="score">
            Final Score: <?php echo $total_points; ?> / <?php echo $max_points; ?> points 
            (<?php echo round($percentage, 1); ?>%)
            <span class="grade <?php echo $grade_class; ?>"><?php echo $letter_grade; ?></span>
        </div>
        
        <h3>Test Results Summary:</h3>
        <ul>
            <?php foreach ($test_results as $test): ?>
                <li>
                    <?php echo $test['passed'] ? '✅' : '❌'; ?>
                    <strong><?php echo htmlspecialchars($test['name']); ?>:</strong>
                    <?php echo $test['points_earned']; ?>/<?php echo $test['points_possible']; ?> points
                    <?php if (isset($test['error'])): ?>
                        <br><em>Error: <?php echo htmlspecialchars($test['error']); ?></em>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <?php if ($percentage < 100): ?>
            <div class="recommendations">
                <h4>💡 Recommendations for Improvement:</h4>
                <ul>
                    <?php if ($percentage < 70): ?>
                        <li>Focus on implementing the core functions in <code>includes/functions.php</code></li>
                        <li>Make sure all functions return appropriate values (arrays, booleans, etc.)</li>
                        <li>Test your functions manually by adding and viewing recipes</li>
                    <?php endif; ?>
                    
                    <?php if ($total_points < 50): ?>
                        <li><strong>Priority:</strong> Implement <code>loadRecipes()</code> and <code>saveRecipes()</code> first</li>
                        <li>Check that your JSON files are properly formatted</li>
                        <li>Ensure the data directory is writable</li>
                    <?php endif; ?>
                    
                    <?php if ($percentage >= 70 && $percentage < 90): ?>
                        <li>Great progress! Focus on edge cases and error handling</li>
                        <li>Make sure deleted recipes are properly removed</li>
                        <li>Verify that recipe IDs are unique and properly generated</li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="recommendations" style="background-color: #d4edda; border-color: #28a745;">
                <h4>🎉 Excellent Work!</h4>
                <p>All tests are passing! Your Recipe Collection Manager is working perfectly.</p>
                <p><strong>Next steps:</strong> Consider adding advanced features like search functionality, 
                recipe categories, or data validation.</p>
            </div>
        <?php endif; ?>
        
        <p style="margin-top: 20px; text-align: center;">
            <a href="index.php" style="background-color: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                🍳 Back to Recipe Manager
            </a>
        </p>
    </div>
</body>
</html>