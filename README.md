# PHP Recipe Collection Manager

A beginner-friendly PHP web application for managing personal recipe collections using JSON file storage. Perfect for students learning web development fundamentals.

## Project Overview

This is a **progressive learning project** designed for students to build a fully functional recipe management system step by step. Students start with skeleton code containing TODO comments and implement functionality over multiple weeks.

### Learning Objectives

- **PHP Fundamentals**: Variables, arrays, functions, form processing
- **File I/O Operations**: Reading/writing JSON files, file system management  
- **Web Development**: HTML forms, CSS styling, responsive design
- **Data Management**: CRUD operations, data validation, search functionality
- **Best Practices**: Input sanitization, error handling, code organization

## Quick Start

### Prerequisites

- PHP 7.4 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- Text editor or IDE
- Basic knowledge of HTML, CSS, and PHP

### Installation

1. **Clone/Download** this repository:
   ```bash
   git clone <repository-url>
   cd recipe-collection-manager
   ```

2. **Start PHP development server**: (If you are not using XAMPP or Laragon)
   ```bash
   php -S localhost:8000
   ```

3. **Open your browser** and navigate to:
   ```
   http://localhost:8000
   ```

4. **Run tests** to check your progress:
   ```
   http://localhost:8000/test-runner.php
   ```

## Project Structure

```
recipe-collection-manager/
├── index.php              # Homepage with recipe list and search
├── add-recipe.php         # Form for adding new recipes
├── edit-recipe.php        # Form for editing existing recipes
├── test-runner.php        # Automated testing system
├── includes/
│   ├── functions.php      # Core functions (students implement these)
│   ├── header.php         # Common HTML header and navigation
│   └── footer.php         # Common HTML footer
├── data/
│   ├── recipes.json       # Recipe storage (starts empty)
│   └── categories.json    # Recipe categories
├── assets/
│   └── style.css          # Responsive CSS styling
├── .github/
│   └── workflows/
│       └── test.yml       # GitHub Actions for automated testing
└── README.md              # This file
```

## Learning Progression

Students should complete the project in this order:

### Task 1: File Operations (25 points)
**Goal**: Implement basic file reading and writing

**Tasks**:
- [ ] Complete `loadRecipes()` function in `includes/functions.php`
- [ ] Complete `saveRecipes()` function in `includes/functions.php`
- [ ] Test with `test-runner.php`

**Key Concepts**: File I/O, JSON encoding/decoding, error handling

### Task 2: Recipe Creation (25 points)  
**Goal**: Enable adding new recipes

**Tasks**:
- [ ] Complete `addNewRecipe()` function
- [ ] Implement ID generation and timestamp creation
- [ ] Test form submission on `add-recipe.php`

**Key Concepts**: Form processing, data structure, unique ID generation

### Task 3: Recipe Management (25 points)
**Goal**: Enable editing and deleting recipes  

**Tasks**:
- [ ] Complete `getRecipeById()` function
- [ ] Complete `updateRecipe()` function  
- [ ] Complete `deleteRecipe()` function
- [ ] Test edit functionality on `edit-recipe.php`

**Key Concepts**: Data lookup, array manipulation, CRUD operations

### Task 4: Search and Categories (15 points)
**Goal**: Add search and filtering capabilities

**Tasks**:
- [ ] Test search functionality on homepage
- [ ] Implement category filtering
- [ ] Complete `loadCategories()` function enhancement

**Key Concepts**: String searching, data filtering, user experience

### Task 5: Validation and Security (10 points)
**Goal**: Add proper input validation

**Tasks**:
- [ ] Implement form validation  
- [ ] Add input sanitization
- [ ] Improve error handling
- [ ] Test edge cases

**Key Concepts**: Input validation, security, error handling

### Task 6: Enhancement Features (Bonus)
**Goal**: Add advanced features

**Tasks**:
- [ ] Recipe statistics
- [ ] Export functionality  
- [ ] Advanced search
- [ ] UI improvements

**Key Concepts**: Data analysis, file exports, advanced PHP

## Testing Your Progress

### Automated Testing

Run the test suite to check your implementation:

```bash
# Via web browser
http://localhost:8000/test-runner.php (depending on your web server configuration)

# Via command line
php test-runner.php
```

### Test Categories

The test runner checks:

