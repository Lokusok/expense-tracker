<?php includeComponent("header.php") ?>

<div class="px-3" x-data="{
  isModalOpen: '<?= $_GET['modalAddOpen'] ?? '' ?>' === 'true',

  openModal() {
    this.isModalOpen = true;
    window.history.pushState({}, '', `?modalAddOpen=${this.isModalOpen}`);
  },

  closeModal() {
    this.isModalOpen = false;

    const urlWithoutQuery = window.location.href.split('?')[0];
    window.history.pushState({}, '', urlWithoutQuery);
  }
}">
  <div class="text-center text-[30px] font-bold my-4">
    <h1>Все расходы</h1>
  </div>

  <div class="flex justify-end mb-[30px]">
    <div>
      <button
        @click="openModal"
        class="text-white font-bold bg-blue-800 px-3 py-1 rounded hover:bg-blue-700 active:bg-blue-600">
        Добавить
      </button>
    </div>
  </div>

  <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            Название расхода
          </th>
          <th scope="col" class="px-6 py-3">
            Описание
          </th>
          <th scope="col" class="px-6 py-3">
            Категория
          </th>
          <th scope="col" class="px-6 py-3">
            Сумма
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Apple MacBook Pro 17"
          </th>
          <td class="px-6 py-4">
            Lorem ipsum dolor sit amet...
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4">
            $2999
          </td>
        </tr>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Microsoft Surface Pro
          </th>
          <td class="px-6 py-4">
            Lorem ipsum dolor sit amet...
          </td>
          <td class="px-6 py-4">
            White
          </td>
          <td class="px-6 py-4">
            $1999
          </td>
        </tr>
        <tr class="bg-white dark:bg-gray-800">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Magic Mouse 2
          </th>
          <td class="px-6 py-4">
            Lorem ipsum dolor sit amet...
          </td>
          <td class="px-6 py-4">
            Black
          </td>
          <td class="px-6 py-4">
            $99
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Назад
      </a>
      <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Дальше
      </a>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Показывается с
          <span class="font-medium">1</span>
          до
          <span class="font-medium">10</span>
          из
          <span class="font-medium">97</span>
          результатов
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Назад</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
            </svg>
          </a>
          <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
          <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">1</a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
          <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
          <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
          <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">8</a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">9</a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">10</a>
          <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Дальше</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </div>

  <div
    class="relative z-10 hidden"
    :class="{
      hidden: !isModalOpen
    }"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true">

    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
      aria-hidden="true">
    </div>

    <div @click="closeModal" class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div @click.stop class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <form>
              <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                  <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Создать запись
                  </h2>
                  <p class="mt-1 text-sm leading-6 text-gray-600">
                    Информация будет сохранена и вы сможете обратиться к ней
                  </p>

                  <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                      <label for="expense_title" class="block text-sm font-medium leading-6 text-gray-900">
                        Название расхода
                      </label>
                      <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                          <input
                            type="text"
                            name="expense_title"
                            id="expense_title"
                            autocomplete="expense_title"
                            class="px-2 block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="На покушоц...">
                        </div>
                      </div>
                    </div>

                    <div class="col-span-full">
                      <label
                        for="expense_descr"
                        class="block text-sm font-medium leading-6 text-gray-900">
                        Краткое описание
                      </label>
                      <div class="mt-2">
                        <textarea
                          id="expense_descr"
                          name="expense_descr"
                          rows="3"
                          class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                      </div>
                      <p class="mt-3 text-sm leading-6 text-gray-600">Немного опишите на что были расходы</p>
                    </div>

                    <div class="sm:col-span-3">
                      <label for="expense_category" class="block text-sm font-medium leading-6 text-gray-900">
                        Категория
                      </label>
                      <div class="mt-2">
                        <select id="expense_category" name="expense_category" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                          <option>Питание</option>
                          <option>Техника</option>
                          <option>ЖКХ</option>
                          <option>Здоровье</option>
                          <option>Животные</option>
                          <option>Иное</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-6 flex items-center justify-end gap-x-6">
                <button
                  @click="closeModal"
                  type="button"
                  class="text-sm font-semibold leading-6 text-gray-900">
                  Отмена
                </button>

                <button
                  type="submit"
                  class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:pointer-events-none disabled:opacity-50"
                  disabled>
                  Сохранить
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php includeComponent("footer.php") ?>