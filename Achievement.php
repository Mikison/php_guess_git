<?php

interface Achievement {


    function grantAchievement($achievement_id, $user_id);
    function deleteAchieveement($achievement_id, $user_id);
}