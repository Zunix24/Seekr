<!DOCTYPE html>
<html>
  <head>
    <title>Search Files</title>
    <style type="text/css">
        body {
            @import url('https://fonts.cdnfonts.com/css/nexa-bold');
            font-family: Nexa, sans-serif;
            background-color: #f2f2f2;
            padding: 100px;
        }
        h1 {
            text-align: center;
            padding-top:0px;
        }
        form {
            margin: 20px auto;
            max-width: 550px;
        }
        label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        input[type="text"] {
            padding: 12px;
            padding-left: 38px;
            border: 1px solid #ccc;
            border-radius: 20px 0px 0px 20px;
            width: 350px;
            margin-bottom: 10px;
            margin-left: 25px;
            position: relative;
            background-image: url('https://cdn1.iconfinder.com/data/icons/jumpicon-basic-ui-glyph-1/32/-_Magnifier-Search-Zoom--512.png');
            background-repeat: no-repeat;
            background-position: 10px center;
            background-size: 20px 20px
        }
        select {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 0px 20px 20px 0px;
            margin-left: -5px;
            background-position: 10px center;
        }
        input[type="submit"] {
            background-color: #7B18DD;
            color: #fff;
            padding: 10px 100px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #6014AD;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #7B18DD;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .logo {
        display: inline-block;
        width:400px;
        height: 111.11px;
        user-select:none;
        user-drag: none;
        -webkit-user-drag: none;
        -webkit-touch-callout: none;
        pointer-events: none;
        padding-bottom:20px;
        }
    </style>
  </head>
  <body>
    <h1>
        <img src="https://e.hypermatic.com/151fa7b53799c412697d59622a60a126.png" class="logo">
    </h1>
    <form action="" method="get">

      <input type="text" name="search" id="search" placeholder="Search files" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
      <select name="criteria">
        <option value="title"<?php if (isset($_GET['criteria']) && $_GET['criteria'] == 'title') { echo ' selected'; } ?>>Title</option>
        <option value="keywords"<?php if (isset($_GET['criteria']) && $_GET['criteria'] == 'keywords') { echo ' selected'; } ?>>Keywords</option>
        <!--<option value="id"<?php if (isset($_GET['criteria']) && $_GET['criteria'] == 'id') { echo ' selected'; } ?>>ID</option>-->
      </select>
      <input type="submit" name="submit" value="Search">
    </form>
    <?php
  // Check if form has been submitted
  if(isset($_GET['submit'])) {

    // Database credentials
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "proj";

    // Connect to database
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Get search term and criteria
    $search_term = $_GET["search"];
    $criteria = $_GET["criteria"];

    // Set the SQL query based on the search term
    if (empty($search_term)) {
        echo "<p>Please enter a search term.</p>";
        $sql = "";
    } else if ($search_term == "*") {
        $sql = "SELECT * FROM files";
    } else {
        switch ($criteria) {
          case "title":
            $sql = "SELECT * FROM files WHERE title LIKE '%$search_term%'";
            break;
          case "keywords":
            $sql = "SELECT * FROM files WHERE keywords LIKE '%$search_term%'";
            break;
          /*case "id":
            $sql = "SELECT * FROM files WHERE id = $search_term";
            break;
          */
          default:
            echo "<p>Please select a valid search criteria.</p>";
            $sql = "";
        }
    }

    // Execute SQL query
    if (!empty($sql)) {
        $result = mysqli_query($conn, $sql);

        // Display results
        if (mysqli_num_rows($result) > 0) {
          echo "<h2>Search Results:</h2>";
          echo "<table>";
          echo "<tr><th>ID</th><th>Path</th><th>Title</th><th>Size</th><th>Format</th><th>Keyword</th></tr>";
          // Loop through results and output them in a table
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["path"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["size"] . "</td>";
            echo "<td>" . $row["format"] . "</td>";
            echo "<td>" . $row["keywords"] . "</td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo "<p>No results found.</p>";
        }
    }

    // Close database connection
    mysqli_close($conn);
  }
?>


</html>