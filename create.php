<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";
    $name = $_POST["name"];
    $description = $_POST["description"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $filename = $_FILES["image"]["name"];
        $filename = str_replace(' ', '_', $filename);
        $filepath = "images/" . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
            $sql = "INSERT INTO categories (name, image, description) VALUES (?, ? , ?)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([$name, $filepath, $description]);
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
    include $_SERVER['DOCUMENT_ROOT'] . "/_header.php";
    $photo = "images/noPhoto.jpg";
    ?>

    <?php
    $filepath = "";
    $filename = "";
    $nameError = "";
    $imageError = "";
    $Message1 = "";
    $Message2 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        if (empty($_POST["name"])) {
            $nameError = "Please enter a name.";
        } else {
            $Message1 = "Name is valid!";
        }

        if (empty($_FILES["image"]["name"])) {
            $imageError = "Please select an image.";
        } else {
            $filename = $_FILES["image"]["name"];
            $filename = str_replace(' ', '_', $filename);
            $filepath = "images/" . $filename;
            $photo = $filepath;
            $Message2 = "Image uploaded successfully!";
        }
    }
    ?>

    <h1 class="text-center">Add category</h1>

    <form class="col-md-6 offset-md-3" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control <?php echo (!empty($nameError)) ? 'is-invalid' : ''; ?>" name="name"
                   id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
            <div class="invalid-feedback">
                <?php echo (!empty($nameError)) ? $nameError : ''; ?>
            </div>
            <div class="valid-feedback">
                <?php echo $Message1; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
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
                    <input class="form-control <?php echo (!empty($imageError)) ? 'is-invalid' : ''; ?>" type="file"
                           id="image" name="image" accept="image/*">
                    <div class="invalid-feedback">
                        <?php echo $imageError; ?>
                    </div>
                    <div class="valid-feedback">
                        <?php echo $Message2; ?>
                    </div>
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