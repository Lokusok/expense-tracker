<?php includeComponent("header.php") ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Expense tracker">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
      Вход в Expense Tracker
    </h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form
      class="space-y-6"
      action="/login"
      method="POST"
      autocomplete="off"

      x-data="{
        email: '<?= getFlushMessage('old_login_email') ?>',
        password: '',

        errors: {
          email: '<?= getFlushMessage('error_login_email') ?>',
          password: '<?= getFlushMessage('error_login_password') ?>'
        },

        checkEmail() {
          if (!this.email) {
            this.errors.email = 'Введите почту!';
          } else {
            const emailRegex = new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, 'gm');
            const isValidEmail = emailRegex.test(this.email);

            if (!isValidEmail) {
              this.errors.email = 'Не валидная почта!';
            } else {
              delete this.errors.email;
            }
          }
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
          const isSomeEmpty = !this.email || !this.password;

          return isSomeEmpty || this.hasErrors;
        }
      }"
    >
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
          Электронная почта
        </label>
        <div class="mt-2 mb-2">
          <input
            x-model="email"
            @blur="checkEmail"
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
        </div>

        <span
          x-show="errors.email"
          x-text="errors.email"
          class="text-red-500 text-sm"
        >
        </span>
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
          Вход
        </button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
      Нет аккаунта?
      <a href="/register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
        Регистрация
      </a>
    </p>
  </div>
</div>

<?php includeComponent("footer.php") ?>