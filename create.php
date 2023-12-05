<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
        if (empty($_POST["name"])) {
            $nameError = "Please enter a name.";
        }
        if (empty($_FILES["image"]["name"])) {
            $imageError = "Please select an image.";
        }
        $filename = $_FILES["image"]["name"];
        $filename = str_replace(' ', '_', $filename);
        $filepath = "images/" . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
            $photo = $filepath;
        }

    }
    ?>

    <h1 class="text-center">Add category</h1>

    <form class="col-md-6 offset-md-3" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control <?php if (!empty($nameError)) echo 'is-invalid'; ?>" name="name"
                   id="name">
            <div class="invalid-feedback">
                <?php echo $nameError; ?>
            </div>
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
                    <input class="form-control <?php if (!empty($imageError)) echo 'is-invalid'; ?>" type="file"
                           id="image" name="image" accept="image/*" >
                    <div class="invalid-feedback">
                        <?php
                        echo $imageError;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Add</button>
    </form>
</div>


<script src="/js/bootstrap.bundle.min.js"></script>

</body>
</html>
