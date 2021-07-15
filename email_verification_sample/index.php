<?php include("header.php"); ?>

<div class="container mt-5">

    <?php if (isset($_SESSION['alert_type']) and isset($_SESSION['message'])) : ?>

        <div class="alert <?= $_SESSION['alert_type'] ?>" role="alert">
            <?= $_SESSION['message']; ?>
        </div>

    <?php endif; ?>

    <form action="" method="POST">

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>

        <button type="submit" name="register" class="btn btn-primary">Submit</button>

    </form>

</div>

<?php include("footer.php"); ?>