<?php
session_start();
include('header.php');

// Connection to the server
$connect = mysqli_connect("localhost", "root", "", "anthea");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// Check if the admin is logged in
$is_admin_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Initialize variables for both handbags and accessories
$h_id = $h_name = $h_price = $h_material = $h_description = $h_image_path = '';
$a_id = $a_name = $a_price = $a_material = $a_description = $a_image_path = '';
$edit_state = false;

// Handle edit requests for handbags
if (isset($_GET['edit_handbag'])) {
    $h_id = mysqli_real_escape_string($connect, $_GET['edit_handbag']);
    $record = mysqli_query($connect, "SELECT * FROM products WHERE id=$h_id");

    if ($record && mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $h_id = $n['id'];
        $h_name = $n['name'];
        $h_price = $n['price'];
        $h_material = $n['material'];
        $h_description = $n['description'];
        $h_image_path = $n['image_path'];
        $edit_state = true;
    }
}

// Handle edit requests for accessories
if (isset($_GET['edit_accessory'])) {
    $a_id = mysqli_real_escape_string($connect, $_GET['edit_accessory']);
    $record = mysqli_query($connect, "SELECT * FROM jewelry WHERE id=$a_id");

    if ($record && mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $a_id = $n['id'];
        $a_name = $n['name'];
        $a_price = $n['price'];
        $a_material = $n['material'];
        $a_description = $n['description'];
        $a_image_path = $n['image_path'];
        $edit_state = true;
    }
}

// Add or update handbag record
if (isset($_POST['save_handbag'])) {
    $h_name = mysqli_real_escape_string($connect, $_POST['h_name']);
    $h_price = mysqli_real_escape_string($connect, $_POST['h_price']);
    $h_material = mysqli_real_escape_string($connect, $_POST['h_material']);
    $h_description = mysqli_real_escape_string($connect, $_POST['h_description']);
    $h_image_path = mysqli_real_escape_string($connect, $_POST['h_image_path']);

    if ($_POST['h_id']) {
        $h_id = mysqli_real_escape_string($connect, $_POST['h_id']);
        mysqli_query($connect, "UPDATE products SET name='$h_name', price='$h_price', material='$h_material', description='$h_description', image_path='$h_image_path' WHERE id=$h_id");
        $_SESSION['message'] = "Handbag updated!";
        header('location: admin_dashboard.php');
        exit();
    } else {
        mysqli_query($connect, "INSERT INTO products (name, price, material, description, image_path) VALUES ('$h_name', '$h_price', '$h_material', '$h_description', '$h_image_path')");
        $_SESSION['message'] = "Handbag added!";
        header('location: admin_dashboard.php');
        exit();
    }
}

// Add or update accessory record
if (isset($_POST['save_accessory'])) {
    $a_name = mysqli_real_escape_string($connect, $_POST['a_name']);
    $a_price = mysqli_real_escape_string($connect, $_POST['a_price']);
    $a_material = mysqli_real_escape_string($connect, $_POST['a_material']);
    $a_description = mysqli_real_escape_string($connect, $_POST['a_description']);
    $a_image_path = mysqli_real_escape_string($connect, $_POST['a_image_path']);

    if ($_POST['a_id']) {
        $a_id = mysqli_real_escape_string($connect, $_POST['a_id']);
        mysqli_query($connect, "UPDATE jewelry SET name='$a_name', price='$a_price', material='$a_material', description='$a_description', image_path='$a_image_path' WHERE id=$a_id");
        $_SESSION['message'] = "Accessory updated!";
        header('location: admin_dashboard.php');
        exit();
    } else {
        mysqli_query($connect, "INSERT INTO jewelry (name, price, material, description, image_path) VALUES ('$a_name', '$a_price', '$a_material', '$a_description', '$a_image_path')");
        $_SESSION['message'] = "Accessory added!";
        header('location: admin_dashboard.php');
        exit();
    }
}

// Delete record (both handbags and accessories)
if (isset($_GET['delete_handbag'])) {
    $h_id = mysqli_real_escape_string($connect, $_GET['delete_handbag']);
    mysqli_query($connect, "DELETE FROM products WHERE id=$h_id");
    $_SESSION['message'] = "Handbag deleted!";
    header('location: admin_dashboard.php');
    exit();
}

if (isset($_GET['delete_accessory'])) {
    $a_id = mysqli_real_escape_string($connect, $_GET['delete_accessory']);
    mysqli_query($connect, "DELETE FROM jewelry WHERE id=$a_id");
    $_SESSION['message'] = "Accessory deleted!";
    header('location: admin_dashboard.php');
    exit();
}

// Get all records for handbags and accessories
$handbag_results = mysqli_query($connect, "SELECT * FROM products");
$accessory_results = mysqli_query($connect, "SELECT * FROM jewelry");

