<?php
/**
 * Recipe Collection Manager - Edit Recipe Page
 * This page allows users to edit existing recipes
 */

// Include required files
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Initialize variables
$error_messages = [];
$success_message = '';
$recipe = null;
$recipe_id = null;

// Get recipe ID from URL
if (isset($_GET['id'])) {
    $recipe_id = (int)$_GET['id'];
    $recipe = getRecipeById($recipe_id);
    
    if (!$recipe) {
        $error_messages[] = "Recipe not found.";
    }
} else {
    $error_messages[] = "No recipe ID specified.";
}

// Initialize form data
$form_data = [
    'name' => $recipe['name'] ?? '',
    'ingredients' => $recipe['ingredients'] ?? '',
    'instructions' => $recipe['instructions'] ?? '',
    'category' => $recipe['category'] ?? ''
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $recipe) {
    // Get form data and sanitize
    $form_data['name'] = trim($_POST['name'] ?? '');
    $form_data['ingredients'] = trim($_POST['ingredients'] ?? '');
    $form_data['instructions'] = trim($_POST['instructions'] ?? '');
    $form_data['category'] = trim($_POST['category'] ?? '');
    
    // Validate form data
    if (empty($form_data['name'])) {
        $error_messages[] = "Recipe name is required.";
    }
    
    if (empty($form_data['ingredients'])) {
        $error_messages[] = "Ingredients are required.";
    }
    
    if (empty($form_data['instructions'])) {
        $error_messages[] = "Instructions are required.";
    }
    
    if (empty($form_data['category'])) {
        $error_messages[] = "Category is required.";
    }
    
    // Additional validation
    if (strlen($form_data['name']) > 100) {
        $error_messages[] = "Recipe name must be less than 100 characters.";
    }
    
    if (strlen($form_data['ingredients']) > 1000) {
        $error_messages[] = "Ingredients must be less than 1000 characters.";
    }
    
    if (strlen($form_data['instructions']) > 2000) {
        $error_messages[] = "Instructions must be less than 2000 characters.";
    }
    
    // If no errors, try to update the recipe
    if (empty($error_messages)) {
        $result = updateRecipe(
            $recipe_id,
            $form_data['name'], 
            $form_data['ingredients'], 
            $form_data['instructions'], 
            $form_data['category']
        );
        
        if ($result) {
            $success_message = "Recipe updated successfully!";
            // Reload recipe data to show updates
            $recipe = getRecipeById($recipe_id);
        } else {
            $error_messages[] = "Error updating recipe. Please try again.";
        }
    }
}

// Load categories for dropdown
$categories = loadCategories();
?>

<div class="container">
    <?php if ($recipe): ?>
        <h1>Edit Recipe: <?php echo htmlspecialchars($recipe['name']); ?></h1>
    <?php else: ?>
        <h1>Edit Recipe</h1>
    <?php endif; ?>
    
    <!-- Navigation -->
    <div class="navigation">
        <a href="index.php" class="btn btn-secondary">← Back to Recipes</a>
        <?php if ($recipe): ?>
            <span class="recipe-id">Recipe ID: <?php echo $recipe['id']; ?></span>
        <?php endif; ?>
    </div>
    
    <!-- Success Message -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
            <a href="index.php" class="btn btn-small">View All Recipes</a>
        </div>
    <?php endif; ?>
    
    <!-- Error Messages -->
    <?php if (!empty($error_messages)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($error_messages as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($recipe): ?>
        <!-- Recipe Edit Form -->
        <form method="POST" action="edit-recipe.php?id=<?php echo $recipe['id']; ?>" class="recipe-form">
            <!-- Recipe Name -->
            <div class="form-group">
                <label for="name">Recipe Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?php echo htmlspecialchars($form_data['name']); ?>"
                       placeholder="Enter recipe name"
                       maxlength="100"
                       required>
                <small class="form-help">Maximum 100 characters</small>
            </div>
            
            <!-- Category -->
            <div class="form-group">
                <label for="category">Category *</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"
                                <?php echo ($form_data['category'] === $category) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Ingredients -->
            <div class="form-group">
                <label for="ingredients">Ingredients *</label>
                <textarea id="ingredients" 
                          name="ingredients" 
                          placeholder="List ingredients (one per line)"
                          rows="8"
                          maxlength="1000"
                          required><?php echo htmlspecialchars($form_data['ingredients']); ?></textarea>
                <small class="form-help">List each ingredient on a new line. Maximum 1000 characters</small>
            </div>
            
            <!-- Instructions -->
            <div class="form-group">
                <label for="instructions">Instructions *</label>
                <textarea id="instructions" 
                          name="instructions" 
                          placeholder="Enter cooking instructions step by step"
                          rows="10"
                          maxlength="2000"
                          required><?php echo htmlspecialchars($form_data['instructions']); ?></textarea>
                <small class="form-help">Provide detailed step-by-step instructions. Maximum 2000 characters</small>
            </div>
            
            <!-- Recipe Metadata -->
            <div class="form-group readonly">
                <label>Recipe Information</label>
                <div class="recipe-meta">
                    <p><strong>Recipe ID:</strong> <?php echo $recipe['id']; ?></p>
                    <p><strong>Created:</strong> <?php echo htmlspecialchars($recipe['created_at']); ?></p>
                    <?php if (isset($recipe['updated_at'])): ?>
                        <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($recipe['updated_at']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Recipe</button>
                <button type="reset" class="btn btn-secondary" onclick="return confirm('Are you sure you want to reset all changes?')">Reset Changes</button>
                <a href="index.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
        
        <!-- Danger Zone -->
        <div class="danger-zone">
            <h3>Danger Zone</h3>
            <p>Permanently delete this recipe. This action cannot be undone.</p>
            <form method="POST" action="index.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete this recipe? This action cannot be undone.');">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                <button type="submit" name="delete_recipe" class="btn btn-danger">Delete Recipe</button>
            </form>
        </div>
        
    <?php else: ?>
        <!-- Recipe Not Found -->
        <div class="not-found">
            <h2>Recipe Not Found</h2>
            <p>The recipe you're looking for doesn't exist or has been deleted.</p>
            <a href="index.php" class="btn btn-primary">Back to Recipe List</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>