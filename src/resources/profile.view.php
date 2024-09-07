<?php includeComponent("header.php") ?>

<div
  class="p-6"
  x-data="{
    basicData: {
      username: '<?= $user['full_name'] ?>',
      email: '<?= $user['email'] ?>',
      avatarUrl: '<?= $user['avatar_url'] ?>'
    },
    editData: {
      username: '<?= $user['full_name'] ?>',
      email: '<?= $user['email'] ?>',
      avatarUrl: '<?= $user['avatar_url'] ?>'
    },
    handleAvatarUpload(event) {
      const file = event.target.files.item(0);
      const avatarUrl = URL.createObjectURL(file);

      this.editData.avatarUrl = avatarUrl;
    },

    isRecoverPasswordConfirmModalVisible: false,

    openRecoverPasswordConfirmModal() {
      this.isRecoverPasswordConfirmModalVisible = true;
    },

    closeRecoverPasswordConfirmModal() {
      this.isRecoverPasswordConfirmModalVisible = false;
    },

    get isSubmitDisabled() {
      let result = true;

      for (const key in this.editData) {
        if (this.basicData[key] !== this.editData[key].trim()) {
          result = false;
        }
      }

      return result;
    }
  }"
>
  <form
    action="/profile/update?id=<?= $user['id'] ?>"
    method="POST"
    enctype="multipart/form-data"
  >
    <input type="hidden" name="_method" value="patch">

    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">
          Профиль пользователя <?= $user['full_name'] ?>
        </h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">
          Данная информация видна только вам.
        </p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">
              Имя пользователя
            </label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input
                  x-model="editData.username"
                  value="<?= $user['full_name'] ?>"
                  type="text"
                  name="username"
                  id="username"
                  autocomplete="username"
                  class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                  placeholder="Ваше имя"
                >
              </div>
            </div>
          </div>

          <div class="sm:col-span-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
              Почта
            </label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input
                  x-model="editData.email"
                  value="<?= $user['email'] ?>"
                  type="text"
                  name="email"
                  id="email"
                  autocomplete="email"
                  class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                  placeholder="Ваша почта"
                >
              </div>
            </div>
          </div>

          <div class="col-span-full">
            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">
              Аватар
            </label>
            <div class="mt-2 flex items-center gap-x-3">
              <img
                :src="editData.avatarUrl"
                :alt="basicData.username"
                class="w-[60px] h-[60px] rounded-[50%] object-cover"
              > 
              <button
                type="button"
                class="relative rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-pointer"
              >
                <input
                  type="file"
                  name="avatar"
                  class="opacity-0 absolute left-0 top-0 w-[100%] h-[100%] cursor-pointer"
                  @change="handleAvatarUpload"
                >
                Изменить
              </button>
            </div>
          </div>

          <div class="sm:col-span-4">
            <div class="block text-sm font-medium leading-6 text-gray-900">
              Смена пароля
            </div>
            <div class="mt-2">
            <button
              <?= $isRecoveringPassword ? 'disabled' : '' ?>
              type="button"
              class="flex gap-x-3 rounded-md bg-blue-800 text-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-blue-500 active:opacity-50 disabled:pointer-events-none disabled:bg-gray-500 disabled:opacity-50"
              @click="openRecoverPasswordConfirmModal"
            >
              <i class="bi bi-shield-fill-exclamation"></i>
              Изменить пароль
            </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($isRecoveringPassword): ?>
      <div class="mt-5">
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
          <span class="font-medium">
            Изменения пароля.
          </span>
          Письмо для изменения пароля было отослано на почту

          <span class="font-medium underline text-gray-700">
            <?= htmlspecialchars($user['email']) ?>
          </span>
        </div>
      </div>
    <?php endif ?>

    <?php if (getFlushMessage('profile_success_message')): ?>
      <div class="mt-5">
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
          <span class="font-medium">
            <?= getFlushMessage('profile_success_message') ?>
          </span>
        </div>
      </div>
    <?php endif ?>

    <div class="mt-5">
      <button
        :disabled="isSubmitDisabled"
        type="submit"
        class="rounded-md bg-blue-800 text-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-blue-500 active:opacity-50 disabled:pointer-events-none disabled:bg-gray-500 disabled:opacity-50"
      >
        Применить изменения
      </button>
    </div>
  </form>

  <!-- Модалка подтверждения восстановления пароля -->
  <div
    :class="{
      hidden: !isRecoverPasswordConfirmModalVisible
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

    <div @click="closeRecoverPasswordConfirmModal" class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        
        <div @click.stop class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                  Изменить пароль?
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    На Вашу почту будет прислано письмо с страницей изменения пароля.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <form
              action="/profile/recover-password"
              method="POST"
            >
              <button
                type="submit"
                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto"
              >
                Отправить письмо
              </button>
            </form>
            <button
              type="button"
              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
              @click="closeRecoverPasswordConfirmModal"
            >
              Отмена
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php includeComponent("footer.php") ?>