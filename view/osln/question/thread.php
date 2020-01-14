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
<h1><?=$question["title"]?></h1>
<div class="thread-info">
    <small>
        Posted by
        <a href="../../user/show/<?=$question["author"]?>">
            <?=$question["author"]?>
        </a>
        on <?=$question["created"]?>
        Tags:
        <?php foreach ($question["tags"] as $key => $tag): ?>
            <a href="tag/show/<?=$key?>"><?=$tag?></a>
        <?php endforeach; ?>
    </small>
</div>
<p>
    <?=$question["content"]?>
</p>
<?=$mainForm?>
<?php if (!empty($sortedComments)): ?>
    <?php foreach ($sortedComments as $comment): ?>
        <?php $spacing = 0; ?>
        <div class="all-comments" style="border-left: 2px solid black">
            <?php include("comment.php"); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
