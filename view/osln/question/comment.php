
<div class="comment">
    <small class="comment-user">
        Posted by
        <a href="../../user/show/<?=$comment["acronym"]?>">
            <?=$comment["acronym"]?></a>
        on <?=$comment["created"]?>
    </small>
    <p><?=$comment["content"]?></p>
    <button class="replybutton"onclick="showReplyComment(<?=$comment["id"]?>)">Reply</button>
    <div class="reply-comment" id="reply<?=$comment["id"]?>" style="display:none;">
        <?=$comment["comment_form"]?>
    </div>
<?php
    if (isset($comment["children"]) && !empty($comment["children"])) {
        foreach ($comment["children"] as $child) {
            $comment = $child;
            include("comment.php");
        }
    }
 ?>
</div>
