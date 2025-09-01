<?php
/**
 * Recipe Collection Manager - Homepage
 * This page displays all recipes and provides search functionality
 */

// Include required files
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Handle search functionality
$search_term = '';
if (isset($_GET['search'])) {
    $search_term = trim($_GET['search']);
}

// Load all recipes
$recipes = loadRecipes();

// Filter recipes if search term is provided
if (!empty($search_term)) {
    $recipes = array_filter($recipes, function($recipe) use ($search_term) {
        return stripos($recipe['name'], $search_term) !== false || 
               stripos($recipe['ingredients'], $search_term) !== false ||
               stripos($recipe['category'], $search_term) !== false;
    });
}

// Handle recipe deletion
if (isset($_POST['delete_recipe'])) {
    $recipe_id = (int)$_POST['recipe_id'];
    if (deleteRecipe($recipe_id)) {
        $success_message = "Recipe deleted successfully!";
        // Reload recipes after deletion
        $recipes = loadRecipes();
    } else {
        $error_message = "Error deleting recipe.";
    }
}
?>

<div class="container">
    <h1>My Recipe Collection</h1>
    
    <!-- Success/Error Messages -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    
    <!-- Search Bar -->
    <div class="search-section">
        <form method="GET" action="index.php" class="search-form">
            <input type="text" 
                   name="search" 
                   placeholder="Search recipes by name, ingredients, or category..." 
                   value="<?php echo htmlspecialchars($search_term); ?>"
                   class="search-input">
            <button type="submit" class="btn btn-search">Search</button>
            <?php if (!empty($search_term)): ?>
                <a href="index.php" class="btn btn-clear">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Add New Recipe Button -->
    <div class="action-buttons">
        <a href="add-recipe.php" class="btn btn-primary">Add New Recipe</a>
    </div>
    
    <!-- Recipe Grid -->
    <div class="recipes-grid">
        <?php if (empty($recipes)): ?>
            <div class="no-recipes">
                <p>No recipes found. <a href="add-recipe.php">Add your first recipe!</a></p>
            </div>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="recipe-header">
                        <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['name']); ?></h3>
                        <span class="recipe-category"><?php echo htmlspecialchars($recipe['category']); ?></span>
                    </div>
                    
                    <div class="recipe-content">
                        <div class="recipe-section">
                            <h4>Ingredients:</h4>
                            <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
                        </div>
                        
                        <div class="recipe-section">
                            <h4>Instructions:</h4>
                            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="recipe-footer">
                        <small class="recipe-date">Added: <?php echo htmlspecialchars($recipe['created_at']); ?></small>
                        <div class="recipe-actions">
                            <a href="edit-recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-small btn-edit">Edit</a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                                <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                                <button type="submit" name="delete_recipe" class="btn btn-small btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Recipe Count -->
    <div class="recipe-count">
        <?php 
        $total_count = count($recipes);
        if (!empty($search_term)) {
            echo "Showing {$total_count} recipe(s) matching '{$search_term}'";
        } else {
            echo "Total recipes: {$total_count}";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>