<?php

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h4>Registration with credential</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form method="post" action="/registration">
                <div class="mb-3">
                    <label  class="form-label">First Name:</label>
                    <input type="text" class="form-control <?php echo $request->error('first_name')?'is-invalid':'' ?>" name="first_name" value="<?php echo $request->old('first_name') ?>" required>
                    <?php
                    if($request->error('first_name')){
                        ?>
                        <span class="invalid feedback" role="alert">
                            <strong><?php echo $request->errors['first_name'] ?></strong>
                        </span>
                        <?php
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label  class="form-label">Last Name:</label>
                    <input type="text" class="form-control <?php echo $request->error('last_name')?'is-invalid':'' ?>" name="last_name" value="<?php echo $request->old('last_name') ?>" required>
                    <?php
                    if($request->error('last_name')){
                        ?>
                        <span class="invalid feedback" role="alert">
                            <strong><?php echo $request->errors['last_name'] ?></strong>
                        </span>
                        <?php
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control <?php echo $request->error('email')?'is-invalid':'' ?>" name="email" value="<?php echo $request->old('email') ?>" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <?php
                    if($request->error('email')){
                        ?>
                        <span class="invalid feedback" role="alert">
                                <strong><?php echo $request->errors['email'] ?></strong>
                            </span>
                        <?php
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control <?php echo $request->error('password')?'is-invalid':'' ?> " name="password" id="exampleInputPassword1">
                    <?php
                    if($request->error('password')){
                        ?>
                        <span class="invalid feedback" role="alert">
                                <strong><?php echo $request->errors['password'] ?></strong>
                            </span>
                        <?php
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="cexampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control <?php echo $request->error('c_password')?'is-invalid':'' ?> " name="c_password" id="cexampleInputPassword1">
                    <?php
                    if($request->error('c_password')){
                        ?>
                        <span class="invalid feedback" role="alert">
                                <strong><?php echo $request->errors['c_password'] ?></strong>
                            </span>
                        <?php
                    }
                    ?>
                </div>
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="exampleCheck1"><a href="/login">You have already account ?</a></label>
                </div>
                <button type="submit" class="btn form-control btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>