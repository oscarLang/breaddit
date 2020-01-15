<?php
$tag = explode(",", $questions[0]->tags);
$name = explode("-", $tag[0])[1];
?>
<div class="floating-block">
    <h1>All questions with tag "<?=$name?>"</h1>
    <h2> <a href="../../question/create">Post a new question</a> </h2>
</div>
 <?php foreach ($questions as $question): ?>
     <div class="question-item floating-block">
         <small>
             Posted by <?=$question->acronym?> on <?=$question->created?>
         </small>
         <p>
             <a href="../../question/show/<?=$question->question_id?>"><?= $question->title?></a>
         </p>
     </div>
 <?php endforeach; ?>
