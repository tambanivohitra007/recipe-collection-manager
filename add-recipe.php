<?php
/**
 * Recipe Collection Manager - Add Recipe Page
 * This page allows users to add new recipes to the collection
 */

// Include required files
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Initialize variables
$error_messages = [];
$success_message = '';
$form_data = [
    'name' => '',
    'ingredients' => '',
    'instructions' => '',
    'category' => ''
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    
    // If no errors, try to add the recipe
    if (empty($error_messages)) {
        $result = addNewRecipe(
            $form_data['name'], 
            $form_data['ingredients'], 
            $form_data['instructions'], 
            $form_data['category']
        );
        
        if ($result) {
            $success_message = "Recipe added successfully!";
            // Clear form data on success
            $form_data = [
                'name' => '',
                'ingredients' => '',
                'instructions' => '',
                'category' => ''
            ];
        } else {
            $error_messages[] = "Error adding recipe. Please try again.";
        }
    }
}

// Load categories for dropdown
$categories = loadCategories();
?>

<div class="container">
    <h1>Add New Recipe</h1>
    
    <!-- Navigation -->
    <div class="navigation">
        <a href="index.php" class="btn btn-secondary">← Back to Recipes</a>
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
    
    <!-- Recipe Form -->
    <form method="POST" action="add-recipe.php" class="recipe-form">
        <!-- Recipe Name -->
        <div class="form-group">
            <label for="name">Recipe Name *</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?php echo htmlspecialchars($form_data['name']); ?>"
                   placeholder="Enter recipe name (e.g., Chocolate Chip Cookies)"
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
            <small class="form-help">Choose the category that best fits your recipe</small>
        </div>
        
        <!-- Ingredients -->
        <div class="form-group">
            <label for="ingredients">Ingredients *</label>
            <textarea id="ingredients" 
                      name="ingredients" 
                      placeholder="List ingredients (one per line)&#10;Example:&#10;2 cups all-purpose flour&#10;1 cup sugar&#10;1/2 cup butter"
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
                      placeholder="Enter cooking instructions step by step&#10;Example:&#10;1. Preheat oven to 350°F&#10;2. Mix dry ingredients&#10;3. Add wet ingredients and mix well&#10;4. Bake for 12-15 minutes"
                      rows="10"
                      maxlength="2000"
                      required><?php echo htmlspecialchars($form_data['instructions']); ?></textarea>
            <small class="form-help">Provide detailed step-by-step instructions. Maximum 2000 characters</small>
        </div>
        
        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Recipe</button>
            <button type="reset" class="btn btn-secondary" onclick="return confirm('Are you sure you want to clear all fields?')">Clear Form</button>
            <a href="index.php" class="btn btn-cancel">Cancel</a>
        </div>
    </form>
    
    <!-- Form Tips -->
    <div class="form-tips">
        <h3>Tips for Adding Great Recipes:</h3>
        <ul>
            <li><strong>Be specific:</strong> Include exact measurements and cooking times</li>
            <li><strong>List ingredients in order:</strong> List them in the order they'll be used</li>
            <li><strong>Number your steps:</strong> Make instructions easy to follow</li>
            <li><strong>Include cooking temperatures and times:</strong> This helps ensure success</li>
            <li><strong>Add personal notes:</strong> Include any tips or variations you've discovered</li>
        </ul>
    </div>
</div>

<?php include 'includes/footer.php'; ?>