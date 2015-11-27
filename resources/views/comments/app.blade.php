<div class="comments-app" ng-app="commentsApp" ng-controller="CommentsController as cmntCtrl">
    <h3>Comentarios</h3>

    <!-- From -->
    <div class="comment-form">
        <form class="form" name="form" ng-submit="form.$valid && cmntCtrl.addComment()" novalidate>
            <div class="form-row">
                <textarea
                        class="input"
                        ng-model="cmntCtrl.comment.text"
                        placeholder="Add comment..."
                        required>
                </textarea>
            </div>

            <div class="form-row">
                <input type="submit" value="Add Comment">
            </div>
        </form>
    </div>

    <!-- Comments List -->
    <div class="comments">
        <!-- Comment -->
        <div class="comment" ng-repeat="comment in cmntCtrl.comments | orderBy: '-created_at'">
            <!-- Comment Avatar -->
            <div class="comment-avatar">
                <img src="http://servermail.pagelab.io/assets/imgs/default_user.png" title="@{{ comment.user.name }}">
            </div>

            <!-- Comment Box -->
            <div class="comment-box">
                <div class="comment-text">@{{ comment.text }}</div>
                <div class="comment-footer">
                    <div class="comment-info">
                        <span class="comment-author"> @{{ comment.user.name }}</span>
                        <span class="comment-date">@{{ comment.created_at | date: 'medium' }}</span>
                    </div>
                    <div class="comment-actions">
                        <a href="#" class="hidden">Reply</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>