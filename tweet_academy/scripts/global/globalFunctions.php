<?php

function getUserInfos(): array
{
    $userInfos = [
        'email' => $_POST['email'] ?? '',
        'name' => $_POST['name'] ?? '',
        'tag' => $_POST['tag'] ?? '',
        'status' => $_POST['status'] ?? '',
        'birthdate' => $_POST['birthdate'] ?? '',
        'password' => $_POST['password'] ?? '',
    ];
    foreach ($userInfos as $key => $value) {
        if (empty($value)) {
            unset($userInfos[$key]);
        }
    }
    return $userInfos;
}
