<?php

declare(strict_types=1);

/**
 * Функция для подключения компонента внутри вьюх
 */
function includeComponent(string $cmpName): void {
  require ASSETS_PATH . "/components/" . $cmpName;
}

/**
 * Проверка текущего урла
 */
function isUrlEqual(string $url): bool {
  return $_SERVER["REQUEST_URI"] === $url;
}

/**
 * Редирект на нужный урл
 */
function redirect(string $url): void {
  header("Location: " . $url);
}