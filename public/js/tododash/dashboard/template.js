var Template = function()
{
    //========================================================================================================

    this.__construct = function()
    {
        console.log('template created');
    }

    //========================================================================================================

    this.todo = function(obj)
    {
        var output = '';
        if (obj.completed == 1) {
            output += '<div id="todo_'+ obj.todo_id +'" class="completed">';
        } else {
            output += '<div id="todo_'+ obj.todo_id +'">';
        }
        output += '<span>' + obj.content + '</span>';

        output += '<span class="options">';

        if ( obj.completed == 1 ) {
            output += '<a data-id="'+ obj.todo_id +'" href="api/update_todo" class="updte-todo" data-completed="0"><i class="fa fa-undo"></i></a>';
        }
        else {
            output += '<a data-id="'+ obj.todo_id +'" href="api/update_todo" class="updte-todo" data-completed="1"><i class="fa fa-check"></i></a>';
        }

        output += '<a data-id="'+ obj.todo_id +'" href="api/delete_todo" class="delete-todo"><i class="fa fa-remove"></i></a>'
        output += '</span>';

        output += '</div>';
        return output;
    };

    //========================================================================================================

    this.note = function(obj)
    {
        var output = '';
        output += '<div id="'+ obj.note_id +'">';
        output += '<span><a href="#" class="toggle-note" data-id="'+ obj.note_id +'" id="note-title-'+ obj.note_id +'">'+ obj.title +'</a></span>';
        output += '<span class="options">';
        output += '<a href="api/update_note" data-id="'+ obj.note_id +'" class="update-note-display"><i class="fa fa-pencil-square-o"></i></a>';
        output += '<a href="api/delete_note" data-id="'+ obj.note_id +'" class="delete-note"><i class="fa fa-remove"></i></a>';
        output += '</span>';
        output += '</div>';
        output += '<div id="note-edit-container-'+ obj.note_id +'" class="hide"></div>';
        output += '<div class="hide" id="note-content-'+ obj.note_id +'">'+ obj.content +'</div>';
        return output;
    };

    //========================================================================================================

    this.note_edit = function(note_id)
    {
        var output = '';
        output += '<form method="post" class="note-edit-form" action="api/update_note">';
        output += '<input type="text" class="form-control title" name="title" placeholder="title">';
        output += '<input type="hidden" name="note_id" class="note-id" value="'+ note_id +'">'
        output += '<textarea name="content" class="form-control content" placeholder="content"></textarea>';
        output += '<br><input type="submit" class="btn btn-primary" value="Update">&nbsp;';
        output += '<a href="#" class="btn btn-default cancel">Cancel</a>'
        output += '</form>';
        return output;
    };

    //========================================================================================================

    this.__construct();
}