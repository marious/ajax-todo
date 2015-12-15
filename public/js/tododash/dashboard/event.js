var Event = function()
{
    //========================================================================================================

    this.__construct = function()
    {
        console.log('Event Created');
        var result = new Result();
        create_todo();
        create_note();
        update_todo();
        update_note();
        update_note_display();
        delete_todo();
        delete_note();
        toggle_note();
    };

    //========================================================================================================

    function create_todo()
    {
        $('#create-todo').on('submit', function(e) {
            e.preventDefault();

            var $this = $(this);
            var url = $this.attr('action');
            var postData = $this.serialize();

            $.post(url, postData, function(o) {
                if (o.result == 1) {
                    Result.success('success');
                    var output = Template.todo(o.data);
                    $('#list-todo').append(output);
                    $('#create-todo input[type="text"]').val('');
                } else {
                    Result.error(o.error);
                }
            }, 'json');
        });
    };

    //========================================================================================================

    function create_note()
    {
        $('#create-note').on('submit', function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('action');
            var postData = $this.serialize();

            $.post(url, postData, function(o) {
                if (o.result == 1) {
                    Result.success('Success');
                    var output = Template.note(o.data);
                    $('#list-note').append(output);
                    $('#create-note input[type="text"], #create-note textarea').val('');
                }
                else {
                    Result.error('Error');
                }
            }, 'json');
        });
    };

    //========================================================================================================

    function update_todo()
    {
        $('body').on('click', 'a.updte-todo', function(e) {
            e.preventDefault();

            var $this = $(this);
            var url = $this.attr('href');
            var postData = {
                todo_id : $this.data('id'),
                completed : $this.data('completed')
            }

            $.post(url, postData, function(o) {
                if (o.result == 1) {

                    if (postData.completed == 1) {
                        $('div#todo_' + postData.todo_id).addClass('completed');
                        $this.html('<i class="fa fa-undo"></i>');
                        $this.data('completed', 0)
                    }
                    else if(postData.completed == 0) {
                        $('div#todo_' + postData.todo_id).removeClass('completed');
                        $this.html('<i class="fa fa-check"></i>');
                        $this.data('completed', 1);
                    }
                    else {
                        Result.error('Nothing Updated');
                    }
                }
            }, 'json');

        });
    };


    //========================================================================================================

    function update_note()
    {
        $('body').on('submit', 'form.note-edit-form' , function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('action');
            var postData = {
                note_id : $this.find('.note-id').val(),
                title : $this.find('.title').val(),
                content : $this.find('.content').val()
            };

            $.post(url, postData, function(o){
                if (o.result == 1) {
                    Result.success('Successfully Updated Note');
                    $('#note-title-' + postData.note_id).html(postData.title);
                    $('#note-content-' + postData.note_id).html(postData.content);
                    $this.remove();
                }
                else {
                    Result.error('Error Saving');
                }
            }, 'json');

        });
    }

    //========================================================================================================

    function update_note_display()
    {
        $('body').on('click', 'a.update-note-display', function(e) {
            e.preventDefault();

            var $this = $(this);
            var note_id = $this.data('id');
            var output = Template.note_edit(note_id);
            $('#note-edit-container-' + note_id).removeClass('hide').html(output);

            // Display data after template is created
            var title = $('#note-title-' + note_id).html();
            var content = $('#note-content-' + note_id).html();

            $('#note-edit-container-' + note_id).find('.title').val(title);
            $('#note-edit-container-' + note_id).find('.content').val(content);
        });

        $('body').on('click', '.cancel', function(e) {
            e.preventDefault();
            $(this).parent().html('');
        });
    };

    //========================================================================================================

    function delete_todo()
    {
        $('body').on('click', 'a.delete-todo', function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('href');
            var postData = {
                todo_id : $this.data('id')
            };

            var confirmed = confirm('Are you sure delete this todo!');
            if (!confirmed) return false;

            $.post(url, postData, function(o){
                if (o.result == 1) {
                    Result.success('Item Deleted');
                    $this.parents('div:eq(0)').fadeOut();
                } else {
                    Result.error(o.msg)
                }
            }, 'json');
        });
    };

    //========================================================================================================

    function delete_note()
    {
        $('body').on('click', 'a.delete-note', function(e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('href');
            var postData = {
                note_id : $this.data('id')
            };

            var confirmed = confirm('Are you sure delete this note!');
            if (!confirmed) return false;

            $.post(url, postData, function(o){
                if (o.result == 1) {
                    Result.success('Item Deleted');
                    $this.parents('div:eq(0)').fadeOut();
                } else {
                    Result.error(o.msg)
                }
            }, 'json');
        });
    };

    //========================================================================================================

    var toggle_note = function() {
        $('body').on('click', '.toggle-note', function(e) {
            e.preventDefault();

            var note_id = $(this).data('id');
            $('#note-content-' + note_id).toggleClass('hide');
        });
    };

    //========================================================================================================

    this.__construct();
}