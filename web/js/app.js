$(function(){
    window.Task = Backbone.Model.extend({
        defaults: {
            id: null,
            project_id: null,
            user_id: null,
            pos: null,
            col: null,
            severity: null,
            content: null
        },
        initialize : function Task() {
            console.log('Task Constructor');

            this.url = "/api/tasks/"+this.id;
            
            this.bind("error", function(model, error){
                console.log( error );
            });

        }
    });

    window.TasksCollection = Backbone.Collection.extend({
        model: Task,
        url : "/api/tasks/"
    });

    window.Tasks = new BooksCollection;

    window.TaskView = Backbone.View.extend({
        tagName: "li",
        events: {
        },
        template: $("#task-item").template(),
        initialize: function(){
            _.bindAll(this, "render");
        },
        render: function(){
            var element = jQuery.tmpl(this.template, this.model.toJSON());
            $(this.el).html(element);
            return this;
        }
    });

    window.AppView = Backbone.View.extend({
        el: $("#project"),
        events: {
            
        },
        initialize: function(){
            _.bindAll(this, "render");
            this.activeBookId = null;
            this.$("#create").show();
            Books.bind('add', this.addBook); 
            Books.bind('reset', this.addAll);
            Books.fetch();
        }
    });

    Backbone.sync = sync;

    window.App = new AppView();
    
});