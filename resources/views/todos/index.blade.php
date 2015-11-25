<div ng-app="todoApp" ng-controller="todoController">
    <h3>Mis tareas</h3>
    <div class="row">
        <div class="col-md-4">
            <form autocomplete="off" ng-submit="addTodo()">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" type='text' ng-model="todo.title" required autofocus>
                        <div class="md icon input-group-addon">
                            <div class="fa fa-plus" ng-click="addTodo()"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span ng-show="loading" class="small"><i class="fa fa-spinner fa-spin"></i>Updating...</span>
            <table class="table table-striped table-bordered">
                <tr ng-repeat="todo in todos">
                    <td width="20px">
                        <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="todo.done" ng-checked="@{{ todo.done }}" ng-change="updateTodo(todo)">
                    </td>
                    <td>@{{todo.title}}</td>
                    <td width="40px">
                        <button class="btn btn-danger btn-xs" ng-click="deleteTodo($index)" title="@{{ $index }}">
                            <span class="fa fa-trash" ></span>
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
