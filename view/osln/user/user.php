<?php
namespace Osln\User;
?><!-- menu wrapper -->
<?php if ($flashmessage): ?>
    <div class="flashmessage floating-block">
        <p><?= $flashmessage ?></p>
    </div>
<?php endif; ?>
<div class="region-main has-sidebar-right has-sidebar">
    <div class="floating-block">
        <h1>All questions posted by <?=$user->acronym?></h1>
    </div>
    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <div class="question-item floating-block">
                <small>
                    Posted by <?=$item->acronym?> on <?=$item->created?>
                    Tags:
                    <?php foreach (explode(",", $item->tags) as $tag): ?>
                        <?php $tagSplit = explode("-", $tag)?>
                        <a href="../../tag/show/<?=$tagSplit[0]?>">
                            <?=$tagSplit[1]?>
                        </a>
                    <?php endforeach; ?>
                </small>
                <p>
                    <a href="../../question/show/<?=$item->question_id?>">
                        <?= $item->title?>
                    </a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>The user has not posted anything yet!</p>
    <?php endif; ?>
</div>
<?php // TODO: fixa att userna lltid visar från session ?>
<div class="wrap-sidebar region-sidebar-right has-sidebar-right has-sidebar">
    <div class="floating-block">
        <?php if ($user) : ?>
            <img src="<?=$user->gravatar?>" alt="user gravatar">
            <p>User <?=$user->acronym?></p>
            <p>Joined on <?=$user->created?></p>
            <?php if ($userSession["acronym"] == $user->acronym): ?>
                <a href="../../user/updateuser/<?=$userSession["id"]?>">Update email</a>
                <p></p>
                <a href="../../user/updatepass/<?=$userSession["id"]?>">Update password</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
