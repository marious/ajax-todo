<div class="container">
    <div id="error" class="alert alert-danger hide"><!-- Dynamic --></div>
    <div id="success" class="alert alert-success hide"><!-- Dynamic --></div>

    <div class="row main-area">
        <div class="col-md-5 box">
            <div id="dashboard-side">
                <?= form_open('api/create_todo', ['id' => 'create-todo']); ?>
                    <div class="form-group">
                        <input type="text" name="content" class="form-control" id="" placeholder="Create Todo Item">
                    </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <?= form_close(); ?>

                <!-- Dynamic -->
                <div id="list-todo"></div>

            </div><!-- ./dashboard-side -->
        </div>
        <div class="col-md-7 box">
            <div id="dashboard-main">
                <?= form_open('api/create_note', ['id' => 'create-note']); ?>
                <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="content" id="" placeholder="Enter Note"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <?= form_close(); ?>

                <!-- Dynamic -->
                <div id="list-note"></div>
            </div><!-- ./dashboard-main -->
        </div>
    </div><!-- ./row -->
</div><!-- ./container -->