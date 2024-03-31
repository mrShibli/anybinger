<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./style2.css"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>search page</title>
</head>
<body>

    <div class="container">
       <!--
                            <form action="" method="GET" class="search-form">  
                            <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                            <label for="search-box" class="fas fa-search"></label>
                             </form>
                                
                                   
                                </form>
-->
        

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Book Name</th>       
                                    <th>bookpic</th>
                                    <th>bookprice</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    
                                    $con = mysqli_connect("localhost","root","","library_managment");

                                    if(isset($_GET['search']))
                                    {
                                        $filtervalues = $_GET['search'];
                                        $query = "SELECT * FROM book WHERE CONCAT(id,bookname,bookpic,bookprice) LIKE '%$filtervalues%' ";                                     
                                          $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $row)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $row['id']; ?></td>
                                                    <td><?= $row['bookname']; ?></td>
                                                    <td> 
                                                    <img src="../uploads/<?php echo $row['bookpic'];?>" alt="Image" width="100px"> </td>
                                             
                                                    <td><?= $row['bookprice']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td colspan="4">No Record Found</td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>