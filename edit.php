<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";

if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $name = '';
    $image = '';
    $description = '';

    if (!empty($id)) {
        $sql = "SELECT name, image, description FROM categories WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $name = $result['name'];
            $image = $result['image'];
            $description = $result['description'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
</head>
<body>
<div class="container py-3">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/_header.php";
    ?>

    <?php
    $filepath = "";
    $filename = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $imageTXT = $_POST["imagetxt"];

        if (!empty($_FILES["newImage"]["name"])) {
            $filename = $_FILES["newImage"]["name"];
            $filename = str_replace(' ', '_', $filename);
            $filepath = "images/" . $filename;
            move_uploaded_file($_FILES["newImage"]["tmp_name"], $filepath);
        }
        else {
            if (!empty($_FILES["image"]["name"])) {
                $filename = $_FILES["image"]["name"];
                $filename = str_replace(' ', '_', $filename);
                $filepath = "images/" . $filename;
                move_uploaded_file($_FILES["image"]["tmp_name"], $filepath);
            } else {
                $filepath = $imageTXT;
            }
        }
        $sql = "UPDATE categories SET name = :name, image = :image, description = :description WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'image' => $filepath, 'description' => $description, 'id' => $id]);
        header("Location: /");
        exit;
    }
    ?>

    <h1 class="text-center">Edit product</h1>

    <form class="col-md-6 offset-md-3 was-validated" enctype="multipart/form-data" method="post" action="edit.php">
        <div class="mb-3">
            <input type="number" class="form-control" name="id"
                   id="id" value="<?php echo $id ?>" hidden>
        </div>

                <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name"
                   id="name" value="<?php echo $name ?>" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"
                      required><?php echo $description; ?></textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="image" class="form-label" style="cursor: pointer;">
                    <img src="<?php echo $image; ?>" alt="Selected photo" height="100">
                    <input class="form-control" type="file" id="image" name="image" accept="image/*"
                           style="display: none;">
                </label>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="newImage" class="form-label">Choose photo</label>
                    <input class="form-control" type="file"
                           id="newImage" name="newImage" accept="image/*">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="imagetxt"
                   id="imagetxt" value="<?php echo $image ?>" hidden>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>