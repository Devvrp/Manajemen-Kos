<?php

class Log
{
    public static function record($userId, $action)
    {
        try {
            $logModel = new ActivityLog();
            $logModel->create($userId, $action);
        } catch (Exception $e) {
        }
    }
}