1. **File Structure** (10 pts) - All required files present
2. **Function Definitions** (10 pts) - Functions exist and callable
3. **Load Recipes** (12 pts) - Reading JSON data correctly
4. **Save Recipes** (13 pts) - Writing JSON data correctly  
5. **Add New Recipe** (15 pts) - Creating recipes with proper structure
6. **Get Recipe By ID** (10 pts) - Finding specific recipes
7. **Delete Recipe** (10 pts) - Removing recipes correctly
8. **Load Categories** (8 pts) - Category system working
9. **File Integrity** (7 pts) - JSON files valid and accessible
10. **Form Processing** (5 pts) - Form data handled correctly

### Grade Scale

- **A (90-100%)**: Excellent - All core functionality working
- **B (80-89%)**: Good - Most features implemented
- **C (70-79%)**: Satisfactory - Basic functionality working
- **D (60-69%)**: Needs Improvement - Some features missing
- **F (<60%)**: Incomplete - Major functionality missing


## Features

### Current Features (Already Implemented)

- **Responsive Design**: Mobile-friendly CSS layout
- **Clean UI**: Professional styling with nice colors and animations  
- **Navigation**: Intuitive menu system
- **Form Validation**: Client-side and server-side validation
- **Search Interface**: Search box with clear functionality
- **CRUD Interface**: Add, view, edit, delete recipe forms
- **Category System**: Recipe categorization
- **Security**: Output escaping with `htmlspecialchars()`

### Features to Implement (Student Tasks)

- **Data Persistence**: JSON file read/write operations
- **Recipe Management**: CRUD operations implementation
- **Search Functionality**: Filter recipes by keywords
- **ID Management**: Unique recipe identification  
- **Error Handling**: Graceful error management
- **Data Validation**: Input sanitization and validation

## Common Issues and Solutions

### Issue: "Call to undefined function" errors

**Solution**: Make sure you've implemented all required functions in `includes/functions.php`

### Issue: JSON parsing errors  

**Solution**: Check that your JSON files contain valid JSON:
```bash
php -r "json_decode(file_get_contents('data/recipes.json')); echo json_last_error();"
```

### Issue: Recipes not persisting

**Solution**: Verify that:
1. `saveRecipes()` function is implemented correctly
2. Data directory has write permissions
3. JSON encoding is working properly

## Learning Resources

### PHP Documentation
- [PHP Manual](https://www.php.net/manual/)
- [PHP File Functions](https://www.php.net/manual/en/ref.filesystem.php)
- [PHP JSON Functions](https://www.php.net/manual/en/ref.json.php)
- [PHP Array Functions](https://www.php.net/manual/en/ref.array.php)

### Helpful Tutorials
- [PHP File Handling](https://www.w3schools.com/php/php_file.asp)
- [Working with JSON in PHP](https://www.php.net/manual/en/book.json.php)
- [PHP Form Validation](https://www.w3schools.com/php/php_form_validation.asp)

### Development Tools
- [VS Code PHP Extensions](https://code.visualstudio.com/docs/languages/php)
- [XAMPP](https://www.apachefriends.org/) - Local development environment
- [PHP Debug Tools](https://xdebug.org/) - For advanced debugging

## Assessment Rubric

| Criteria | Excellent (A) | Good (B) | Satisfactory (C) | Needs Work (D) | Incomplete (F) |
|----------|---------------|----------|------------------|----------------|----------------|
| **Code Quality** | Clean, well-commented, follows best practices | Mostly clean with minor issues | Functional but could be improved | Some code quality issues | Poor code structure |
| **Functionality** | All features working perfectly | Minor bugs or missing features | Core functionality works | Several features broken | Major functionality missing |
| **Error Handling** | Comprehensive error handling | Good error handling | Basic error handling | Limited error handling | No error handling |
| **Security** | Proper input validation and output escaping | Most security measures implemented | Basic security measures | Some security concerns | Security vulnerabilities |
| **Testing** | All tests pass | Most tests pass | Basic tests pass | Some tests fail | Many tests fail |


## Contributing

This is an educational project. Students should:

1. **Work individually** on their implementation
2. **Ask questions** when stuck, but implement solutions themselves  
3. **Test thoroughly** using the provided test runner
4. **Follow coding standards** and best practices
5. **Document their code** with clear comments


## License

This project is created for educational purposes.

---

## Final Notes

This project is designed to be **challenging but achievable**. Don't expect to complete everything perfectly on the first try - learning happens through iteration and problem-solving.

**Remember**: 
- Start with Task 1 tasks and build progressively
- Use the test runner frequently to check your progress
- Focus on understanding concepts, not just making tests pass
- Ask questions when you're stuck - that's how learning happens!


---

*Asia-pacific International University*