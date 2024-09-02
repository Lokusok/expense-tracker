<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full</title>

  <link rel="stylesheet" href="/style.css" >
  
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
  />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div
    class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[200px] overflow-y-auto text-center bg-gray-900"
  >
      <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center">
          <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>
          <h1 class="font-bold text-gray-200 text-[15px] ml-3">Tracker</h1>
          <i
            class="bi bi-x cursor-pointer ml-28 lg:hidden"
          ></i>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
      </div>
      <div
        class="p-2.5 flex items-center rounded-md px-4 duration-300 bg-gray-700 text-white"
      >
        <i class="bi bi-search text-sm"></i>
        <input
          type="text"
          placeholder="Search"
          class="
            text-[15px] ml-4 w-full bg-transparent focus:outline-none
            <?= !isAuth() ? 'pointer-events-none opacity-50' : '' ?>
          "
          <?= !isAuth() ? 'disabled' : '' ?>
        />
      </div>
      <a
        href="/"
        class="
          p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
          <?= isUrlEqual("/") ? 'bg-blue-600 text-white' : '' ?>
          <?= !isAuth() ? 'opacity-50 pointer-events-none' : ''  ?>
        "
      >
        <i class="bi bi-house-door-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Главная</span>
      </a>
      <a
        href="/expenses"
        class="
          p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
          <?= isUrlEqual("/expenses") ? 'bg-blue-600 text-white' : '' ?>
          <?= !isAuth() ? 'opacity-50 pointer-events-none' : ''  ?>
        "
      >
        <i class="bi bi-piggy-bank-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Расходы</span>
      </a>

      <div class="my-4 bg-gray-600 h-[1px]"></div>
      
      <?php if(! isAuth()): ?>
        <a
          href="/login"
          class="
            p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
            <?= isUrlEqual("/login") ? 'bg-blue-600 text-white' : '' ?>
          "
        >
          <i class="bi bi-person-square"></i>
          <span class="text-[15px] ml-4 text-gray-200 font-bold">Вход</span>
        </a>

        <a
          href="/register"
          class="
            p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
            <?= isUrlEqual("/register") ? 'bg-blue-600 text-white' : '' ?>
          "
        >
          <i class="bi bi-door-open"></i>
          <span class="text-[15px] ml-4 text-gray-200 font-bold">Регистрация</span>
        </a>
      <?php endif ?>

      <?php if (isAuth()): ?>
        <form action="/logout" method="POST" class="flex">
          <input type="hidden" name="_method" value="DELETE">

          <button
            type="submit"
            class="grow p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
          >
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Выход</span>
          </button>
        </form>
      <?php endif ?>
    </div>

    <div class="pl-[200px]">