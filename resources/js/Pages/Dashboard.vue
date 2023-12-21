<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import LinearChart from "@/Components/Dashboard/LinearChart.vue";
import PieChart from "@/Components/Dashboard/PieChart.vue";

const props = defineProps({
  task_by_date: {
    required: true,
    type: Array,
  },
  total_tasks_total_done: {
    required: true,
    type: Array,
  },
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Dashboard
      </h2>
    </template>

    <div
      class="p-6 text-gray-900 dark:text-gray-400 flex flex-wrap gap-6 justify-center items-center"
    >
      <!-- Quick info -->
      <div class="w-full flex gap-10 items-center justify-center">
        <!-- Total tasks -->
        <div
          class="rounded-xl flex items-center justify-center text-white text-lg border-gray-500 border bg-gradient-to-r from-cyan-500 to-blue-500 p-2 w-40 h-20 text-center"
        >
          <p>
            Total tasks:
            <span class="font-bold"> {{ total_tasks_total_done[1].total }}</span>
          </p>
        </div>

        <!-- Undoned tasks -->
        <div
          class="rounded-xl flex items-center justify-center text-white text-lg border-gray-500 border bg-gradient-to-r from-red-500 to-red-600 p-2 w-40 h-20 text-center"
        >
          <p>
            Undoned tasks:
            <span class="font-bold"> {{ total_tasks_total_done[1].total- total_tasks_total_done[0].total }}</span>
          </p>
        </div>
      </div>
      <div>
        <p class="text-center">Tasks created grouped by date</p>
        <!-- Total tasks created group by date -->
        <LinearChart :task_by_date="task_by_date" />
      </div>

      <div>
        <p class="text-center">Comparison between total tasks and done tasks</p>
        <!-- Comparison between total tasks and done tasks -->
        <PieChart :total_tasks_total_done="total_tasks_total_done" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
