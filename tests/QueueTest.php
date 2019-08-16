<?php

class QueueTest extends PHPUnit_Framework_TestCase {
    
    public function testQueueCatchingException() {
        $this->setExpectedException(\yii\base\Exception::class);
        $queue = Yii::createObject([
            'class' => '\Ukiepro\Yii2\Queue\Queues\MemoryQueue'
        ]);
         
        /* @var $queue \Ukiepro\Yii2\Queue\Queues\MemoryQueue */
         $queue->post(new Ukiepro\Yii2\Queue\Job([
             'route' => function() {
                throw new \Exception('Test');
             }
         ]));
         $this->assertEquals(1, $queue->getSize());
         $job = $queue->fetch();
         $this->assertEquals(0, $queue->getSize());
         $queue->run($job);
    }
}


