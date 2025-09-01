<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?>Recipe Collection Manager</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍳</text></svg>">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <span class="logo-icon">🍳</span>
                        <span class="logo-text">Recipe Manager</span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="add-recipe.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add-recipe.php') ? 'active' : ''; ?>">
                                Add Recipe
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?search=" class="nav-link">
                                Browse All
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <div class="header-actions">
                    <?php
                    // Quick stats display
                    $recipes = loadRecipes();
                    $total_recipes = count($recipes);
                    ?>
                    <div class="recipe-count-badge">
                        <span class="count"><?php echo $total_recipes; ?></span>
                        <span class="label">Recipe<?php echo $total_recipes != 1 ? 's' : ''; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">