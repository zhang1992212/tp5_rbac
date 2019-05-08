<?php
\think\Console::addDefaultCommands([
    "geek1992\\tp5_rbac\\command\\migration\\Run",
    "geek1992\\tp5_rbac\\command\\migration\\Create",
    "geek1992\\tp5_rbac\\command\\migration\\Rollback",
    "geek1992\\tp5_rbac\\command\\seed\\Create",
    "geek1992\\tp5_rbac\\command\\seed\\Run"
]);
