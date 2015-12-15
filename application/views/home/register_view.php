<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create Account</h3>
            </div>
            <div class="panel-body">
                <?= form_open('api/register', ['id' => 'register-form']); ?>

                <div id="register-form-errors"><!-- dynamic --></div>

                <fieldset>
                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input type="text" id="login" class="form-control" placeholder="Enter your login name" name="login" value="<?= set_value('login', ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter your Email Address" name="email" value="<?= set_value('email', ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm_password" placeholder="type password again" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                    <?= anchor('./', 'Cancel', ['class' => 'btn btn-default']); ?>

                </fieldset>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#register-form-errors').hide();

        $('#register-form').on('submit', function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('action');
            var postData = $this.serialize();
            $.post(url, postData, function(o) {
                if (o.result == 1) {
                    window.location = "<?= site_url('dashboard'); ?>";
                }
                else if (o.error) {
                    var output = '';
                    for (var key in o.error) {
                        var value = o.error[key];
                        output += '<div class="alert alert-danger">';
                        output += '<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                        output += value;
                        output += '</div>';
                    }
                    $('#register-form-errors').show().html(output);
                }
            }, 'json');
        });
    });
</script>