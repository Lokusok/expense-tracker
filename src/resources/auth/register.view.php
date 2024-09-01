<?php includeComponent("header.php") ?>
<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<?php var_dump(getFlushMessage('old_email')) ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
      Регистрация в Expense Tracker
    </h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form
      class="space-y-6"
      action="/register"
      method="POST"
      autocomplete="off"

      x-data="{
        email: '<?= getFlushMessage('old_email') ?>',
        username: '<?= getFlushMessage('old_username') ?>',
        password: '',
        passwordConfirm: '',

        errors: {
          email: '<?= getFlushMessage('error_email') ?>',
          username: '<?= getFlushMessage('error_username') ?>',
          password: '<?= getFlushMessage('error_password') ?>',
        },

        checkUsername() {
          if (!this.username) {
            this.errors.username = 'Введите имя!';
          } else {
            this.errors.username = '';
          }
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
              this.errors.email = '';
            }
          }
        },

        checkPasswords() {
          if (!this.password) {
            this.errors.password = 'Введите пароль!';
          } else {
            const isPasswordsEqual = this.password === this.passwordConfirm;

            if (!isPasswordsEqual) {
              this.errors.password = 'Пароли не равны!';
            } else {
              this.errors.password = '';
            }
          }
        },

        get hasErrors() {
          let result = false;

          for (const key in this.errors) {
            if (this.errors[key]) {
              result = true;
              break;
            }
          }

          return result;
        },

        get isSubmitButtonDisabled() {
          const isSomeEmpty = !this.email || !this.password || !this.passwordConfirm;
          const isPasswordsNotEqual = this.password !== this.passwordConfirm;

          return isSomeEmpty || isPasswordsNotEqual || this.hasErrors;
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
            type="text"
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
      <label for="username" class="block text-sm font-medium leading-6 text-gray-900">
          Ваше имя
        </label>
        <div class="mt-2 mb-2">
          <input
            x-model="username"
            @blur="checkUsername"
            id="username"
            name="username"
            type="text"
            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
        </div>

        <span
          x-show="errors.username"
          x-text="errors.username"
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
            @blur="checkPasswords"
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
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
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
            Подтвердите пароль
          </label>
        </div>
        <div class="mt-2">
          <input
            x-model="passwordConfirm"
            @blur="checkPasswords"
            id="password"
            name="password_confirmation"
            type="password"
            autocomplete="current-password"
            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          >
        </div>
      </div>

      <div>
        <button
          x-cloak
          :disabled="isSubmitButtonDisabled"
          type="submit"
          class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-30 disabled:pointer-events-none"
        >
          Регистрация
        </button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
      Уже есть аккаунт?
      <a href="/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Войдите сейчас</a>
    </p>
  </div>
</div>

<?php includeComponent("footer.php") ?>