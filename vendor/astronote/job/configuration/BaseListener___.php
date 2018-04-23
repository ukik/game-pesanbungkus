<?php


abstract class BaseListener___
{
    /**
    * Detects if class has queue or delay parameter
    * If has queue parameter than pushes to certain queue
    *
    * @param $queue
    * @param $job
    * @param $data
    * @return mixed
    */
    public final function queue($queue, $job, $data)
    {
        if (isset($this->queue, $this->delay)) {
            return $queue->laterOn($this->queue, $this->delay, $job, $data);
        }

        if (isset($this->queue)) {
            return $queue->pushOn($this->queue, $job, $data);
        }

        if (isset($this->delay)) {
            return $queue->later($this->delay, $job, $data);
        }

        return $queue->push($job, $data);
    }
}