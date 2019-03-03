<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DumperService macro name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the macro registered on the Illuminate\Database\Query\Builder.
    |
    */

    'macro' => env('ELOQUENT_SQL_DUMPER_MACRO', 'dump'),

];
