<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: userpage.php
 * Desc: Page only visible when logged in as user. Allows uploading of images
 * and creation of categories.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once("util.php");

$title = 'DT161G - Projekt - User';
$author = 'Viktor Zetterström';
$authorEmail = 'vize1500@student.miun.se';

// Check what kind of user is logged in.
session_start();
$userLoggedIn = isset($_SESSION['userLoggedIn']);
$adminLoggedIn = isset($_SESSION['adminLoggedIn']);

// Get username.
$userName = "No user is set!";
if ($userLoggedIn) {
    $userName = $_SESSION['userLoggedIn'];
}

// Get categories associated with user.
$categories = DbHandler::Instance()->getCategoriesForUser($userName);
$categoryCount = count($categories);

// If user is not logged in, redirect to index.php
if (!$userLoggedIn) {
  header("location:index.php");
}

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" href="css/style.css"/>
  <script src="js/main.js"></script>
</head>
<body>

<!-- header with log in form -->
<header>
  <!-- Title and navigational links -->
  <div id="navigation">
    <h1><?php echo $title ?></h1>
    <div class="links">
      <a href="index.php">Start</a>
      <?PHP if ($userLoggedIn) echo '<a href="images.php">Images</a>' ?>
      <?PHP if ($userLoggedIn) echo '<a href="userpage.php">User</a>' ?>
      <?PHP if ($adminLoggedIn) echo '<a href="admin.php">Admin</a>' ?>
    </div>
  </div>

  <!-- login and logout forms -->
  <div class="login">
    <div id="login" <?php if ($userLoggedIn) echo 'style="display:none"' ?>>
      <form id="loginForm" action="login.php" method="POST">
        <input type="text" placeholder="Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
        <input type="password" placeholder="Password" name="psw" id="psw" required>
        <input type="submit" id="loginButton" value="Log in">
      </form>
    </div>
    <div id="logout" <?php if (!$userLoggedIn) echo 'style="display:none"' ?>>
      <form id="logoutForm" action="logout.php" method="POST">
        <label for="logoutButton">Logged in as: <?PHP echo $userName ?></label>
        <input type="submit" id="logoutButton" value="Log out">
      </form>
    </div>
  </div>
</header>

<!-- main content -->
<main>
  <!-- navigation sidebar -->
  <aside>
    <h2>Navigation</h2>
    <nav>
      <ul>
        <li>
          <a>Uno</a>
        </li>
        <li>
          <a>Dos</a>
        </li>
        <li>
          <a>Tres</a>
        </li>
        <li>
          <a>Quattro</a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- area for showing pictures -->
  <section>
    <h2>User page</h2>

    <!-- Form for creating image categories -->
    <div id="createCategory">
      <form id="createCategoryForm" action="createcategory.php" method="POST">
        <h3>Create category</h3>
        <input type="text" placeholder="Category name" name="cname" id="cname" required maxlength="10" autocomplete="off" required>
        <input type="submit" id="createCategoryButton" value="Create category">
      </form>
    </div>

    <!-- Only show upload and deletion if categories exist -->
    <!-- Form for uploading image -->
    <div id="uploadImage" <?php if ($categoryCount == 0) echo 'style="display:none"' ?>>
      <form id="uploadForm" action="addimage.php" method="POST" enctype="multipart/form-data">
        <h3>Upload image</h3>
        <input type="file" id="aimage" name="aimage" required>

        <select id="chooseImageCategorySelect" name="cname" required>
          <option value="">Choose image category</option>
          <?PHP
            foreach ($categories as $category) {
              echo "<option value=$category>$category</option>";
            }
          ?>
        </select>

        <input type="submit" id="uploadButton" value="Upload">
      </form>
    </div>

    <!-- Form for deleting image categories -->
    <div id="deleteCategory" <?php if ($categoryCount == 0) echo 'style="display:none"' ?>>
      <form id="deleteCategoryForm" action="deletecategory.php" method="POST">
        <h3>Delete category</h3>

        <select id="deleteCategorySelect" name="cname" required>
          <option value="">Choose image category</option>
          <?PHP
            foreach ($categories as $category) {
              echo "<option value=$category>$category</option>";
            }
          ?>
        </select>

        <input type="submit" id="deleteCategoryButton" value="Delete category">
      </form>
    </div>
  </section>
</main>

<!-- footer -->
<footer>
  Made by: <?PHP echo $author ?>,
  <a href="mailto:<?PHP echo $authorEmail ?>">Contact</a>
</footer>

</body>
</html>
