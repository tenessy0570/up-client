<h1>Список статей</h1>
<ol>
   <?php
   foreach ($posts as $post) { ?>
       <li>
           <p><?= $post->title ?></p>
           <p><?= $post->text ?></p>
           </li> <?php
   }
   ?>
</ol>
