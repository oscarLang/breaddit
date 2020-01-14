<?php
?>
<script type="text/javascript">
    function showReplyComment(id) {
        var x = document.getElementById("reply" + id);
        console.log(x);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<div class="comment spacing<?=$spacing?>">
    <small>
        Posted by
        <a href="../../user/show/<?=$comment["acronym"]?>">
            <?=$comment["acronym"]?></a>
        on <?=$comment["created"]?>
    </small>
    <p><?=$comment["content"]?> id <?=$comment["id"]?> parent<?=$comment["parent_comment_id"]?></p>
    <button onclick="showReplyComment(<?=$comment["id"]?>)">Reply</button>
    <div class="reply-comment" id="reply<?=$comment["id"]?>" style="display:none;">
        <?=$comment["comment_form"]?>
    </div>

</div>

<?php
    if (isset($comment["children"]) && !empty($comment["children"])) {
        // echo "true";
        $spacing += 1;
        foreach ($comment["children"] as $child) {
            $comment = $child;
            // var_dump($comment);
            include("comment.php");
        }
    } else {
        $spacing -= 1;
    }
 ?>
