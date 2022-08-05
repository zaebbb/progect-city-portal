<?php 
    include_once "./components/config.php";
    include_once "./components/functions.php";
    include_once "./components/header.php";
    
?>

<section class="section__cards">
    <h2 class="section__heading">Решенные задачи</h2>
    <ul class="section__cards--list">
        <?php 
        if(!empty($get_completes()) == true):
            foreach($get_completes() as $card): 
                $image_do = $card[3];
                $image_complete = $card[6];
                ?>
                <li class="section__cards--item">
                    <div class="section__cards--content">
                        <h3 class="section__cards--title"><?=$card[1]?></h3>
                        <p class="section__cards--description"><?=$card[7]?></p>
                        <p class="section__cards--description"><strong>Категория:</strong> <?=$card[4]?></p>
                    </div>
                    <div class="section__cards--images">
                        <img src="<?=$get_url_page("images/completes/$image_complete")?>" class="section__cards--image">
                        <img src="<?=$get_url_page("images/active/$image_do")?>" class="section__cards--image">
                    </div>
                </li>
                <?php 
            endforeach; 
        else: ?> <h3 class="section__cards--title">Мы пока не решили ни одну задачу, но мы работаем над этим!</h3> <?php
         endif;
    ?>
    </ul>
</section>

<div class="section__completes">
    <p class="section__completes--description">Мы уже решили <b> <?=$count_complete_quiz()?></b>!</p>
</div>

<?php 
    include_once "./components/footer.php"
?>