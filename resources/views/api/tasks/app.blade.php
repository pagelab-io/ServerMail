{{--TaskApp--}}
<div class="TaskApp" ng-app="taskApp" ng-controller="TaskController as controller">
    <div class="panel panel-default">
        <div class="panel-heading"><span>Tareas</span></div>
        <div class="panel-body">
            <div class="row tasks-header">
                <div class="col-md-12">
                    <form autocomplete="off" ng-submit="controller.addTask()">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" type='text' ng-model="controller.task.name" placeholder="Agregar tarea" required autofocus>
                                <div class="md icon input-group-addon" ng-click="controller.addTask()">
                                    <div class="fa fa-plus"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- .row -->

            <div class="row tasks-body">
                <div class="col-md-12">

                    <span ng-show="loading" class="small"><i class="fa fa-spinner fa-spin"></i>Loading...</span>
                    <p ng-if="!controller.tasks.length">There are no tasks right now</p>

                    <div ng-if="controller.errors.length" class="alert alert-warning" role="alert">
                        <ul>
                            <li ng-repeat="error in controller.errors">@{{ error }}</li>
                        </ul>
                    </div>

                    <table class="table tasks-list table-striped table-bordered">
                        <tr class="tasks-item" ng-repeat="task in controller.tasks | orderBy: -'created_at'">
                            <td width="20px">
                                <input type="checkbox"
                                       ng-true-value="1"
                                       ng-false-value="0"
                                       ng-model="task.done"
                                       ng-checked="@{{task.done}}"
                                       ng-change="controller.toggleDone(task)">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       ng-class="{done: task.done != 0}"
                                       ng-model="task.name"
                                       ng-blur="controller.updateTask(task)"
                                       enter-stroke="controller.updateTask(task)" />

                                <span class="small">Done: @{{ task.done }}</span>
                            </td>

                            <td width="40px">
                                <button class="btn btn-danger btn-xs" ng-click="controller.deleteTask($index)" title="@{{ $index }}">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div> <!-- .row -->
        </div> <!-- .panel-body -->
    </div>
</div> <!-- .TaskApp -->
