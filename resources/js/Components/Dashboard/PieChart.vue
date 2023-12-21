<script setup>
import { ref } from "vue";
import { Chart, Tooltip, Pie } from "vue3-charts";

defineProps(["total_tasks_total_done"]);

const axis = ref({
  primary: {
    domain: [0, 0],
    type: "band",
  },
  secondary: {
    domain: [0, 0],
    type: "linear",
  },
});

const margin = ref({
  left: Math.round((600 - 360) / 2),
  top: 20,
  right: 0,
  bottom: 20,
});
</script>

<template>
  <Chart
    class="text-transparent"
    direction="circular"
    :size="{ width: 500, height: 400 }"
    :data="total_tasks_total_done"
    :margin="margin"
    :axis="axis"
    :config="{ controlHover: false }"
  >
    <template #layers>
      <Pie
        :dataKeys="['name', 'total']"
        :pie-style="{ innerRadius: 100, padAngle: 0.05 }"
      />
    </template>
    <template #widgets>
      <Tooltip
        :config="{
          name: {},
          total: {},
        }"
      />
    </template>
  </Chart>
</template>
