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
    <title>Users List</title>
</head>
<body>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Sr No.</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Image</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $cnt=0; foreach($users as $user){ ?>
    <tr>
      <th scope="row"><?php echo ++$cnt; ?></th>
      <td><?php echo $user["name"];?></td>
      <td><?php echo $user["email"];?></td>
      <td><?php echo $user["password"];?></td>
      <td><img src="<?php echo base_url().'uploads/'.$user["img"]?>"></td>
      <td><a class="p-3" href="<?php echo base_url().'index.php/UserController/UpdateUser/'.$user['id'];?>">Edit</a><a class="p-3"  href="<?php echo base_url().'index.php/UserController/DeleteById/'.$user['id'];?>">Delete</a></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</body>
</html>