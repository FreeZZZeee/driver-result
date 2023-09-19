<?php

defined("ROOTPATH") or exit('Доступ запрещен!');

checkExtensions();
function checkExtensions(): void
{
    $requiredExtensions = [
        'mbstring'
    ];

    $notLoaded = [];

    foreach ($requiredExtensions as $ext) {
        if (!extension_loaded($ext)) {
            $notLoaded[] = $ext;
        }
    }

    if (!empty($notLoaded)) {
        show("Загрузите следующие расширения в свой файл php.ini: <br>" . implode("<br>", $notLoaded));
        die();
    }
}

function show(mixed $data): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/*
 * Проверка существует значение в массиве или объекте
 */
function inMultiArray($elem, $array): bool
{
    if (is_array($array) || is_object($array)) {
        if (is_object($array)) {
            $temp_array = get_object_vars($array);
            if (in_array($elem, $temp_array)) {
                return true;
            }
        }
        if (is_array($array) && in_array($elem, $array)) {
            return true;
        }
        foreach ($array as $array_element) {
            if ((is_array($array_element) || is_object($array_element)) && inMultiArray($elem, $array_element)) {
                return true;
                exit;
            }
        }
    }
    return false;
}

function redirect(string $path = ""): void
{
    header("Location: " . ROOT . $path);
    die();
}

function cmp ($a, $b): int
{
    if ($a['result'] > $b['result']) {
        return -1;
    } elseif ($a['result'] < $b['result']) {
        return 1;
    } else {
        if ($a['resultToString'] > $b['resultToString']) {
            return -1;
        } elseif ($a['resultToString'] < $b['resultToString']) {
            return 1;
        } else {
            return strnatcmp($a['name'], $b['name']);
        }
    }
}