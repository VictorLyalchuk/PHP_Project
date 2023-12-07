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


    <h1 class="text-center">Info product</h1>

    <form class="col-md-6 offset-md-3" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="number" class="form-control" name="id"
                   id="id" value="<?php echo $id ?>" hidden>
        </div>

                <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name"
                   id="name" value="<?php echo $name ?>" readonly >
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"
                      readonly ><?php echo $description; ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="image" class="form-label" style="cursor: pointer;">
                    <img src="<?php echo $image; ?>" alt="Selected photo" height="500">
                    <input class="form-control" id="image" name="image" accept="image/*"
                           style="display: none;" readonly >
                </label>
            </div>
        </div>
    </form>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>