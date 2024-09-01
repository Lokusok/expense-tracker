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

/**
 * Установка сообщений, которые должны исчезнуть
 */
function setFlushMessages(array $messages): void {
  $_SESSION['flush'] = $messages;
}

/**
 * Получить сообщение по имени
 */
function getFlushMessage(string $name): string {
  $result = $_SESSION['flush'][$name] ?? '';
  return $result;
}

/**
 * Удалить сообщения по списку имён
 */
function clearFlushMessages(array $names): void {
  foreach ($names as $name) {
    if (isset($_SESSION['flush'][$name])) {
      unset($_SESSION['flush'][$name]);
    }
  }
}