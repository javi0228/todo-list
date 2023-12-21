<template>
  <AuthenticatedLayout>
    <Head title="Tasks" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Tasks
      </h2>
    </template>

    <div v-can:create-task>
      <PrimaryButton @click="toogleModal(true)">add Task</PrimaryButton>
    </div>

    <div class="p-6 text-gray-900 dark:text-gray-100">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-if="tasks.length">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3 text-center">Done</th>
              <th scope="col" class="px-6 py-3">Title</th>
              <th scope="col" class="px-6 py-3" v-can:create-task>User</th>
              <th scope="col" class="px-6 py-3 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="task in tasks"
              class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
            >
              <td class="text-center">
                <input
                  class="rounded p-3 text-green-700 focus:outline-none focus:border-none focus:ring-0 shadow-inner shadow-green-300 cursor-pointer"
                  type="checkbox"
                  @click="changeDone(task)"
                  :checked="task.done"
                />
              </td>
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ task.title }}
              </th>
              <td class="px-6 py-4" v-can:create-task>
                {{ task.user.name }}
              </td>
              <td class="px-6 py-4 flex flex-row justify-center items-center gap-4">
                <!-- Trash icon -->
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6 text-red-500 cursor-pointer"
                  @click="removeTask(task.id)"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                  />
                </svg>

                <!-- Edit icon -->
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6 text-yellow-500 cursor-pointer"
                  @click="toogleModal(true, task)"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                  />
                </svg>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p>There is no tasks.</p>
      </div>
    </div>

    <!-- Create/edit task modal -->
    <Modal :closeable="false" :show="showModal" @close="toogleModal(false)">
      <div class="p-4 flex flex-col justify-between space-y-10">
        <!-- Header -->
        <div class="flex justify-between font-bold items-center dark:text-gray-200">
          <!-- Modal title -->
          <h2 class="text-2xl">{{ title }}</h2>
          <!-- close button -->
          <svg
            @click="toogleModal(false)"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="close"
            class="w-6 h-6 cursor-pointer"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </div>
        <!-- Body -->
        <div class="flex justify-between gap-4">
          <!-- Task title -->
          <div class="w-full">
            <InputLabel for="task-title">Task title</InputLabel>
            <TextInput
              v-model="form.title"
              id="task-title"
              placeholder="Go shopping"
              class="w-full"
            />
            <InputError class="mt-2" :message="form.errors.title" />
          </div>
          <!-- User select -->
          <div class="w-full">
            <InputLabel for="user-id">Select an user</InputLabel>
            <SearchableSelect id="user-id" :data="users" v-model="form.user_id" />
            <InputError class="mt-2" :message="form.errors.user_id" />
          </div>
        </div>

        <!-- Footer -->
        <div class="flex mx-auto gap-8">
          <SaveButton @click="save">Save</SaveButton>
          <CancelButton @click="toogleModal(false)">Cancel</CancelButton>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import SaveButton from "@/Components/SaveButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import SearchableSelect from "@/Components/SearchableSelect.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

// Component props
const props = defineProps({
  tasks: {
    type: Object,
  },
  users: {
    type: Object,
  },
});

const showModal = ref(false);

const title = ref("Create task");
// If operation=1 user is inserting else updating
var operation = 1;

const form = useForm({
  id: null,
  title: "",
  user_id: null,
  done: false,
});

const toogleModal = (action, task = null) => {
  form.reset();
  form.clearErrors();
  if (task) {
    form.done = task.done;

    setTask(task);
  } else {
    operation = 1;
  }
  showModal.value = action;
};

const setTask = (task) => {
  // Fill form data to update task
  form.title = task.title;
  form.user_id = task.user.id;
  form.id = task.id;
  // Set operation to update
  operation = 0;
};

const removeTask = (task_id) => {
  router.delete("task/" + task_id);
};

const changeDone = (task) => {
  form.done = !task.done;
  setTask(task);
  save(task.id);
};

const save = () => {
  operation === 1
    ? form.post("task", {
        onSuccess: () => {
          toogleModal(false);
        },
        onError: (err) => {},
      })
    : form.patch("task/" + form.id, {
        onSuccess: () => {
          toogleModal(false);
        },
      });
};
</script>
