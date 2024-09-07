<?php includeComponent("header.php") ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Expense tracker">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
      Смена пароля
    </h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form
      class="space-y-6"
      action="/profile/change-password"
      method="POST"
      autocomplete="off"

      x-data="{
        password: '',

        errors: {
          password: '<?= getFlushMessage('error_recover_password') ?>'
        },

        checkPassword() {
          if (!this.password) {
            this.errors.password = 'Введите пароль!';
          } else {
            delete this.errors.password
          }
        },

        get hasErrors() {
          return Boolean(Object.keys(this.errors).length);
        },

        get isSubmitButtonDisabled() {
          const isSomeEmpty = !this.password;

          return isSomeEmpty || this.hasErrors;
        }
      }"
    >
      <div>
        <label class="block text-sm font-medium leading-6 text-gray-900">
          Электронная почта (не активно)
        </label>
        <div class="mt-2 mb-2">
          <input
            disabled
            value="<?= $user['email'] ?>"
            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
            Пароль
          </label>
        </div>
        <div class="mt-2 mb-2">
          <input
            x-model="password"
            @blur="checkPassword"
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
        </div>

        <span
          x-show="errors.password"
          x-text="errors.password"
          class="text-red-500 text-sm"
        >
        </span>
      </div>

      <div>
        <button
          x-cloak
          :disabled="isSubmitButtonDisabled"
          type="submit"
          class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-30 disabled:pointer-events-none"
        >
          Изменить пароль
        </button>
      </div>
    </form>
  </div>
</div>

<?php includeComponent("footer.php") ?>
