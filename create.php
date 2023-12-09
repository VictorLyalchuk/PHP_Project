<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/_header.php";
    $photo = "images/noPhoto.jpg";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";
    $name = $_POST["name"];
    $description = $_POST["description"];

    if (isset($_FILES["image"])) {
//        $filename = $_FILES["image"]["name"];
//        $filename = str_replace(' ', '_', $filename);
//        $filepath = "images/" . $filename;
        $filename = uniqid().".".pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $filepath = $_SERVER["DOCUMENT_ROOT"]."/images/".$filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
            $sql = "INSERT INTO categories (name, image, description) VALUES (?, ? , ?)";
            $stmt = $pdo->prepare($sql);
            $photo = $filepath;
            $stmt->execute([$name, $filename, $description]);
            header("Location: /");
            exit;
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

    ?>

    <h1 class="text-center">Add category</h1>

    <form class="col-md-6 offset-md-3 was-validated" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control <?php echo (!empty($nameError)) ? 'is-invalid' : ''; ?>" name="name"
                   id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="image" class="form-label" style="cursor: pointer;">
                    <img src="<?php echo $photo; ?>" alt="Selected photo" height="100">
                    <input class="form-control" type="file" id="imageUpload" name="image" accept="image/*"
                           style="display: none;">
                </label>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="image" class="form-label">Choose photo</label>
                    <input class="form-control" type="file"
                           id="image" name="image" accept="image/*" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>

                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add</button>
        <a href="/" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>