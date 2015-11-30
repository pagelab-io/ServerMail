
<div class="todos-app" ng-app="todoApp" ng-controller="todoController as controller">
    <div class="panel panel-default">
        <div class="panel-heading"><span>Tareas</span></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <form autocomplete="off" ng-submit="controller.addTodo()">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" type='text' ng-model="controller.todo.name" placeholder="Agregar tarea" required autofocus>
                                <div class="md icon input-group-addon">
                                    <div class="fa fa-plus" ng-click="addTodo()"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span ng-show="loading" class="small"><i class="fa fa-spinner fa-spin"></i>Updating...</span>
                    <table class="table table-striped table-bordered">
                        <tr ng-repeat="todo in controller.todos | orderBy: -'created_at'">
                            <td width="20px">
                                <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="todo.done" ng-checked="@{{ todo.done }}" ng-change="controller.updateTodo(todo)">
                            </td>
                            <td>@{{todo.name}}</td>
                            <td width="40px">
                                <button class="btn btn-danger btn-xs" ng-click="controller.deleteTodo($index)" title="@{{ $index }}">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>