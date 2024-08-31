<?php

/**
 * Функция для подключения компонента внутри вьюх
 */
function includeComponent(string $cmpName): void {
  require ASSETS_PATH . "/components/" . $cmpName;
}