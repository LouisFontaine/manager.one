<?php
class httpStatusAnswer
{

    // Static variable and static function 
    // using static keyword 

    public static function send405status(string $message)
    {
        echo json_encode(
            array(
                'status' => '405',
                'title' => 'Method Not Allowed',
                'details' => $message,
                'type' => 'about:blank'
            )
        );
    }

    public static function send404status(string $message)
    {
        echo json_encode(
            array(
                'status' => '404',
                'title' => 'Not Found Exception',
                'details' => $message,
                'type' => 'about:blank'
            )
        );
    }

    public static function send204status(string $message)
    {
        echo json_encode(
            array(
                'status' => '204',
                'title' => ' The request was handled successfully',
                'details' => $message,
                'type' => 'about:blank'
            )
        );
    }

    public static function send424status(string $message)
    {
        echo json_encode(
            array(
                'status' => '424',
                'title' => 'Failed Dependency',
                'details' => $message,
                'type' => 'about:blank'
            )
        );
    }
}
