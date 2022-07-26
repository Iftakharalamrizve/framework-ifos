<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <table class="table table-dark">
                    
                <tbody>
                    <tr>
                        <th scope="col">First Name</th>
                        <td scope="col"><?php echo $user->first_name ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Last Name</th>
                        <td scope="col"> <?php echo $user->last_name ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Email</th>
                        <td scope="col"><?php echo $user->email ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Password</th>
                        <td scope="col"><?php echo $user->password ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>