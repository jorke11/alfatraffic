<?php

return array(
    // set your paypal credential
    'client_id' => 'AaDxL6eQhPegGvGFfUs34rJZvqOFlyTEXvqw0ejsGYM2z2UouhOjGM3iw_K2nZoAUCCJL4lkNotJM6o4',
    'secret' => 'EOHpBuO9hz4424F4neUVqGDI-vhhJGQG4mtj5TFSWZTB-d6pfRqIq82LjE90gkmpknWxkfMYyTvsNb6h',
    
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
