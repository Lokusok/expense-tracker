<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expense Tracker</title>

  <link rel="icon" href="/favicon.ico">

  <link rel="stylesheet" href="/style.css" >
  
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
  />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body
  x-data="{
    isLogoutModalOpen: false,

    openLogoutModal() {
      this.isLogoutModalOpen = true;
    },

    closeLogoutModal() {
      this.isLogoutModalOpen = false;
    }
  }"
>
  <div
    class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[200px] overflow-y-auto text-center bg-gray-900"
  >
      <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center">
          <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>
          <h1 class="font-bold text-gray-200 text-[15px] ml-3">Tracker</h1>
          <i
            class="bi bi-x cursor-pointer ml-28 lg:hidden"
          >
          </i>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
      </div>
      <div
        class="pr-[45px] relative p-2.5 flex items-center rounded-md px-4 duration-300 bg-gray-700 text-white"
      >
        <i class="bi bi-search text-sm"></i>
        <form
          x-data="{
            queryOnRender: '<?= $_GET['q'] ?? '' ?>',
            query: '<?= $_GET['q'] ?? '' ?>',

            get isSubmitDisabled() {
              return this.query.length === 0 && this.queryOnRender.length === 0;
            }
          }"
          action="/expenses"
          method="GET"
        >
          <input
            x-model="query"
            type="text"
            name="q"
            placeholder="Поиск"
            class="
              text-[15px] ml-4 w-full bg-transparent focus:outline-none
              <?= !isAuth() ? 'pointer-events-none opacity-50' : '' ?>
            "
            <?= !isAuth() ? 'disabled' : '' ?>
          />
          <div class="absolute right-0 top-0 h-[100%]">
            <button
              x-cloak
              :disabled="isSubmitDisabled"
              type="submit"
              class="bg-blue-800 hover:bg-blue-700 active:opacity-60 text-white w-[40px] flex justify-center items-center rounded h-[100%] disabled:pointer-events-none disabled:opacity-50"
            >
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      <a
        href="/"
        class="
          p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
          <?= urlIs("/") ? 'bg-blue-600 text-white' : '' ?>
          <?= !isAuth() ? 'opacity-50 pointer-events-none' : ''  ?>
        "
      >
        <i class="bi bi-house-door-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Главная</span>
      </a>

      <a
        href="/profile"
        class="
          p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
          <?= urlIs("/profile") ? 'bg-blue-600 text-white' : '' ?>
          <?= !isAuth() ? 'opacity-50 pointer-events-none' : ''  ?>
        "
      >
        <i class="bi bi-person-square"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Профиль</span>
      </a>

      <a
        href="/expenses"
        class="
          p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
          <?= urlIs("/expenses") ? 'bg-blue-600 text-white' : '' ?>
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
            <?= urlIs("/login") ? 'bg-blue-600 text-white' : '' ?>
          "
        >
          <i class="bi bi-person-square"></i>
          <span class="text-[15px] ml-4 text-gray-200 font-bold">Вход</span>
        </a>

        <a
          href="/register"
          class="
            p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white
            <?= urlIs("/register") ? 'bg-blue-600 text-white' : '' ?>
          "
        >
          <i class="bi bi-door-open"></i>
          <span class="text-[15px] ml-4 text-gray-200 font-bold">Регистрация</span>
        </a>
      <?php endif ?>

      <?php if (isAuth()): ?>
        <div class="flex">
          <button
            type="button"
            class="grow p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
            @click="openLogoutModal"
          >
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Выход</span>
          </button>
        </div>
      <?php endif ?>
  </div>

  <?php if (isAuth()): ?>
  <!-- Модалка подтверждения выхода из аккаунта -->
  <div
    :class="{
      hidden: !isLogoutModalOpen
    }"
    class="relative z-10 hidden"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >

    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
      aria-hidden="true"
    >
    </div>

    <div @click="closeLogoutModal" class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        
        <div @click.stop class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                  Выйти из аккаунта?
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    Вы уверены, что хотите выйти из аккаунта? Вы сможете войти обратно в любой момент.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <form
              action="/logout"
              method="POST"
            >
              <input type="hidden" name="_method" value="DELETE">
              <button
                type="submit"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
              >
                Выйти
              </button>
            </form>
            <button
              type="button"
              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
              @click="closeLogoutModal"
            >
              Отмена
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif ?>

    <div class="pl-[200px]">