<?php

namespace Core\Schedules;

/**
 * Example schedule.
 */
class Example
{
    /** @var string Schedule slug */
    protected $schedule_slug = 'example';

    /**
     * Set hooks.
     */
    public function __construct()
    {
        add_filter('cron_schedules', [ $this, 'addSchedule' ]);
        add_action('wp', [ $this, 'cronSchedule' ]);
        add_action($this->schedule_slug, [ $this, 'doStuff' ]);
    }

    /**
     * Add a five minute schedule.
     */
    public function addSchedule()
    {
        $schedules['fiveminutes'] = [
            'interval' => 300,
            'display'  => __('Every 5 minutes', 'core')
        ];
        return $schedules;
    }

    /**
     * Schedule task.
     */
    public function cronSchedule()
    {
        if (false == wp_next_scheduled($this->schedule_slug)) {
            wp_schedule_event(time(), 'fiveminutes', $this->schedule_slug);
        }
    }

    /**
     * Handle task.
     */
    public function doStuff()
    {
        // Do stuff every 5 minutes
    }
}
