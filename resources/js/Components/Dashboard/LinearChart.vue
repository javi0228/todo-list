<script setup>
import { ref } from "vue";
import { Chart, Grid, Line, Tooltip } from "vue3-charts";

defineProps(["task_by_date"]);

const axis = ref({
  primary: {
    type: "band",
  },
  secondary: {
    domain: ["dataMin", "dataMax + 5"],
    type: "linear",
    ticks: 5,
  },
});

const margin = ref({
  left: 0,
  top: 10,
  right: 20,
  bottom: 0,
});
</script>

<template>
  <Chart
    :size="{ width: 500, height: 400 }"
    :data="task_by_date"
    :margin="margin"
    :direction="'horizontal'"
    :axis="axis"
  >
    <template #layers>
      <Grid strokeDasharray="2,2" />
      <Line :dataKeys="['date', 'count']" />
    </template>

    <template #widgets>
      <Tooltip
        borderColor="#48CAE4"
        :config="{
          date: { color: '#9f7aea' },
          user: { hide: true },
        }"
      />
    </template>
  </Chart>
</template>
