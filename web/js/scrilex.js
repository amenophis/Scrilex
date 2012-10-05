function Scrilex(projectId) {
    var oThis = this;
    
    /** Methods declarations **/
    
    this.initSortable = function()
    {
        $('.sortable-list').sortable({
            connectWith: ".sortable-list",
            update: function(event, ui) {
                if(ui.sender == null){
                    oThis.taskId = ui.item.attr('id').split('task_')[1];
                    console.log(oThis.taskId);
                    oThis.sortableUpdate();
                }
            }
        });
        
        $('.sortable-list li').on('dblclick', function(){
            var col = parseInt($(this).parent().attr('id').split('col-')[1]) + 1;
            if(col == 4) col = -1;
            oThis.moveTask(oThis.taskId, col);
        });
    }
    
    this.projectLoadUrl = function(url, params)
    {
        console.log(url);
        $('#project').load(url, params, function(){
            oThis.initSortable();
            initAjax();
        });
    }
    
    this.updateTaskProperty = function(property, value)
    {
        oThis.projectLoadUrl(javascript_routes['project_taskUpdateProperty'].replace('{id}', oThis.taskId).replace('{property}', property).replace('{value}', value), "");
    }

    this.loadTaskProperties = function()
    {
        oThis.projectLoadUrl(javascript_routes['project_taskInformations'].replace('{id}', oThis.taskId), "");
    }

    this.moveTask = function(taskId, column)
    {
        oThis.taskId = taskId;
        oThis.projectLoadUrl(javascript_routes['project_setTaskColumn'].replace('{id}', oThis.taskId).replace('{col}', column), "");
    }

    this.sortableUpdate = function()
    {
        var results = new Array();

        $lists = $('ul[id^="col-"]');
        $lists.each(function(){
            var column = $(this).attr('id').split('col-')[1];
            results[column] = $(this).sortable('serialize').replace(/task\[\]=([0-9]*)\&/g, '$1|');
            results[column] = results[column].replace(/task\[\]=([0-9]*)/g, '$1');
        });

        oThis.projectLoadUrl(javascript_routes['project_updateTasksPositions'].replace('{id}', oThis.projectId), { 'results': results, 'task_id': oThis.taskId });
    }
    
    /** Constructor **/
    if(projectId != null) oThis.projectId = projectId;
    if(oThis.projectId == null) throw new Exception('Project ID is null');

    oThis.initSortable();

    $(document).on('click', '.sortable-list > li', function(e){
        oThis.taskId = $(this).attr('id').split('task_')[1];
        oThis.loadTaskProperties();
    });

    $(document).on('click', '.sortable-list > li i.close.icon-ok', function(e){
        e.preventDefault();
        var id = $(this).parent().attr('id').split('task_')[1];
        oThis.moveTask(id, -1);
        return false;
    });

    $(document).on('click', '#archive > li i.close.icon-remove', function(e){
        e.preventDefault();
        var id = $(this).parent().attr('id').split('task_')[1];
        oThis.moveTask(id, 0);
        return false;
    });

    $(document).on('change', '#severity', function(){
        oThis.updateTaskProperty('severity', $(this).val());
    });
}