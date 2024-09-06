<?php includeComponent("header.php") ?>

<div class="px-3" x-data="{
  isModalOpen: '<?= $_GET['modalAddOpen'] ?? '' ?>' === 'true',
  isEditModalOpen: '<?= $_GET['modalEditOpen'] ?? '' ?>' === 'true',

  editItemShape: (sessionStorage.getItem('editItemShape') ? JSON.parse(sessionStorage.getItem('editItemShape')) : ({
    id: '',
    title: '',
    price: '',
    description: '',
    category_id: ''
  })),

  deleteItemId: null,

  // Сохранение редактируемой сущности в sessionStorage
  updateEditItemShape() {
    const existShape = JSON.parse(sessionStorage.getItem('editItemShape') ?? '{}');

    existShape.id = this.editItemShape.id;
    existShape.title = this.editItemShape.title;
    existShape.price = this.editItemShape.price;
    existShape.description = this.editItemShape.description;
    existShape.category_id = this.editItemShape.category_id;

    sessionStorage.setItem('editItemShape', JSON.stringify(existShape));
  },

  // Удаление редактируемой сущности из sessionStorage
  deleteEditItemShape() {
    sessionStorage.removeItem('editItemShape');
  },

  // Модалка добавления
  openModal() {
    this.isModalOpen = true;
    this.addToQuery('modalAddOpen', true);
  },

  closeModal() {
    this.isModalOpen = false;
    this.removeFromQuery('modalAddOpen', false);
  },

  // Модалка удаления (не сохраняем в урл)
  showDeleteConfirmModal(itemId) {
    this.isDeleteConfirmModalOpen = true;
    this.deleteItemId = itemId;
  },

  closeDeleteConfirmModal() {
    this.isDeleteConfirmModalOpen = false;
    this.deleteItemId = null;

    this.removeFromQuery('modalDeleteOpen');
  },

  // Модалка редактирования
  showEditModal(itemShape) {
    this.isEditModalOpen = true;
    this.editItemShape = itemShape;

    this.addToQuery('modalEditOpen', true);
  },

  closeEditModal() {
    this.isEditModalOpen = false;
    this.editItemId = null;

    this.removeFromQuery('modalEditOpen');
    this.deleteEditItemShape();
  },

  addToQuery(name, val) {
    let existQuery = window.location.search;

    if (existQuery) existQuery += '&';
    else existQuery += '?';

    window.history.pushState({}, '', `${existQuery}${name}=${val}`);
  },

  removeFromQuery(name) {
    const query = new URLSearchParams(window.location.search);

    query.delete(name);

    window.history.pushState({}, '', `?${query.toString()}`);
    console.log({ query: query.toString() });
  },
}">
  <div
    x-effect="updateEditItemShape"
    class="text-center text-[30px] font-bold my-4"
  >
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

  <?php if (count($expenses) > 0): ?>
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
            <th scope="col" class="px-6 py-3">
              Действия
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($expenses as $expense): ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <?= $expense['title'] ?>
              </th>
              <td class="px-6 py-4">
                <?= $expense['description'] ?>
              </td>
              <td class="px-6 py-4">
                <?= $expense['category_title'] ?>
              </td>
              <td class="px-6 py-4">
                <?= $expense['price'] ?>
              </td>
              <td class="px-6 py-4 flex gap-x-3">
                <button
                  class="px-3 bg-blue-800 text-white rounded cursor-pointer w-[30px] h-[30px] flex justify-center items-center hover:bg-blue-700 active:opacity-70"
                  @click="showEditModal(
                    {
                      id: '<?= $expense['expense_id'] ?>',
                      title: '<?= $expense['title'] ?>',
                      description: '<?= $expense['description'] ?>',
                      category_id: '<?= $expense['category_id'] ?>',
                      price: '<?= $expense['price'] ?>'
                    }
                  )"
                >
                  <i class="bi bi-pencil-square"></i>
                </button>

                <button
                  class="px-3 bg-red-800 text-white rounded cursor-pointer w-[30px] h-[30px] flex justify-center items-center hover:bg-red-700 active:opacity-70"
                  @click="showDeleteConfirmModal(<?= $expense['expense_id'] ?>)"
                >
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <?php if ($maxPage > 1): ?>
      <div class="flex items-center justify-center border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div>
          <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <!-- Кнопка назад -->
            <a
              href="/expenses?page=<?= $currentPage - 1 ?>"
              class="
                <?= $currentPage - 1 === 0 ? 'pointer-events-none opacity-50' : '' ?>
                relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0
              "
            >
              <span class="sr-only">Назад</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
              </svg>
            </a>

            <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
            <?php foreach (range(1, $maxPage, 1) as $page): ?>
              <a
                href="/expenses?page=<?= $page ?>"
                class="
                <?= $page == $currentPage ? 'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 pointer-events-none' : '' ?>
                relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
              >
                <?= $page ?>
              </a>
            <?php endforeach ?>

            <!-- Кнопка вперед -->
            <a
              href="/expenses?page=<?= $currentPage + 1 ?>"
              class="
              <?= $currentPage == $maxPage ? 'pointer-events-none opacity-50' : '' ?>
                relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0
              "
            >
              <span class="sr-only">Дальше</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
              </svg>
            </a>
          </nav>
        </div>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <p class="text-center">Расходов нет...</p>
  <?php endif; ?>

  <!-- Модалка добавления -->
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
            <form action="/expenses" method="POST">
              <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                  <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Создать запись
                  </h2>
                  <p class="mt-1 text-sm leading-6 text-gray-600">
                    Информация будет сохранена и вы сможете обратиться к ней
                  </p>

                  <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-6">
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

                    <div class="sm:col-span-4">
                      <label for="expense_price" class="block text-sm font-medium leading-6 text-gray-900">
                        Стоимость
                      </label>
                      <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                          <input
                            type="text"
                            name="expense_price"
                            id="expense_price"
                            autocomplete="expense_price"
                            class="px-2 block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="500₽">
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
                          <?php foreach ($tags as $tag): ?>
                            <option value="<?= $tag['id'] ?>">
                              <?= $tag['title'] ?>
                            </option>
                          <?php endforeach ?>
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
                >
                  Сохранить
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Модалка подтверждения удаления -->
  <div
    :class="{
      hidden: !isDeleteConfirmModalOpen
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

    <div @click="closeDeleteConfirmModal" class="fixed inset-0 z-10 w-screen overflow-y-auto">
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
                  Удалить запись?
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    Вы уверены, что хотите удалить эту запись? Удалённые записи восстановлению не подлежат.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <form
              :action="`expenses/delete?id=${deleteItemId}`"
              method="POST"
            >
              <input type="hidden" name="_method" value="DELETE">
              <button
                type="submit"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
              >
                Удалить
              </button>
            </form>
            <button
              type="button"
              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
              @click="closeDeleteConfirmModal"
            >
              Отмена
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Модалка изменения -->
  <div
    class="relative z-10 hidden"
    :class="{
      hidden: !isEditModalOpen
    }"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true">

    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
      aria-hidden="true">
    </div>

    <div @click="closeEditModal" class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div @click.stop class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <form
              :action="`/expenses/edit?id=${editItemShape.id}`"
              method="POST"
            >
              <input type="hidden" name="_method" value="put">
              <input
                :value="editItemShape.id"
                type="hidden"
                name="expense_id"
              >

              <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                  <h2 class="text-base font-semibold leading-7 text-gray-900">
                    Редактирование записи
                  </h2>
                  <p class="mt-1 text-sm leading-6 text-gray-600">
                    Информация о записи будет обновлена 
                  </p>

                  <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                      <label for="expense_title" class="block text-sm font-medium leading-6 text-gray-900">
                        Название расхода
                      </label>
                      <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                          <input
                            x-model="editItemShape.title"
                            type="text"
                            name="expense_title"
                            id="expense_title"
                            autocomplete="expense_title"
                            class="px-2 block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="На покушоц...">
                        </div>
                      </div>
                    </div>

                    <div class="sm:col-span-4">
                      <label for="expense_price" class="block text-sm font-medium leading-6 text-gray-900">
                        Стоимость
                      </label>
                      <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                          <input
                            x-model="editItemShape.price"
                            type="text"
                            name="expense_price"
                            id="expense_price"
                            autocomplete="expense_price"
                            class="px-2 block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="500₽">
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
                          x-model="editItemShape.description"
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
                        <select
                          x-model="editItemShape.category_id"
                          id="expense_category"
                          name="expense_category"
                          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                        >
                          <?php foreach ($tags as $tag): ?>
                            <option value="<?= $tag['id'] ?>">
                              <?= $tag['title'] ?>
                            </option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-6 flex items-center justify-end gap-x-6">
                <button
                  @click="closeEditModal"
                  type="button"
                  class="text-sm font-semibold leading-6 text-gray-900">
                  Отмена
                </button>

                <button
                  type="submit"
                  class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:pointer-events-none disabled:opacity-50"
                >
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