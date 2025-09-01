    </main>
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Recipe Collection Manager</h4>
                    <p>A simple PHP application for managing your favorite recipes.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">All Recipes</a></li>
                        <li><a href="add-recipe.php">Add Recipe</a></li>
                        <li><a href="test-runner.php">Run Tests</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Categories</h4>
                    <ul class="footer-links">
                        <?php
                        $categories = loadCategories();
                        foreach (array_slice($categories, 0, 4) as $category):
                        ?>
                            <li><a href="index.php?search=<?php echo urlencode($category); ?>"><?php echo htmlspecialchars($category); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Statistics</h4>
                    <div class="footer-stats">
                        <?php
                        $recipes = loadRecipes();
                        $stats = [
                            'total' => count($recipes),
                            'categories' => count(array_unique(array_column($recipes, 'category')))
                        ];
                        ?>
                        <p><strong><?php echo $stats['total']; ?></strong> Total Recipes</p>
                        <p><strong><?php echo $stats['categories']; ?></strong> Categories</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Recipe Collection Manager. Created for educational purposes.</p>
                <p class="footer-note">This is a student project built with PHP and JSON file storage.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Simple JavaScript enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-expand textareas based on content
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(function(textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });
            
            // Character count for textareas
            textareas.forEach(function(textarea) {
                const maxLength = textarea.getAttribute('maxlength');
                if (maxLength) {
                    const counter = document.createElement('div');
                    counter.className = 'char-counter';
                    textarea.parentNode.appendChild(counter);
                    
                    function updateCounter() {
                        const remaining = maxLength - textarea.value.length;
                        counter.textContent = remaining + ' characters remaining';
                        counter.className = 'char-counter' + (remaining < 50 ? ' warning' : '');
                    }
                    
                    textarea.addEventListener('input', updateCounter);
                    updateCounter();
                }
            });
            
            // Confirm delete actions
            const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
            deleteForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const recipeName = form.closest('.recipe-card')?.querySelector('.recipe-title')?.textContent;
                    const message = recipeName ? 
                        `Are you sure you want to delete "${recipeName}"? This action cannot be undone.` :
                        'Are you sure you want to delete this recipe? This action cannot be undone.';
                    
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
            
            // Auto-hide success messages after 5 seconds
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
            
            // Focus first input on form pages
            const firstInput = document.querySelector('.recipe-form input, .recipe-form textarea');
            if (firstInput) {
                firstInput.focus();
            }
        });
    </script>
</body>
</html>