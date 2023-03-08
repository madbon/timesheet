<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Carousel;
use yii\bootstrap5\CarouselItem;

$this->title = 'My Application';
?>
<div class="site-index">
    <div class="body-content">

      <?php
        $items = [
            [
                'content' => '<img src="https://via.placeholder.com/800x400?text=Image+1" alt="Image 1">',
                'caption' => '<h3>Image 1 caption</h3>',
            ],
            [
                'content' => '<img src="https://via.placeholder.com/800x400?text=Image+2" alt="Image 2">',
                'caption' => '<h3>Image 2 caption</h3>',
            ],
            [
                'content' => '<img src="https://via.placeholder.com/800x400?text=Image+3" alt="Image 3">',
                'caption' => '<h3>Image 3 caption</h3>',
            ],
        ];
        
        // Render the carousel
        echo Carousel::widget([
            'items' => array_map(function ($item) {
                return [
                    'content' => $item['content'],
                    'caption' => $item['caption'],
                ];
            }, $items),
            'options' => ['class' => 'carousel slide'],
            'controls' => [
                '<span class="carousel-control-prev-icon" aria-hidden="true"></span>',
                '<span class="carousel-control-next-icon" aria-hidden="true"></span>',
            ],
            'id' => 'my-carousel',
        ]);
      ?>

    </div>
</div>
