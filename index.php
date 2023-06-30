<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
</head>
<body>
    <h1 style="text-align: center;margin-bottom: 60px;">Product Management</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
    
    <label style="display: block;" for="name" class="form-label" >Name:</label>
    <input type="text" id="name" class="form-control" name="name"><br><br>
    
    <label style="display: block;" class="form-label" for="description" >Description</label>
    <textarea name="description" ></textarea><br><br>

    <label style="display: block;" for="price">Price:</label>
    <input type="text" name="price"><br><br>

    <label style="display: block;" for="image">Image:</label>
    <input type="file" name="image" id=""><br><br>

    <input type="submit" value="Add Product"><br><br>
    </form>

    <h2 style="text-align: center;margin-bottom: 60px;">Product List</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
        </tr>
        <?php 
        //Connect to MySQL database

        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "products";

        $conn = new mysqli($server, $username, $password, $dbname);

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }


        //Fetch and display products from the database

        $sql = "SELECT * FROM products";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>'. $row['name'] .'</td>';
                 echo '<td>'. $row['description'] .'</td>';
                  echo '<td>'. $row['price'] .'</td>';
                   echo '<td> <img style="width:100px" src="images/'. $row['image'] .'"></td>';
                echo '<tr>';
            }
        }else{
            echo '<tr> <td colspan="4">No products found</td></tr>';
        }

        $conn->close();
        
        ?>
    </table>

    <h2>Export Products</h2>

    <form action="export_products.php" method="post" style="margin-bottom: 60px">
        <select name="format" id="">
            <option value="json">JSON</option>
            <option value="excel">Excel</option>
            <option value="csv">CSV</option>
        </select>
       <input type="submit" value="Export">

    </form>
<h2>Import Products</h2>

<form action="import_products.php" method="post" enctype="multipart/form-data" >
    <label for="import_file">Select file:</label>
    <input type="file" id="import_file" name="import_file" >

    <select name="format" id="">
        <option value="json">JSON</option>
        <option value="excel">Excel</option>
        <option value="csv">CSV</option>
    </select>
    <input type="submit" value="Import">
</form>

</body>
</html>