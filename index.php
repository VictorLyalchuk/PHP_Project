<?php
include $_SERVER['DOCUMENT_ROOT'] . "/_header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";
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
</head>
<body>
<div class="container">
    <h1 class="text-center">Products</h1>
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
        foreach ($results as $row) {
            ?>
            <tr>
                <th scope="row"><?php echo $row["id"] ?></th>
                <td>
                    <img src="/images/<?php echo $row["image"]; ?>" height="75" alt="Photo">
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
                    <a href="/" class="btn btn-danger" data-delete="<?php echo $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="modal" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnDeleteConfirm" name="delete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('modalDelete'));
    let id = 0;
    const list = document.querySelectorAll('[data-delete]');
    const elementsArray = Array.from(list);
    elementsArray.forEach(item => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            id = e.target.dataset.delete;
            myModal.show();

            //axios.post("");
            //console.log("delete item", id);
            //e.target.closest("tr").remove();
        });
    });
    document.getElementById("btnDeleteConfirm").addEventListener("click", async () => {
        try {
            const response = await axios.delete(`/delete-product.php?id=${id}`);

            if (response.status === 200) {
                var item = document.querySelector('[data-delete="'+id+'"]');
                item.closest("tr").remove();
            } else {
                console.error("Failed to delete item");
            }
        } catch (error) {
            console.error("Error:", error);
        }
        finally {
            myModal.hide();
        }
    });
</script>
</body>
</html>
