<?php
$tag = explode(",", $questions[0]->tags);
$name = explode("-", $tag[0])[1];
?>
 <h1>All questions with tag "<?=$name?>"</h1>
 <h2> <a href="../../question/create">Post a new question</a> </h2>
 <?php foreach ($questions as $question): ?>
     <div class="question-item">
         <small>
             Posted by <?=$question->acronym?> on <?=$question->created?>
         </small>
         <p>
             <a href="../../question/show/<?=$question->id?>"><?= $question->title?></a>
         </p>
     </div>
 <?php endforeach; ?>
