<?php

class EventTest extends PHPUnit_Framework_TestCase
{

    public $counter;

    public function testOn()
    {
        \yii\base\Event::on(
            \Ukiepro\Yii2\Queue\Queue::className(),
            \Ukiepro\Yii2\Queue\Queue::EVENT_AFTER_POST,
                function ($event) {
                    $this->counter += 1;
            }
        );
        
        \yii\base\Event::on(
            \Ukiepro\Yii2\Queue\Queue::className(),
            \Ukiepro\Yii2\Queue\Queue::EVENT_AFTER_FETCH,
                function ($event) {
                    $this->counter += 2;
            }
        );
        
        \yii\base\Event::on(
            \Ukiepro\Yii2\Queue\Queue::className(),
            \Ukiepro\Yii2\Queue\Queue::EVENT_AFTER_DELETE,
                function ($event) {
                    $this->counter += 3;
            }
        );

        $queue = Yii::createObject([
            'class' => '\Ukiepro\Yii2\Queue\Queues\MemoryQueue'
        ]);

        $this->assertEquals($this->counter, 0);
        
        /* @var $queue \Ukiepro\Yii2\Queue\Queues\MemoryQueue */
        $queue->post(new Ukiepro\Yii2\Queue\Job([
            'route' => function() {
                //Do something
            }
        ]));
        
        $this->assertEquals($this->counter, 1);
        
        $job = $queue->fetch();
        
        $this->assertEquals($this->counter, 3);
        
        $queue->delete($job);
        
        $this->assertEquals($this->counter, 6);
    }

}
