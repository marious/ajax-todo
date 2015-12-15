<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Please Signin</h3>
            </div>
            <div class="panel-body">
                <div id="login-form-errors"><!-- dynamic --></div>

                <?= form_open('api/login', ['id' => 'login-form']); ?>
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter your login name" name="login" value="<?= set_value('login', ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                        <?= anchor('home/register', 'Register', ['class' => 'btn btn-default']); ?>
                    </fieldset>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('#login-form-errors').hide();

    $(function() {
       $('#login-form').on('submit', function(e) {
           e.preventDefault();

           var $this = $(this);
           var url = $this.attr('action');
           var postData = $this.serialize();
           var output = '';

           $.post(url, postData, function(o) {
               if (o.result == 1) {
                   window.location = "<?= site_url('dashboard'); ?>";
               }
               else if(o.error) {

                   for (var key in o.error) {
                       var value = o.error[key];
                       output += '<div class="alert alert-danger">';
                       output += '<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                       output += value;
                       output += '</div>';
                   }

                   $('#login-form-errors').show().html(output);
               }
               else  {
                   output += '<div class="alert alert-danger">';
                   output += '<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                   output += 'Invalid Login name or password';
                   output += '</div>';
                   $('#login-form-errors').show().html(output);
               }

           }, 'json');
       });
    });
</script>