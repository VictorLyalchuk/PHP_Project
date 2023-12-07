<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";

    $id = $_POST["id"];

    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: /");
    exit;
}
?>

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
    <script>
        function deleteConfirmation(id) {
            var confirmed = confirm("Are you sure you want to delete this category?");
            if (confirmed) {
                document.getElementById("deleteForm" + id).submit();
            }
        }
    </script>
</head>
<body>
<div class="container">
    <?php include ("_header.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";
    ?>


    <h1 class ="text-center">Caterogies</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Photo</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT id, name, image, description FROM categories";
        $stmt = $pdo->query($sql);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {

        ?>
        <tr>
            <th scope="row"><?php echo $row["id"] ?></th>
            <td>
                <img src = "<?php echo $row["image"] ?>" height ="75" alt="Photo">
            </td>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["description"] ?></td>
            <td>
                <a href="/info.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-info">View</a>
            </td>
            <td>
                <a href="/edit.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-info">Edit</a>
            </td>
            <td>
                <form method="post" >
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
