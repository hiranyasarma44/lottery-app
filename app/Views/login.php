<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lottery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="row justify-content-md-center">

      <div class="col-6">
        <h1>Sign In</h1>
        <?php if (session()->getFlashdata('msg')) : ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>
        <form action="/login/auth" method="post">
          <div class="mb-3">
            <label for="InputForEmail" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
          </div>
          <div class="mb-3">
            <label for="InputForPassword" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="InputForPassword">
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>

    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>

</html>