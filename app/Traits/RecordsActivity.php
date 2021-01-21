<?php

namespace App\Traits;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($thread) {
                $thread->recordActivity('created');
            });
        }

        static::deleting(function($model){
            $model->activity()->delete();
        });
    }

    public static function getRecordEvents()
    {
        return ['created'];
    }

    protected function recordActivity(string $event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $event . '_' . strtolower((new \ReflectionClass($this))->getShortName()),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
