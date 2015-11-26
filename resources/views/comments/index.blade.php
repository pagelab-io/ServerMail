<div ng-app="commentApp" ng-controller="commentController" class="commentApp">
    <div class="panel panel-default">
        <div class="panel-heading"><span>Comentarios</span></div>
        <div class="panel-body">
            <span ng-show="loading" class="small"><i class="fa fa-spinner fa-spin"></i>Updating...</span>
            <ul class="list">
                <li class="list-item" ng-repeat="comment in comments">
                    <div class="avatar"></div>
                    <div class="content">
                        <div class="user">@{{comment.user.name}}</div>
                        <div class="comment">@{{comment.text}}</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="panel-footer">
            <form autocomplete="off" ng-submit="addComment()">
                <div class="input-group">
                    <input name="text" class="form-control" type='text' ng-model="comment.text" placeholder="Escribir..." required autofocus>
                    <div class="md icon input-group-addon">
                        <div class="fa fa-plus" ng-click="addComment()"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- .commentApp -->
