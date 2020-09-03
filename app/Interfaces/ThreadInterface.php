<?php 

interface ThreadInterface {
    public function getThreads();
    public function getThread(int $threadId);
};