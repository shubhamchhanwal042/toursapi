<?php echo $this->session->userdata("Userdata");
echo $this->session->flashdata("Flashdata");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
    <title>Update User</title>
   
</head>
<body>
<form action="<?php echo base_url().'index.php/UserController/UpdateUserPost/'.$user['id']?>" method="post" enctype="multipart/form-data" class="w-75 mx-auto">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo $user["name"];?>"  id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="text" class="form-control" name="email" value="<?php echo $user["email"];?>"  id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="text" name="password" class="form-control" value="<?php echo $user["password"];?>"  id="exampleInputPassword1">
  </div>
  <!-- <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="file" name="img" class="form-control" id="exampleInputPassword1">
  </div> -->
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
