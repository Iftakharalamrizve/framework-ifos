
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h4>Login with credential</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form method="post" action="/login">
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
                <label class="form-check-label mb-3" for="form2Example3">
                    <a href="/registration"> Create a new  account ?</a>
                </label>
                <button type="submit" class="btn form-control btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>