// Search functionality (for handbags and accessories)
if (isset($_POST['search_handbag'])) {
    $search = mysqli_real_escape_string($connect, $_POST['search_handbag_query']);
    $handbag_results = mysqli_query($connect, "SELECT * FROM products WHERE name LIKE '%$search%'");
}

if (isset($_POST['search_accessory'])) {
    $search = mysqli_real_escape_string($connect, $_POST['search_accessory_query']);
    $accessory_results = mysqli_query($connect, "SELECT * FROM jewelry WHERE name LIKE '%$search%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Handbags & Accessories</title>
    <style>
        /* Add the styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2ece1;
            color: #5d4037;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .admin-actions {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 30px auto;
        }

        h3 {
            color: #8d6e63;
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        input, textarea {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #b0a099;
            border-radius: 5px;
        }

        button {
            padding: 12px;
            background-color: #8d6e63;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6d4c41;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #8d6e63;
            color: white;
        }

        td img {
            width: 50px;
        }

        .btn {
            padding: 5px 10px;
            background-color: #8d6e63;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #6d4c41;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>

    <div class="admin-actions">
        <h3>Handbag Management</h3>
        <form method="POST">
            <input type="hidden" name="h_id" value="<?php echo $h_id; ?>" />
            <label>Handbag Name</label>
            <input type="text" name="h_name" value="<?php echo $h_name; ?>" required />

            <label>Handbag Price</label>
            <input type="text" name="h_price" value="<?php echo $h_price; ?>" required />

            <label>Material</label>
            <input type="text" name="h_material" value="<?php echo $h_material; ?>" required />

            <label>Description</label>
            <textarea name="h_description" required><?php echo $h_description; ?></textarea>

            <label>Image Path</label>
            <input type="text" name="h_image_path" value="<?php echo $h_image_path; ?>" required />

            <button type="submit" name="save_handbag"><?php echo $edit_state ? 'Update Handbag' : 'Add Handbag'; ?></button>
        </form>

        <h3>Accessory Management</h3>
        <form method="POST">
            <input type="hidden" name="a_id" value="<?php echo $a_id; ?>" />
            <label>Accessory Name</label>
            <input type="text" name="a_name" value="<?php echo $a_name; ?>" required />

            <label>Accessory Price</label>
            <input type="text" name="a_price" value="<?php echo $a_price; ?>" required />

            <label>Material</label>
            <input type="text" name="a_material" value="<?php echo $a_material; ?>" required />

            <label>Description</label>
            <textarea name="a_description" required><?php echo $a_description; ?></textarea>

            <label>Image Path</label>
            <input type="text" name="a_image_path" value="<?php echo $a_image_path; ?>" required />

            <button type="submit" name="save_accessory"><?php echo $edit_state ? 'Update Accessory' : 'Add Accessory'; ?></button>
        </form>

        <div class="search-bar">
            <form method="POST">
                <input type="text" name="search_handbag_query" placeholder="Search Handbags">
                <button type="submit" name="search_handbag">Search</button>
            </form>
            <form method="POST">
                <input type="text" name="search_accessory_query" placeholder="Search Accessories">
                <button type="submit" name="search_accessory">Search</button>
            </form>
        </div>

        <!-- Handbag List -->
        <h3>Handbags</h3>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Material</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while ($handbag = mysqli_fetch_array($handbag_results)): ?>
                <tr>
                    <td><img src="<?php echo $handbag['image_path']; ?>" alt="Handbag Image"></td>
                    <td><?php echo $handbag['name']; ?></td>
                    <td><?php echo $handbag['price']; ?></td>
                    <td><?php echo $handbag['material']; ?></td>
                    <td><?php echo $handbag['description']; ?></td>
                    <td>
                        <a href="admin_dashboard.php?edit_handbag=<?php echo $handbag['id']; ?>" class="btn">Edit</a>
                        <a href="admin_dashboard.php?delete_handbag=<?php echo $handbag['id']; ?>" class="btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Accessory List -->
        <h3>Accessories</h3>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Material</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while ($accessory = mysqli_fetch_array($accessory_results)): ?>
                <tr>
                    <td><img src="<?php echo $accessory['image_path']; ?>" alt="Accessory Image"></td>
                    <td><?php echo $accessory['name']; ?></td>
                    <td><?php echo $accessory['price']; ?></td>
                    <td><?php echo $accessory['material']; ?></td>
                    <td><?php echo $accessory['description']; ?></td>
                    <td>
                        <a href="admin_dashboard.php?edit_accessory=<?php echo $accessory['id']; ?>" class="btn">Edit</a>
                        <a href="admin_dashboard.php?delete_accessory=<?php echo $accessory['id']; ?>" class="btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
