<?php
session_start();
session_unset();
session_destroy();
header("Location: ilk_orn.php?cikis=1");
exit;
