<?php

const userFilesDirPath = "./userFiles/";
const sitePatternsDirPath = "./site-patterns/";

define("isPostDataReceived", isset($_POST['email']));


// get data, return array
function getAllUserData(): array {
    $result = "";
    $count = 0;
    foreach(scandir(userFilesDirPath) as $file) {
        $filePath = userFilesDirPath . $file;
        if (!str_contains($filePath, "@")) continue;
        $userData = getUserData($filePath);
        $result .= str_replace(
            ["%username%", "%email%", "%activity%", "%policy%"],
            [$userData["username"], $userData["email"], $userData["activity"], $userData["policy"] === "on" ? "Да" : "Нет"],
            file_get_contents(sitePatternsDirPath . "userBox.html"));
        $count++;
    }
    if ($count == 0) $result = "Сохраненных пользователей нет";
    return ["status" => 200, "message" => "Данные получены", "content" => $result];
}

// get data from user, return string[]
function getUserData($filePath): array {
    $result = ["username" => "", "email" => "", "activity" => "", "policy" => ""];
    foreach (file($filePath) as $str) {
        $buf = explode(": ", str_replace("\n", "", $str));
        $result[$buf[0]] = $buf[1];
    }
    return $result;
}
// get data


// save data, return array
function savePostEntity(): array {
    $text = "";
    foreach ($_POST as $key => $value) $text .= $key . ": " . $value . "\n";
    file_put_contents(userFilesDirPath . $_POST['email'] . ".txt", $text);
    return ["status" => 200, "message" => "Данные " . $_POST['email']  . " успешно сохранены"];
}

echo json_encode(isPostDataReceived ? savePostEntity() : getAllUserData());
