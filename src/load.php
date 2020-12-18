<?php

use Lizus\LoadDir\LoadDir;


LoadDir::load_files(__DIR__.'/function');
LoadDir::load_files(__DIR__.'/function_without_namespace');
LoadDir::load_files(__DIR__.'/action');
LoadDir::load_files(__DIR__.'/filter');
LoadDir::load_files(__DIR__.'/ajax');
LoadDir::load_files(__DIR__.'/immediately');